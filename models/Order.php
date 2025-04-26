<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string|null $product_name
 * @property float|null $amount
 * @property string|null $created_at
 * @property int|null $payment_status
 * @property string|null $payment_at
 * @property string|null $cancel_at
 *
 * @property PaymeTransaction[] $paymeTransactions
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'amount', 'created_at', 'payment_at', 'cancel_at'], 'default', 'value' => null],
            [['payment_status'], 'default', 'value' => 0],
            [['amount'], 'number'],
            [['created_at', 'payment_at', 'cancel_at'], 'safe'],
            [['payment_status'], 'integer'],
            [['product_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'payment_status' => 'Payment Status',
            'payment_at' => 'Payment At',
            'cancel_at' => 'Cancel At',
        ];
    }

    /**
     * Gets query for [[PaymeTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymeTransactions()
    {
        return $this->hasMany(PaymeTransaction::class, ['order_id' => 'id']);
    }

}
