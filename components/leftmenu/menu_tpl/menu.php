<?php //debug($this->controller_id);
///avatar/imagecategories?category=auto   $this->controller_id.
?>
<li class="has-children">
	<?php $_SESSION['menu_index']  = $_SESSION['menu_index'] + 1;?>
	<input type='checkbox' name ='group-<?php echo $_SESSION['menu_index'];?>' id='group-<?php echo $_SESSION['menu_index'];?>'>
	<label for='group-<?php echo $_SESSION['menu_index'];?>'><?php echo $department->name;?></label>
		<!--a href="<?php //echo\yii\helpers\Url::to('/'.$this->controller_id.'/index?department='.$department->id) ?>"> 
			
			<!--span class="badge pull-right"><i class="fa fa-plus"></i></span-->
		<!--/a--> 
		<ul>
		<?php $subdepartments = $department->subdepartment;	
	foreach ($subdepartments as $subdepartment){ 
	?>
		<li class="has-children">
		<?php $_SESSION['menu_index']  = $_SESSION['menu_index'] + 1;?>
		<input type='checkbox' name ='group-<?php echo $_SESSION['menu_index'];?>' id='group-<?php echo $_SESSION['menu_index'];?>'>
		<label for='group-<?php echo $_SESSION['menu_index'];?>'><?php echo $subdepartment->name;?></label>
			<ul>
		<?php $subcategories = $subdepartment->subcategory;	
		foreach ($subcategories as $subcategory){ 
		?>
			<li>
		
		
		<a href="<?=\yii\helpers\Url::to('/'.$this->controller_id.'/index?city='.$_SESSION['city'].'&subcategory='.$subcategory->id) ?>"> 
			<?php echo $subcategory->name;?>
		</a> 
			</li>
		<?php 
		}
		?>
			</ul>
		</li>
	<?php 
	}
	?>
	</ul>
</li>