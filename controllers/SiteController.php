<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Citymodel;
	
use app\models\User;
use yii\data\ActiveDataProvider;
use  yii\db\Query;
use  yii\base\Security;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'about'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
                   'actions' => ['about'],
                   'allow' => true,
                   'roles' => ['@'],
                   'matchCallback' => function ($rule, $action) {
                       return User::isUserAdmin(Yii::$app->user->identity->username);
                   }
               ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
	 
	public function beforeAction($action)
	{
		if (!isset($_SESSION['city'])) {
		$_SESSION['city'] = 'abakan';
		}
		return parent::beforeAction($action);
	} 
	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	public function actionFilter() {
		
		$city = $_POST['city'];
		$_SESSION['city'] = $_POST['city'];
		$provider = $_SESSION['dataProvider'];	
		
		return $this->render('index', [
			'dataProvider' => $provider,
			'city' => $city ,			
		]);
	}
	public function actionMultiple()
	{
		$security = new Security();
		$randomString = $security->generateRandomString();
		$randomKey = $security->generateRandomKey();
		
		$provider = $_SESSION['dataProvider'];		
      
		return $this->render('index', [
			'dataProvider' => $provider,
			'randomString' => $randomString,
			'randomKey' => $randomKey,
		]);
	}
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$request = Yii::$app->request;
		//$get = $request->get();
		// equivalent to: $get = $_GET;
		$id = $request->get('id');
		// equivalent to: $id = isset($_GET['id']) ? $_GET['id'] : null;
		if (isset($_POST['city'])) {			
			$_SESSION['city'] = $_POST['city'];
		}
		
		if (isset($_GET['id'])) {	
			$query = Citymodel::find()
				->Where(['id' => $_GET['id']]);
			$company = new ActiveDataProvider(
			[
				'query' => $query,				
			]);


		
			/*$company = Citymodel::find()
			->Where(['id' => $_GET['id']])
			->one();*/
			//debug($company);
			//die(0);
		return $this->render('one_company_page',
			[
				'dataProvider' => false,
				'company' => $company				
			]);	
		}	
		if (isset($_GET['subcategory'])) {
			
			$_SESSION['subcategory'] = $_GET['subcategory'];
			$query = Citymodel::find()
				->orWhere(['or',      
					['category_1' => $_GET['subcategory']],
					['category_2' => $_GET['subcategory']],
					['category_3' => $_GET['subcategory']],
					['category_4' => $_GET['subcategory']],
					['category_5' => $_GET['subcategory']],			
				]);
			$provider = new ActiveDataProvider(
			[
				'query' => $query,
				'pagination' => [
						'pageSize' => 25,
				],
				'sort' => [
					'defaultOrder' => [
							'id' => SORT_DESC,						
					]
				],
			]);

			// get the posts in the current page
			//$companies = $provider->getModels();
			
			
			//debug($companies);
			$_SESSION['dataProvider'] = $provider;
		
        return $this->render('index', ['dataProvider' => $provider]);
		}
		//$_SESSION['dataProvider'] = $provider;
		
        return $this->render('index',['dataProvider' => false]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
	 
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
	/*
	public function actionLogin()
	{
		if (!\Yii::$app->user->isGuest) {
		return $this->goHome();
		}
 
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}
	*/
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
