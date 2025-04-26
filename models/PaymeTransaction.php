<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payme_transaction".
 *
 * @property int $id
 * @property string|null $transaction_id
 * @property float|null $amount
 * @property string|null $created_at
 * @property string|null $perform_at
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
            [['transaction_id', 'amount', 'created_at', 'perform_at'], 'default', 'value' => null],
            [['amount'], 'number'],
            [['created_at', 'perform_at'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'perform_at' => 'Perform At',
        ];
    }

}
