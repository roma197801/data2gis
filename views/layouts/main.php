<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\ActiveForm;
use yii\helpers\ArrayHelper;
$city_array = [
    ['city' => 'abakan', 'name' => 'Абакан'],
    ['city' => 'biysk', 'name' => 'Бийск'],    
];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!--link href="/css/animate.css" rel="stylesheet">
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	
	<link href="/css/responsive.css" rel="stylesheet">
	<link href="/css/mine.css" rel="stylesheet"-->
	
	
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/admin/default']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
		
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 center-block">
				<div class="center-block text-center">
					<h2>Категории</h2>
				</div>
			</div>
			<div class="col-lg-6 col-md-36 col-sm-6  to-bottom">
				<?= Html::beginForm(['site/index','subcategory' => $_SESSION['subcategory']], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
				<?php Html::addCssStyle($options, 'height: 33px; width: 200px; position: absolute; font-size:18px;');
					echo Html::dropDownList('city', $_SESSION['city'], ArrayHelper::map($city_array, 'city', 'name'), $options ); 
					$_SESSION['city_name'] = ArrayHelper::map($city_array, 'city', 'name')[$_SESSION['city']];
					//echo Html::submitButton('AjaxCity', $options,['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button'])
				?>	
				<?php Html::addCssStyle($options_button, 'height: 33px; width: 160px; left: 230px; position: absolute;
				color: white; background-color: #337ab7;');
				echo Html::submitButton('Выбрать город', $options_button, ['class' => 'btn btn-primary', 'name' => 'hash-button']) ?>
				<?= Html::endForm() ?>
				
			</div>
		</div>
		
		
		<div class="col-lg-3 col-md-3 col-sm-3">
		<?php //debug($_SESSION['city_name']) ?>
					<div class="left_sidebar">
						<div class="single_widget">
							
							<ul class="cd-accordion-menu animated">							
								<?php echo \app\components\leftmenu\MenuWidget::widget(['tpl'=>'menu', 'controller_id' =>Yii::$app->controller->id]);?>
								
							</ul>
						</div>          
					</div>          
				</div>
		<div class="col-lg-8 col-md-8 col-sm-8  ">	
			<div class="container">
				<?= $content ?>
			</div>
		</div>
		
		
	
		
    </div>
</div>


  <style>
  /* -------------------------------- 

Main Components 

-------------------------------- */
ul{
	padding:0;
	list-style-type: none;
}
label {   
    max-width: 100%;
    margin-bottom: 0px;
    /*font-weight: bold;*/
}
.to-bottom{
	margin: 20px 0px 10px 30px;
	min-height: 33px;
	bottom: 0px;	
}
.navbar-inverse {
    //background-color: #222;
    background-color: #337ab7;
    border-color: #080808;
}
.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
    color: #fff;
    //background-color: #080808;
    background-color: #115785;
}
.cd-accordion-menu {
  width: 100%;
  max-width: 600px;
  background: #4d5158;
  margin: 4em auto;
  box-shadow: 0 4px 40px #70ac76;
}
.cd-accordion-menu ul {
  /* by default hide all sub menus */
  display: none;
}
.cd-accordion-menu li {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-accordion-menu input[type=checkbox] {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.cd-accordion-menu label, .cd-accordion-menu a {
  position: relative;
  display: block;
  padding: 8px 8px 8px 32px;
  //background: #4d5158;
  background: #337ab7;
  box-shadow: inset 0 -1px #555960;
  color: #ffffff;
  font-size: 1.4rem;
}
.cd-accordion-menu a {
	color: #222;
	 /*color: #337ab7;*/
}
.no-touch .cd-accordion-menu label:hover, .no-touch .cd-accordion-menu a:hover {
  background: #52565d;
}
.cd-accordion-menu label::before, .cd-accordion-menu label::after, .cd-accordion-menu a::after {
  /* icons */
  content: '';
  display: inline-block;
  width: 16px;
  height: 16px;
  position: absolute;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordion-menu label {
  cursor: pointer;
}
.cd-accordion-menu label::before, .cd-accordion-menu label::after {
  /*background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;*/
}
.cd-accordion-menu label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-accordion-menu label::after {
  /* folder icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-accordion-menu a::after {
  /* image icon */
  left: 36px;
  /*background: url(../img/cd-icons.svg) no-repeat -48px 0;*/
}
.cd-accordion-menu input[type=checkbox]:checked + label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordion-menu input[type=checkbox]:checked + label::after {
  /* show open folder icon if item is checked */
  background-position: -32px 0;
}
.cd-accordion-menu input[type=checkbox]:checked + label + ul,
.cd-accordion-menu input[type=checkbox]:checked + label:nth-of-type(n) + ul {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with multiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
}
.cd-accordion-menu ul label,
.cd-accordion-menu ul a {
  /*background: #35383d;*/  
  //background: #888;
  //background: #2268a6;
  background: #55acda;
  //background: #448bc8;
  box-shadow: inset 0 -1px #41444a;
  padding-left: 82px;
}
.cd-accordion-menu ul a {
	background: #77cefc;
}
.no-touch .cd-accordion-menu ul label:hover, .no-touch
.cd-accordion-menu ul a:hover {
  background: #3c3f45;
}
.cd-accordion-menu > li:last-of-type > label,
.cd-accordion-menu > li:last-of-type > a,
.cd-accordion-menu > li > ul > li:last-of-type label,
.cd-accordion-menu > li > ul > li:last-of-type a {
  box-shadow: none;
}
.cd-accordion-menu ul label::before {
  left: 36px;
}
.cd-accordion-menu ul label::after,
.cd-accordion-menu ul a::after {
  left: 59px;
}
.cd-accordion-menu ul ul label,
.cd-accordion-menu ul ul a {
  padding-left: 100px;
}
.cd-accordion-menu ul ul label::before {
  left: 54px;
}
.cd-accordion-menu ul ul label::after,
.cd-accordion-menu ul ul a::after {
  left: 77px;
}
.cd-accordion-menu ul ul ul label,
.cd-accordion-menu ul ul ul a {
  padding-left: 118px;
}
.cd-accordion-menu ul ul ul label::before {
  left: 72px;
}
.cd-accordion-menu ul ul ul label::after,
.cd-accordion-menu ul ul ul a::after {
  left: 95px;
}
@media only screen and (min-width: 600px) {
  .cd-accordion-menu label, .cd-accordion-menu a {
    padding: 0px 4px 0px 8px;
    font-size: 1.4rem;
  }
  .cd-accordion-menu label::before {
    left: 4px;
  }
  .cd-accordion-menu label::after {
    left: 8px;
  }
  .cd-accordion-menu ul label,
  .cd-accordion-menu ul a {
    padding-left: 11px;
  }
  .cd-accordion-menu ul label::before {
    left: 8px;
  }
  .cd-accordion-menu ul label::after,
  .cd-accordion-menu ul a::after {
    left: 9px;
  }
  .cd-accordion-menu ul ul label,
  .cd-accordion-menu ul ul a {
    padding-left: 13px;
  }
  .cd-accordion-menu ul ul label::before {
    left: 72px;
  }
  .cd-accordion-menu ul ul label::after,
  .cd-accordion-menu ul ul a::after {
    left: 10px;
  }
  .cd-accordion-menu ul ul ul label,
  .cd-accordion-menu ul ul ul a {
    padding-left: 14px;
  }
  .cd-accordion-menu ul ul ul label::before {
    left: 9px;
  }
  .cd-accordion-menu ul ul ul label::after,
  .cd-accordion-menu ul ul ul a::after {
    left: 12px;
  }
}
.cd-accordion-menu.animated label::before {
  /* this class is used if you're using jquery to animate the accordion */
  -webkit-transition: -webkit-transform 0.3s;
  -moz-transition: -moz-transform 0.3s;
  transition: transform 0.3s;
} 
  </style>
  
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Data2GIS <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
<!--script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.accordion.js"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/main.js"></script-->
</body>
</html>
<?php $this->endPage() ?>
