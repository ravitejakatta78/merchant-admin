<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storetype_permissions".
 *
 * @property int $ID
 * @property int|null $merchant_id
 * @property int|null $store_type
 * @property int|null $permission_id
 * @property int|null $permission_status
 * @property string $created_on
 * @property string|null $created_by
 * @property string $updated_on
 * @property string|null $updated_by
 */
class StoretypePermissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storetype_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'store_type', 'permission_id', 'permission_status'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 100],
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
            'store_type' => 'Store Type',
            'permission_id' => 'Permission ID',
            'permission_status' => 'Permission Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
