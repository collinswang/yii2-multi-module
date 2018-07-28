<?php

namespace backend\controllers;

use Yii;
use common\modules\sms\models\SmsSearch;
use common\modules\sms\models\Sms;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\ViewAction;
use \common\modules\sms\data\SmsTemplateData;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new SmsSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => Sms::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Sms::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Sms::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Sms::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Sms::className(),
            ],
        ];
    }

    /**
     * 获取指定类型的模板列表
     * @example ['get-template-list']
     * @param $type
     * @return array
     */
    public function actionGetTemplateList($type)
    {
        $model_template = new SmsTemplateData();
        $template_list = $model_template->getList($type);
        return $template_list;
    }
}
