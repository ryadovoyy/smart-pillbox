<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reminder}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%medicine}}`
 */
class m250822_081329_create_reminder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reminder}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'medicine_id' => $this->bigInteger()->notNull(),
            'times' => 'time[] NOT NULL',
            'begin_date' => $this->date()->notNull(),
            'finish_date' => $this->date(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-reminder-user_id}}',
            '{{%reminder}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-reminder-user_id}}',
            '{{%reminder}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `medicine_id`
        $this->createIndex(
            '{{%idx-reminder-medicine_id}}',
            '{{%reminder}}',
            'medicine_id'
        );

        // add foreign key for table `{{%medicine}}`
        $this->addForeignKey(
            '{{%fk-reminder-medicine_id}}',
            '{{%reminder}}',
            'medicine_id',
            '{{%medicine}}',
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
            '{{%fk-reminder-user_id}}',
            '{{%reminder}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-reminder-user_id}}',
            '{{%reminder}}'
        );

        // drops foreign key for table `{{%medicine}}`
        $this->dropForeignKey(
            '{{%fk-reminder-medicine_id}}',
            '{{%reminder}}'
        );

        // drops index for column `medicine_id`
        $this->dropIndex(
            '{{%idx-reminder-medicine_id}}',
            '{{%reminder}}'
        );

        $this->dropTable('{{%reminder}}');
    }
}
