<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\ActiveForm;
use yii\helpers\ArrayHelper;
$city_array = [
    ['city' => 'abakan', 'name' => 'Абакан'],
    ['city' => 'biysk', 'name' => 'Бийск'],    
];
?>


<?php/*
    $this->registerJs(
        '$("document").ready(function(){
            $(".form-inline").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
    );*/
?>
 
<div class="row" style="margin:20px 0px ;">

<?php Pjax::begin(); ?>
<h3 id="notes"><?= $city ?></h3>
<?php Pjax::end(); ?> 
</div>
 

<div class="site-index">

    <?php if ($dataProvider)  { 
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'], 
				//'id',
				[
					'label' => 'Наименование',
					'format' => 'raw',
					'value' => function($data){
						return Html::a(
							$data->name,
							['site/index', 'city' => $_SESSION['city'],'id' => $data->id ],
							[
								'title' => $data->name,
								'target' => '_blank'
							]
						);
					}
				],
				
				[
					'label' => 'Сфера деятельности',
					'format' => 'raw',
					'value' => function($data){
						return 	$data->category;
					}
				],
				[
					'label' => 'Адрес',
					'format' => 'raw',
					'value' => function($data){
						return 	$data->address;
					}
				],
				[
					'label' => 'Контакты',
					'format' => 'raw',
					'value' => function($data){
						return 	"$data->phone <br> $data->site <br> $data->email";
					}
				],
				//'name:ntext',
				//'category',
				//'address',
				//'phone',
				//'email',
				//'site',
				// 'created_at',
				// 'updated_at',
 
				//['class' => 'yii\grid\ActionColumn'],
			],
		]);
	}?>

   
</div>



