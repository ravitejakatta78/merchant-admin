<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_group".
 *
 * @property int $ID
 * @property int $parent_id
 * @property int $child_id
 * @property int $status
 * @property string $reg_date
 */
class MerchantGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id', 'reg_date'], 'required'],
            [['parent_id', 'child_id', 'status'], 'integer'],
            [['reg_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
            'status' => 'Status',
            'reg_date' => 'Reg Date',
        ];
    }
}
