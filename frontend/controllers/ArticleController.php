<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:48
 */

namespace frontend\controllers;

use yii;
use common\libs\Constants;
use frontend\models\form\ArticlePasswordForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use frontend\models\Article;
use common\models\Category;
use frontend\models\Comment;
use yii\data\ActiveDataProvider;
use common\models\meta\ArticleMetaLike;
use yii\web\NotFoundHttpException;
use yii\filters\HttpCache;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\XmlResponseFormatter;

class ArticleController extends BaseController
{


    public function behaviors()
    {
        return [
            [
                'class' => HttpCache::className(),
                'only' => ['view'],
                'lastModified' => function ($action, $params) {
                    $id = yii::$app->getRequest()->get('id');
                    $model = Article::findOne(['id' => $id, 'type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED]);
                    if( $model === null ) throw new NotFoundHttpException(yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
                    Article::updateAllCounters(['scan_count' => 1], ['id' => $id]);
                    if($model->visibility == Constants::ARTICLE_VISIBILITY_PUBLIC) return $model->updated_at;
                },
            ],
        ];
    }

    /**
     * 分类列表页
     *
     * @param string $cat 分类名称
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($cat = '', $page = 1)
    {
        if ($cat == '') {
            $cat = yii::$app->getRequest()->getPathInfo();
        }
        $where = ['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED];
        if ($cat != '' && $cat != 'index') {
            if ($cat == yii::t('app', 'uncategoried')) {
                $where['cid'] = 0;
            } else {
                if (! $category = Category::findOne(['alias' => $cat])) {
                    throw new NotFoundHttpException(yii::t('frontend', 'None category named {name}', ['name' => $cat]));
                }
                $descendants = Category::getDescendants($category['id']);
                if( empty($descendants) ) {
                    $where['cid'] = $category['id'];
                }else{
                    $cids = ArrayHelper::getColumn($descendants, 'id');
                    $cids[] = $category['id'];
                    $where['cid'] = $cids;
                }
            }
        }
        $query = Article::find()->with('category')->where($where);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'page'=> $page-1, 'pageSize'=>2]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('index', [
            'pagination' => $pages,
            'list' => $models,
        ]);
    }

    /**
     * 文章详情
     *
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::findOne(['id' => $id, 'type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED]);
        if( $model === null ) throw new NotFoundHttpException(yii::t("frontend", "Article id {id} is not exists", ['id' => $id]));
        $prev = Article::find()
            ->where(['cid' => $model->cid])
            ->andWhere(['>', 'id', $id])
            ->orderBy("sort asc,created_at desc,id desc")
            ->limit(1)
            ->one();
        $next = Article::find()
            ->where(['cid' => $model->cid])
            ->andWhere(['<', 'id', $id])
            ->orderBy("sort desc,created_at desc,id asc")
            ->limit(1)
            ->one();//->createCommand()->getRawSql();

        $recommends = Article::find()
            ->where(['type' => Article::ARTICLE, 'status' => Article::ARTICLE_PUBLISHED])
            ->orderBy("rand()")
            ->limit(8)
            ->all();

        return $this->renderPartial('view', [
            'model' => $model,
            'prev' => $prev,
            'next' => $next,
            'recommends' => $recommends,
        ]);
    }


    /**
     * rss订阅
     *
     * @return mixed
     */
    public function actionRss()
    {
        $xml['channel']['title'] = yii::$app->feehi->website_title;
        $xml['channel']['description'] = yii::$app->feehi->seo_description;
        $xml['channel']['lin'] = yii::$app->getUrlManager()->getHostInfo();
        $xml['channel']['generator'] = yii::$app->getUrlManager()->getHostInfo();
        $models = Article::find()->limit(10)->where(['status'=>Article::ARTICLE_PUBLISHED, 'type'=>Article::ARTICLE])->orderBy('id desc')->all();
        foreach ($models as $model){
            $xml['channel']['item'][] = [
                'title' => $model->title,
                'link' => Url::to(['article/view', 'id'=>$model->id]),
                'pubData' => date('Y-m-d H:i:s', $model->created_at),
                'source' => yii::$app->feehi->website_title,
                'author' => $model->author_name,
                'description' => $model->summary,
            ];
        }
        yii::configure(yii::$app->getResponse(), [
            'formatters' => [
                Response::FORMAT_XML => [
                    'class' => XmlResponseFormatter::className(),
                    'rootTag' => 'rss',
                    'version' => '1.0',
                    'encoding' => 'utf-8'
                ]
            ]
        ]);
        yii::$app->getResponse()->format = Response::FORMAT_XML;
        return $xml;
    }

}