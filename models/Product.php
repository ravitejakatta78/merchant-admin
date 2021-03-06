<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $ID
 * @property string $merchant_id
 * @property string $unique_id
 * @property string $title
 * @property string $slug
 * @property string $labeltag
 * @property string $serveline
 * @property string $price
 * @property string $saleprice
 * @property string $image
 * @property string $availabilty 0=pending,1=active,2-failed
 * @property int|null $foodtype
 * @property int|null $food_category_quantity
 * @property string $status 0=pending,1=active,2-failed
 * @property string $reg_date
 * @property string $mod_date
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'unique_id', 'title', 'slug', 'labeltag', 'serveline', 'price', 'saleprice', 'availabilty', 'status', 'reg_date'], 'required'],
            [['title', 'slug', 'labeltag', 'serveline', 'price', 'saleprice', 'image', 'availabilty', 'status'], 'string'],
            [['foodtype', 'food_category_quantity'], 'integer'],
            [['mod_date'], 'safe'],
            [['merchant_id', 'unique_id'], 'string', 'max' => 50],
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
            'unique_id' => 'Unique ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'labeltag' => 'Labeltag',
            'serveline' => 'Serveline',
            'price' => 'Price',
            'saleprice' => 'Saleprice',
            'image' => 'Image',
            'availabilty' => 'Availabilty',
            'foodtype' => 'Foodtype',
            'food_category_quantity' => 'Food Category Quantity',
            'status' => 'Status',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
