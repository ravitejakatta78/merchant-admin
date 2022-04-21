<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tablename".
 *
 * @property int $ID
 * @property string $merchant_id
 * @property string $name
 * @property int $capacity
 * @property string $status 0=pending,1=active,2-failed
 * @property int|null $table_status
 * @property int|null $current_order_id
 * @property string $reg_date
 * @property string $mod_date
 */
class Tablename extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tablename';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'name', 'capacity', 'status', 'reg_date'], 'required'],
            [['capacity', 'table_status', 'current_order_id'], 'integer'],
            [['status'], 'string'],
            [['mod_date'], 'safe'],
            [['merchant_id', 'name'], 'string', 'max' => 50],
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
            'merchant_id' => 'Merchant ID',
            'name' => 'Name',
            'capacity' => 'Capacity',
            'status' => 'Status',
            'table_status' => 'Table Status',
            'current_order_id' => 'Current Order ID',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
