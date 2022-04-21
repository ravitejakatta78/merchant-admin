<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "othernotifications".
 *
 * @property int $ID
 * @property int $notification_type
 * @property string $admin_id
 * @property string $title
 * @property string $message
 * @property string $image
 * @property string $reg_date
 * @property string $mod_date
 */
class Othernotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'othernotifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_type', 'admin_id', 'title', 'message', 'image', 'reg_date'], 'required'],
            [['notification_type'], 'integer'],
            [['message', 'image'], 'string'],
            [['mod_date'], 'safe'],
            [['admin_id', 'title'], 'string', 'max' => 30],
            [['reg_date'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'notification_type' => 'Notification Type',
            'admin_id' => 'Admin ID',
            'title' => 'Title',
            'message' => 'Message',
            'image' => 'Image',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
