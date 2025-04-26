<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payme_transaction".
 *
 * @property int $id
 * @property int|null $order_id
 * @property string|null $transaction_id
 * @property float|null $amount
 * @property int|null $state
 * @property string|null $reason
 * @property string|null $created_at
 * @property string|null $perform_at
 * @property string|null $cancel_at
 *
 * @property Order $order
 */
class PaymeTransaction extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payme_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'transaction_id', 'amount', 'state', 'reason', 'created_at', 'perform_at', 'cancel_at'], 'default', 'value' => null],
            [['order_id', 'state'], 'integer'],
            [['amount'], 'number'],
            [['reason'], 'string'],
            [['created_at', 'perform_at', 'cancel_at'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'transaction_id' => 'Transaction ID',
            'amount' => 'Amount',
            'state' => 'State',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'perform_at' => 'Perform At',
            'cancel_at' => 'Cancel At',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

}
