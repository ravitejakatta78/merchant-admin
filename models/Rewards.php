<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rewards".
 *
 * @property int $ID
 * @property string $user_id
 * @property string $title
 * @property string $excerpt
 * @property int $coins
 * @property string $rewardtype
 * @property string $validityfrom
 * @property string $validityto
 * @property string $description
 * @property string $logo
 * @property string $cover
 * @property string $status 0=pending,1=active,2-failed
 * @property string $validity 0=expired,1=available
 * @property string $soldout 0=notsold,1=sold
 * @property string $reg_date
 * @property string $mod_date
 */
class Rewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rewards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'excerpt', 'coins', 'rewardtype', 'validityfrom', 'validityto', 'description', 'status', 'validity', 'soldout', 'reg_date'], 'required'],
            [['coins'], 'integer'],
            [['rewardtype', 'validityfrom', 'validityto', 'description', 'logo', 'cover', 'status', 'validity', 'soldout'], 'string'],
            [['mod_date'], 'safe'],
            [['user_id', 'title', 'excerpt'], 'string', 'max' => 30],
            [['reg_date'], 'string', 'max' => 20],
			[['logo', 'cover'], 'required', 'on' => 'insertphoto'],
			['validityto', 'compare', 'compareAttribute' => 'validityfrom', 'operator' => '>='],
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
            'title' => 'Title',
            'excerpt' => 'Excerpt',
            'coins' => 'Coins',
            'rewardtype' => 'Rewardtype',
            'validityfrom' => 'Validityfrom',
            'validityto' => 'Validityto',
            'description' => 'Description',
            'logo' => 'Logo',
            'cover' => 'Cover',
            'status' => 'Status',
            'validity' => 'Validity',
            'soldout' => 'Soldout',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
