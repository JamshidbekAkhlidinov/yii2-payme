<?php

use app\models\PaymeTransaction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payme Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payme-transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
            'transaction_id',
            'amount',
            'created_at',
            'perform_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PaymeTransaction $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
