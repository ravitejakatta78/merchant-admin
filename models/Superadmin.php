<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "superadmin".
 *
 * @property int $ID
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $status 0=pending,1=active,2-failed
 * @property string $supportemail
 * @property string $supportmobile
 * @property string $reg_date
 * @property string $mod_date
 */
class Superadmin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'superadmin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'mobile', 'status', 'supportemail', 'supportmobile', 'reg_date'], 'required'],
            [['password', 'mobile', 'status', 'supportemail', 'supportmobile'], 'string'],
            [['mod_date'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'supportemail' => 'Supportemail',
            'supportmobile' => 'Supportmobile',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
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
