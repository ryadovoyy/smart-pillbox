<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%medicine_intake_log}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $medicine_id
 * @property int|null $reminder_id
 * @property string $scheduled_date
 * @property string $scheduled_time
 * @property string $taken_at
 *
 * @property Medicine $medicine
 * @property Reminder $reminder
 * @property User $user
 */
class MedicineIntakeLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%medicine_intake_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_id'], 'default', 'value' => null],
            [['user_id', 'medicine_id', 'scheduled_date', 'scheduled_time', 'taken_at'], 'required'],
            [['user_id', 'medicine_id', 'reminder_id'], 'default', 'value' => null],
            [['user_id', 'medicine_id', 'reminder_id'], 'integer'],
            [['scheduled_date', 'scheduled_time', 'taken_at'], 'safe'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicine::class, 'targetAttribute' => ['medicine_id' => 'id']],
            [['reminder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reminder::class, 'targetAttribute' => ['reminder_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'medicine_id' => 'Medicine ID',
            'reminder_id' => 'Reminder ID',
            'scheduled_date' => 'Scheduled Date',
            'scheduled_time' => 'Scheduled Time',
            'taken_at' => 'Taken At',
        ];
    }

    /**
     * Gets query for [[Medicine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicine()
    {
        return $this->hasOne(Medicine::class, ['id' => 'medicine_id']);
    }

    /**
     * Gets query for [[Reminder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminder()
    {
        return $this->hasOne(Reminder::class, ['id' => 'reminder_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
