<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $ID
 * @property string $user_id
 * @property string $merchant_id
 * @property string $serviceboy_id
 * @property string $tablename
 * @property string $order_id
 * @property string $txn_id
 * @property string $txn_date
 * @property string $amount
 * @property string $tax
 * @property string $tips
 * @property string $subscription
 * @property string $couponamount
 * @property string $totalamount
 * @property string $paymenttype
 * @property string $orderline
 * @property string $coupon
 * @property string $orderprocess 0=pending,1=accept,2-served,3-cancel,3-deliver
 * @property string $orderprocessstatus 0=pending,1=show
 * @property string $status 0=pending,1=active,2-failed
 * @property string $paidstatus 0=pending,1=active,2-failed
 * @property string $orderalert
 * @property string $deliverdate
 * @property string $reorderprocess 0=pending,1=accept
 * @property int $preparetime
 * @property string $preparedate
 * @property int $paymentby
 * @property string $reg_date
 * @property string $mod_date
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['merchant_id', 'tablename', 'order_id', 'txn_id', 'txn_date', 'amount', 'tax', 'tips', 'subscription'
			, 'couponamount', 'totalamount', 'paymenttype', 'orderline', 'orderprocess', 'status', 'paidstatus', 'paymentby', 'reg_date'], 'required'],
            [['orderprocess', 'orderprocessstatus', 'status', 'paidstatus', 'reorderprocess'], 'string'],
            [['preparetime', 'paymentby','ordertype'], 'integer'],
            [['mod_date'], 'safe'],
            [['user_id', 'merchant_id', 'serviceboy_id', 'tablename', 'order_id', 'txn_id', 'txn_date', 'amount', 'tax', 'tips', 'subscription', 'couponamount', 'totalamount', 'paymenttype', 'orderline', 'coupon', 'preparedate'], 'string', 'max' => 50],
            [['orderalert', 'deliverdate', 'reg_date'], 'string', 'max' => 20],
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
            'merchant_id' => 'Merchant ID',
            'serviceboy_id' => 'Serviceboy ID',
            'tablename' => 'Tablename',
            'order_id' => 'Order ID',
            'txn_id' => 'Txn ID',
            'txn_date' => 'Txn Date',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'tips' => 'Tips',
            'subscription' => 'Subscription',
            'couponamount' => 'Couponamount',
            'totalamount' => 'Totalamount',
            'paymenttype' => 'Paymenttype',
            'orderline' => 'Orderline',
            'coupon' => 'Coupon',
            'orderprocess' => 'Orderprocess',
            'orderprocessstatus' => 'Orderprocessstatus',
            'status' => 'Status',
            'paidstatus' => 'Paidstatus',
            'orderalert' => 'Orderalert',
            'deliverdate' => 'Deliverdate',
            'reorderprocess' => 'Reorderprocess',
            'preparetime' => 'Preparetime',
            'preparedate' => 'Preparedate',
            'paymentby' => 'Paymentby',
            'ordertype' => 'ordertype',
            'reg_date' => 'Reg Date',
            'mod_date' => 'Mod Date',
        ];
    }
}
