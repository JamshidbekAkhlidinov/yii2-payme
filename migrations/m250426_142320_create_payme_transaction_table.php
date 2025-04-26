<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payme_transaction}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%order}}`
 */
class m250426_142320_create_payme_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payme_transaction}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'transaction_id' => $this->string(),
            'amount' => $this->double(),
            'created_at' => $this->datetime(),
            'perform_at' => $this->datetime(),
        ]);

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-payme_transaction-order_id}}',
            '{{%payme_transaction}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-payme_transaction-order_id}}',
            '{{%payme_transaction}}',
            'order_id',
            '{{%order}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-payme_transaction-order_id}}',
            '{{%payme_transaction}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-payme_transaction-order_id}}',
            '{{%payme_transaction}}'
        );

        $this->dropTable('{{%payme_transaction}}');
    }
}
