<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PaymeTransaction $model */

$this->title = 'Update Payme Transaction: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payme Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payme-transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
