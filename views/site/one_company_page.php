<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\ActiveForm;
use yii\helpers\ArrayHelper;

?>


<?php /*
    $this->registerJs(
        '$("document").ready(function(){
            $(".form-inline").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
    );*/
?>

<div class="row" style="margin:20px 0px ;">


</div>

<?php // debug($company); ?>
<div class="site-index">

    <?php if ($company) {
        echo GridView::widget([
            'dataProvider' => $company,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'label' => 'Наименование',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->name;
                    }
                ],

                [
                    'label' => 'Сфера деятельности',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->category;
                    }
                ],
                [
                    'label' => 'Адрес',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $_SESSION['address'] = $data->address;
                        return "$data->post_index <br> {$_SESSION['city_name']}, <br> $data->address <br> $data->building_name <br> $data->building_type";
                    }
                ],
                [
                    'label' => 'Контакты',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return "$data->phone <br> $data->site <br> $data->email   <br> $data->fax	
						<br> $data->vk <br> $data->facebook <br> $data->skype <br> $data->twitter <br> $data->instagram";
                    }
                ],
                [
                    'label' => 'Вид оплаты',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return "$data->pay_type <br> ";
                    }
                ],
                [
                    'label' => 'Режим работы',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return "$data->work_time <br> ";
                    }
                ],
                // 'created_at',
                // 'updated_at',

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    }
    //debug($dataProvider);
    ?>


</div>
<div class="center-block text-center">
    <div id="map" style="width: 550px; height: 400px" class="center-block text-center"></div>
</div>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>

<script type='text/javascript'>
    ymaps.ready(init);

    function init() {
        var geocoder = new ymaps.geocode(
            // Строка с адресом, который нужно геокодировать
            '<?php echo $_SESSION['city_name']?>, <?php echo $_SESSION['address']?>',
            // требуемое количество результатов
            {results: 1}
        );
        // После того, как поиск вернул результат, вызывается callback-функция
        geocoder.then(
            function (res) {
                // координаты объекта
                var coord = res.geoObjects.get(0).geometry.getCoordinates();
                var map = new ymaps.Map('map', {
                    // Центр карты - координаты первого элемента
                    center: coord,
                    // Коэффициент масштабирования
                    zoom: 7,
                    // включаем масштабирование карты колесом
                    behaviors: ['default', 'scrollZoom'],
                    controls: ['mapTools']
                });
                // Добавление метки на карту
                map.geoObjects.add(res.geoObjects.get(0));
                // устанавливаем максимально возможный коэффициент масштабирования - 1
                map.zoomRange.get(coord).then(function (range) {
                    map.setCenter(coord, range[1] - 1)
                });
                // Добавление стандартного набора кнопок
                map.controls.add('mapTools')
                // Добавление кнопки изменения масштаба
                    .add('zoomControl')
                    // Добавление списка типов карты
                    .add('typeSelector');
            }
        );
    }
</script>