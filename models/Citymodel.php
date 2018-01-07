<?php

namespace app\models;
use yii\db\ActiveRecord;

class Citymodel extends ActiveRecord 
{
		
	
   public static function tableName()
   {
	   return $_SESSION['city'];
   }

    /**
     * @inheritdoc
     */
    
	
	
}
