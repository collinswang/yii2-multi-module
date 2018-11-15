<?php
/**
 *
 * User: collins
 * Date: 18-11-13
 */
$this->params['breadcrumbs'][] = 'Pages';
?>
<?=$this->render('header');?>
    <h1>Hello World2222!</h1>
<?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<?=$this->render('footer');?>
