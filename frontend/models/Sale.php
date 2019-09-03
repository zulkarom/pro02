<?php

namespace frontend\models;

use Yii;
use backend\models\Customer;

class Sale
{
	public static function validateAccess(){
		if(self::isBlocked()){
			return false;
		}else{
			return true;
		}
	}
	
	private static function isBlocked(){
		$id = Yii::$app->user->identity->id;
		$customer = Customer::findOne(['user_id' => $id]);
		return $customer->is_block;
	}
}
