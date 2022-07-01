<?php
namespace app\helpers;

use yii;
class MyConst 
{
	/* ROLE CONSTANTS */
	const ROLE_SUPER_ADMIN = '1';
	const ROLE_COACH = '2';
	const ROLE_USER = '3';
	const ROLE_INSTITUTION = '4';
	
	/* STATUS CONSTANTS */
	const _ACTIVE = 'ACTIVE';
	const _INACTIVE = 'INACTIVE';
	const TYPE_ACTIVE = '1';
	const TYPE_INACTIVE = '2';
	
	const _SERVICE_TYPES = ['1' => 'Dine In', '2' => 'Parcels','3' => 'Self-Pickup','4' => 'Delivery','5' => 'Table Reservation'];
}

?>
