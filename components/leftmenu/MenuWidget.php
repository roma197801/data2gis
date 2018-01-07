<?php

namespace app\components\leftmenu;
use yii\base\Widget;
use app\components\leftmenu\models\Department;
use Yii;

class MenuWidget extends Widget {
	
	public $tpl;
	public $data;
	public $tree;
	public $menuHtml;
	public $controller_id;
	
	public function init(){
		parent::init();
		if ($this->tpl === null){
			$this->tpl = 'menu';
		}
		$this->tpl .='.php';
	}
	
	public function run(){	
		// get cache
		//$menu = Yii::$app->cache->get('menu');
		//if ($menu) return $menu;
		
		//$this->data = Department::find()->indexBy('id')->asArray()->all();
		$_SESSION['menu_index'] = 1;		
		$this->data = Department::find()->indexBy('id')->all();
		
		//debug($this->controller_id);
		//debug($this->data);
		$this->tree = $this->data;
		$this->menuHtml = $this->getMenuHtml($this->tree);
		// set cache
		//Yii::$app->cache->set('menu',$this-menuHtml, 60*60*24*7);
		return $this->menuHtml;
	}
	
	protected function getMenuHtml($tree){
		$str = '';
		foreach ($tree as $department){
			$str .=$this->catToTemplate($department);
		}
		return $str;
	}
	
	protected function catToTemplate($department){
		ob_start();		
		include __DIR__.'/menu_tpl/'.$this->tpl;
		return ob_get_clean();
	}
}