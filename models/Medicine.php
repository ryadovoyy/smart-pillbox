<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%medicine}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $dose
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property MedicineIntakeLog[] $medicineIntakeLogs
 * @property Reminder[] $reminders
 * @property User $user
 */
class Medicine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%medicine}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dose', 'description', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'name'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'dose'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'dose' => 'Dose',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MedicineIntakeLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineIntakeLogs()
    {
        return $this->hasMany(MedicineIntakeLog::class, ['medicine_id' => 'id']);
    }

    /**
     * Gets query for [[Reminders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReminders()
    {
        return $this->hasMany(Reminder::class, ['medicine_id' => 'id']);
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
