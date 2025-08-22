<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%reminder}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $medicine_id
 * @property string $times
 * @property string $begin_date
 * @property string|null $finish_date
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Medicine $medicine
 * @property MedicineIntakeLog[] $medicineIntakeLogs
 * @property User $user
 */
class Reminder extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reminder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finish_date', 'comment', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'medicine_id', 'times', 'begin_date'], 'required'],
            [['user_id', 'medicine_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'medicine_id', 'created_at', 'updated_at'], 'integer'],
            [['times', 'begin_date', 'finish_date'], 'safe'],
            [['comment'], 'string'],
            [['medicine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medicine::class, 'targetAttribute' => ['medicine_id' => 'id']],
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
            'times' => 'Times',
            'begin_date' => 'Begin Date',
            'finish_date' => 'Finish Date',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[MedicineIntakeLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineIntakeLogs()
    {
        return $this->hasMany(MedicineIntakeLog::class, ['reminder_id' => 'id']);
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
