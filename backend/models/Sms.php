<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-11 09:53
 */

namespace backend\models;

use common\modules\sms\service\SmsService;
use yii;
use common\helpers\Util;
use common\libs\Constants;
use common\models\meta\ArticleMetaTag;
use \common\modules\sms\models\Sms as CommonSms;

class Sms extends CommonSms
{
    /**
     * @var string
     */
    public $tag = '';

    /**
     * @var null|string
     */
    public $content = null;

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
//        parent::afterValidate();
//        if($this->visibility == Constants::ARTICLE_VISIBILITY_SECRET){//加密文章需要设置密码
//            if( empty( $this->password ) ){
//                $this->addError('password', yii::t('app', "Secret article must set a password"));
//            }
//        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        Util::handleModelSingleFileUpload($this, 'thumb', $insert, '@thumb');
        $this->seo_keywords = str_replace('，', ',', $this->seo_keywords);
        if ($insert) {
            $this->uid = yii::$app->getUser()->getIdentity()->getId();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        print_r($changedAttributes);
        //发送

        $articleMetaTag = new ArticleMetaTag();
        $articleMetaTag->setArticleTags($this->id, $this->tag);
        if ($insert) {
            $contentModel = new ArticleContent();
            $contentModel->aid = $this->id;
        } else {
            if ($this->content === null) {
                return;
            }
            $contentModel = ArticleContent::findOne(['aid' => $this->id]);
            if ($contentModel == null) {
                $contentModel = new ArticleContent();
                $contentModel->aid = $this->id;
            }
        }
        $contentModel->content = $this->content;
        $contentModel->save();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        Comment::deleteAll(['aid' => $this->id]);
        if (($articleContentModel = ArticleContent::find()->where(['aid' => $this->id])->one()) != null) {
            $articleContentModel->delete();
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->tag = call_user_func(function(){
            $tags = '';
            foreach ($this->articleTags as $tag) {
                $tags .= $tag->value . ',';
            }
            return rtrim($tags, ',');
        });
        $this->content = ArticleContent::findOne(['aid' => $this->id])['content'];
    }

}