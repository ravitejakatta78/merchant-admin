<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_permissions".
 *
 * @property int $ID
 * @property string $process_name
 * @property string $process_status
 * @property string $reg_date
 */
class TabPermissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['process_name', 'process_status'], 'required'],
            [['reg_date'], 'safe'],
            [['process_name', 'process_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'process_name' => 'Process Name',
            'process_status' => 'Process Status',
            'reg_date' => 'Reg Date',
        ];
    }
}
