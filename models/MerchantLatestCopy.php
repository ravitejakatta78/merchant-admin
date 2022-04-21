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
 * @property string $reg_date
 * @property string $mod_date
 */
class Merchant extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
		public $newpassword;
	public $confirmpassword;
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
			, 'address', 'state', 'city', 'location', 'latitude', 'longitude'], 'required'],
            [['password', 'mobile', 'storetype', 'storename', 'address', 'state', 'city', 'location'
			, 'latitude', 'longitude',   'status', 'recommend', 'verify', 'description'
			, 'servingtype', 'plan', 'useraccess'], 'string'],
			[['logo','qrlogo','coverpic'], 'file', 'extensions' => ['png', 'jpg', 'gif']],
            [['otp'], 'integer'],
			[['password'], 'pwdequalcheck', 'on' => 'chagepassword'],
            [['mod_date'], 'safe'],
            [['user_id', 'unique_id', 'name', 'email'], 'string', 'max' => 50],
            [['reg_date'], 'string', 'max' => 20],
			[['newpassword', 'confirmpassword'], 'required', 'on' => 'chagepassword'],
			[['newpassword','confirmpassword'], 'string','min'=>4, 'max' => 255, 'on' => 'chagepassword'],
			['confirmpassword', 'compare', 'compareAttribute' => 'newpassword', 'on' => 'chagepassword'],
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
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
/**
     * {@inheritdoc}
     */
	 public function pwdequalcheck($attribute, $params, $validator){

        $user_id = Yii::$app->user->identity->ID;
        $user_det =  \app\models\Merchant::findOne($user_id);
        if (password_verify($this->$attribute, $user_det->password)) {
   
        } else {

             $this->addError($attribute, 'Incorrect password');
        } 
    }
	
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByUsername($username)
    {       
                return static::findOne(['email' => $username]);

    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->ID;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    //    return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
      //  return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
	 if (password_verify($password, $this->password)) {
             return true;   
        } else {
             return false;
        } 
       // $md5Password = md5($password);
       // return $this->password === $password;
    }
}
