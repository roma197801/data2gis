<?php

namespace app\components\leftmenu\models;

use Yii;
use \yii\db\ActiveRecord;
use \app\components\leftmenu\models\Subdepartment;

/**
 * This is the model class for table "avatars".
 *
 * @property string $id
 * @property string $alt
 * @property string $img_url
 * @property integer $category_id
 * @property string $category_name_url
 * @property string $title
 * @property string $meta_desc
 * @property string $h1
 * @property string $meta_keywords
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }
	
	public function getSubdepartment(){
		//debug($this);
		return $this->hasMany(Subdepartment::className(), ['department_id' =>'id']);
	}
	public function getSubcategory(){
		//debug($this);
		return $this->subdepartment->hasMany(Subcategory::className(), ['subcategory_level_1_id' =>'id']);
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
       /* return [
            [['id', 'alt', 'img_url', 'category_id', 'category_name_url', 'title', 'meta_desc', 'h1', 'meta_keywords'], 'required'],
            [['id', 'category_id'], 'integer'],
            [['alt', 'img_url', 'title', 'meta_desc', 'h1', 'meta_keywords'], 'string', 'max' => 255],
            [['category_name_url'], 'string', 'max' => 100],
        ];*/
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      /*  return [
            'id' => 'ID',
            'alt' => 'Alt',
            'img_url' => 'Img Url',
            'category_id' => 'Category ID',
            'category_name_url' => 'Category Name Url',
            'title' => 'Title',
            'meta_desc' => 'Meta Desc',
            'h1' => 'H1',
            'meta_keywords' => 'Meta Keywords',
        ];*/
    }
}
