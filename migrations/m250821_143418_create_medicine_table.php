<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medicine}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m250821_143418_create_medicine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medicine}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'name' => $this->string()->notNull(),
            'dose' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-medicine-user_id}}',
            '{{%medicine}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-medicine-user_id}}',
            '{{%medicine}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-medicine-user_id}}',
            '{{%medicine}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-medicine-user_id}}',
            '{{%medicine}}'
        );

        $this->dropTable('{{%medicine}}');
    }
}
