<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant".
 *
 * @property int $ID
 * @property string $user_id
 * @property string $unique_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $storetype
 * @property string $storename
 * @property string $address
 * @property string $state
 * @property string $city
 * @property string $location
 * @property string $logo
 * @property string $latitude
 * @property string $longitude
 * @property string $qrlogo
 * @property string $coverpic
 * @property string $status 0=pending,1=active,2-failed
 * @property int $otp
 * @property string $recommend
 * @property string $verify 0=pending,1=verify
 * @property string $description
 * @property string $servingtype
 * @property string $plan
 * @property string $useraccess
 * @property float $scan_range
 * @property string $reg_date
 * @property string $mod_date
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'unique_id', 'name', 'email', 'password', 'mobile', 'storetype', 'storename'
			, 'address', 'state', 'city', 'location', 'latitude', 'longitude', 'description', 'servingtype', 'scan_range', 'description'], 'required'],
            [['password', 'mobile', 'storetype', 'storename', 'address', 'state', 'city', 'location', 'logo', 'latitude', 'longitude', 'qrlogo', 'coverpic', 'status', 'recommend', 'verify', 'description', 'servingtype', 'plan', 'useraccess'], 'string'],
            [['otp'], 'integer'],
            [['scan_range'], 'number'],
            [['mod_date'], 'safe'],
            [['user_id', 'unique_id', 'name', 'email'], 'string', 'max' => 50],
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
            'user_id' => 'User ID',
            'unique_id' => 'Unique ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'storetype' => 'Storetype',
            'storename' => 'Storename',
            'address' => 'Address',
            'state' => 'State',
            'city' => 'City',
            'location' => 'Location',
            'logo' => 'Logo',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'qrlogo' => 'Qrlogo',
            'coverpic' => 'Coverpic',
            'status' => 'Status',
            'otp' => 'Otp',
            'recommend' => 'Recommend',
            'verify' => 'Verify',
            'description' => 'Description',
            'servingtype' => 'Servingtype',
            'plan' => 'Plan',
            'useraccess' => 'Useraccess',
            'scan_range' => 'Scan Range',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
