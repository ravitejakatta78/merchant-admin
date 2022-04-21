<?php
namespace app\helpers;

use yii;
use app\models\FoodCategeries;
use app\models\Product;
use app\models\Tablename;
use app\models\Users;

class Utility{
    public static function foodtype_value($status)
    { 
	$foodCatFullDet = FoodCategeries::allcategeries();
	$foodCatDet = array_column($foodCatFullDet,'food_category','ID');
	
	return $foodCatDet[$status];
    }
    public static function get_uniqueid($tablename,$text)
    {
	//$uniquedetails = $tablename::find()->select('MAX(ID) as id')->asArray()->one();
	$sqlunique = 'select MAX(ID) as id from '.$tablename.'';
	$uniquedetails = Yii::$app->db->createCommand($sqlunique)->queryOne();
	$uniqueId = $uniquedetails['id'];
	if(!empty($uniqueId)){
	    $newid = $uniqueId+1;
        }else{
	    $newid = 1;
        }
        return $text.sprintf('%04d',$newid);
    }
    public static function table_details($id,$type)
	{
		$tableDet = Tablename::findOne($id);	
			if(!empty($tableDet)){
				return  $tableDet[$type] ?: '';
			}
	}
	public static function user_details($id,$type)
	{
		$userDet = Users::findOne($id);
			if(!empty($userDet)){
		return  $userDet[$type] ?: '';
			}
			
	}
	public static function product_details($id,$type)
	{
		$prodDet = \app\models\Product::findOne($id);
			if(!empty($prodDet)){
		return  $prodDet[$type] ?: '';
			}
			
	}
	public static function food_cat_qty_det($id,$type)
	{
		$food_cat_qty_det = \app\models\FoodCategoryTypes::findOne($id);
		if(!empty($food_cat_qty_det)){
			return  $food_cat_qty_det[$type] ?: '';
		}
	}
	public static function orderstatus_details($status){ 
		if($status==1){
			return 'Accepted';
		}else if($status==2){
			return 'Served';
		}else if($status==0){
			return 'New';
		}else if($status==3){
			return 'Canceled';
		}else if($status==4){
			return 'Delivered';
		}
		else if($status==5){
			return 'Available';
		}
	}
	public static function order_id($merchant,$type)
	{
		$merchantdetails = \app\models\Merchant::findOne($merchant);
		$sqlprevmerchnat = 'select MAX(ID) as id from orders';
		$prevmerchnat = Yii::$app->db->createCommand($sqlprevmerchnat)->queryOne();
		$newid = $prevmerchnat['id']+1; 
		if($type=='order'){
			return strtoupper('FQ'.$merchantdetails['storename'].$merchantdetails['storetype'].$merchantdetails['location'].sprintf('%07d',$newid));
		}
		if($type=='transaction'){
			return strtoupper('FQTX'.$merchantdetails['storename'].$merchantdetails['storetype'].$merchantdetails['location'].sprintf('%07d',$newid));
		}
	}
	public static function encrypt($string){

	 $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'foodgenee_key';
    $secret_iv = 'foodgenee_iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
   
    return trim($output);

}
    public static function orderflowdropdown($status)
    {
		if($status == '1')
		{
			return ['1' => 'Accepted','2' => 'Served','3' => 'Canceled'];
		}
		else if($status == '2')
		{
			return ['2' => 'Served','4' => 'Completed'];
		}
	} 
	public static function merchantDet($id){
		return \app\models\Merchant::findOne($id);
	} 
	public static function notificationType($id = null){
		$arr = ['2'=>'Restaurants','4'=>'Contest','5'=>'Rewards'];
		if(!empty($id)){
		    return $arr[$id];    
		}
		else{
		    return $arr;
		}
		
	} 
	 public static function sendFCM($id,$title,$message,$imageurl=false,$type=null,$encykey=null) {
if(!empty($id)){
	$imageurl = $imageurl ?: '';
    $api_key = "AAAAbL_6cuU:APA91bFMr3gEaAHBgPsZlB0Qnp9DICD9xBSP0hRl0kDehZEvFm82CrNr_xsthGTuK_8dAM0gXO5lDnUeJ33OUQkmEKvOVNYbIqQM9op4U5CY7OSXqc0FlEs4opTwXzviQhRIojgLW0-S";

    $url = 'https://fcm.googleapis.com/fcm/send';
 
    $fields = array (
        'to' =>  $id,   
		"priority" => "high",
        'data' => array (
				"content" => $message,
			   "type" => $type ?? '1',
			   "encykey" => $enckey ?? '',
			   "title" => $title, 
			   "image" => $imageurl, 
			   
			   "icon" => SITE_URL."foodq-icon72.png"
        ),
		"text" => $title,
    );
 
    $headers = array(
        'Content-Type:application/json',
        'Authorization: key='.$api_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
}

	
}

?>
