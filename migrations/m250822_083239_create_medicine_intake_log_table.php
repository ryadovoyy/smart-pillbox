<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medicine_intake_log}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%medicine}}`
 * - `{{%reminder}}`
 */
class m250822_083239_create_medicine_intake_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medicine_intake_log}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'medicine_id' => $this->bigInteger()->notNull(),
            'reminder_id' => $this->bigInteger(),
            'scheduled_date' => $this->date()->notNull(),
            'scheduled_time' => $this->time()->notNull(),
            'taken_at' => $this->dateTime()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-medicine_intake_log-user_id}}',
            '{{%medicine_intake_log}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-medicine_intake_log-user_id}}',
            '{{%medicine_intake_log}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `medicine_id`
        $this->createIndex(
            '{{%idx-medicine_intake_log-medicine_id}}',
            '{{%medicine_intake_log}}',
            'medicine_id'
        );

        // add foreign key for table `{{%medicine}}`
        $this->addForeignKey(
            '{{%fk-medicine_intake_log-medicine_id}}',
            '{{%medicine_intake_log}}',
            'medicine_id',
            '{{%medicine}}',
            'id',
            'CASCADE'
        );

        // creates index for column `reminder_id`
        $this->createIndex(
            '{{%idx-medicine_intake_log-reminder_id}}',
            '{{%medicine_intake_log}}',
            'reminder_id'
        );

        // add foreign key for table `{{%reminder}}`
        $this->addForeignKey(
            '{{%fk-medicine_intake_log-reminder_id}}',
            '{{%medicine_intake_log}}',
            'reminder_id',
            '{{%reminder}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-medicine_intake_log-user_id}}',
            '{{%medicine_intake_log}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-medicine_intake_log-user_id}}',
            '{{%medicine_intake_log}}'
        );

        // drops foreign key for table `{{%medicine}}`
        $this->dropForeignKey(
            '{{%fk-medicine_intake_log-medicine_id}}',
            '{{%medicine_intake_log}}'
        );

        // drops index for column `medicine_id`
        $this->dropIndex(
            '{{%idx-medicine_intake_log-medicine_id}}',
            '{{%medicine_intake_log}}'
        );

        // drops foreign key for table `{{%reminder}}`
        $this->dropForeignKey(
            '{{%fk-medicine_intake_log-reminder_id}}',
            '{{%medicine_intake_log}}'
        );

        // drops index for column `reminder_id`
        $this->dropIndex(
            '{{%idx-medicine_intake_log-reminder_id}}',
            '{{%medicine_intake_log}}'
        );

        $this->dropTable('{{%medicine_intake_log}}');
    }
}
