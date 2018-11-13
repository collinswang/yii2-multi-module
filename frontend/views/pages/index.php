<?php
/**
 *
 * User: collins
 * Date: 18-11-13
 */

use yii\helpers\Url;
use \yii\helpers\Html;

$this->params['breadcrumbs'][] = 'Index';
?>
<?=$this->render('header');?>
<h1>Hello World!</h1>
<?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<ul>
    <li>
        <?=Html::a('about us',  Url::toRoute(['page', 'view'=>'about']))?>
    </li>
    <li>
        <?=Html::a('Login',  Url::toRoute(['/site/login']))?>
    </li>
    <li>
        <?=Html::a('UserCenter',  Url::toRoute(['/user/index']))?>
    </li>
</ul>
<?=$this->render('footer');?>
