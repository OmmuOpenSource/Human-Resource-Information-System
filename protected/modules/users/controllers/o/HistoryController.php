<?php
/**
 * HistoryController
 * @var $this HistoryController
 * @var $model UserHistoryLogin
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Login
 *	Email
 *	Username
 *	Password
 *	Subscribe
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-users
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class HistoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('login','email','username','password','subscribe'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('login'));
	}

	/**
	 * Manages all models.
	 */
	public function actionLogin($user=null) 
	{
		$pageTitle = Yii::t('phrase', 'History Logins');
		if($user != null) {
			$data = Users::model()->findByPk($user);
			$pageTitle = Yii::t('phrase', 'History Login: $user_displayname level $level_name', array ('$user_displayname'=>$data->displayname,'$level_name'=>Phrase::trans($data->level->name)));
		}
		
		$model=new UserHistoryLogin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserHistoryLogin'])) {
			$model->attributes=$_GET['UserHistoryLogin'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_history_login',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionEmail($user=null) 
	{
		$pageTitle = Yii::t('phrase', 'History Emails');
		if($user != null) {
			$data = Users::model()->findByPk($user);
			$pageTitle = Yii::t('phrase', 'History Email: $user_displayname level $level_name', array ('$user_displayname'=>$data->displayname,'$level_name'=>Phrase::trans($data->level->name)));
		}
		
		$model=new UserHistoryEmail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserHistoryEmail'])) {
			$model->attributes=$_GET['UserHistoryEmail'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_history_email',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionUsername($user=null) 
	{
		$pageTitle = Yii::t('phrase', 'History Usernames');
		if($user != null) {
			$data = Users::model()->findByPk($user);
			$pageTitle = Yii::t('phrase', 'History Username: $user_displayname level $level_name', array ('$user_displayname'=>$data->displayname,'$level_name'=>Phrase::trans($data->level->name)));
		}
		
		$model=new UserHistoryUsername('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserHistoryUsername'])) {
			$model->attributes=$_GET['UserHistoryUsername'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_history_username',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionPassword($user=null) 
	{
		$pageTitle = Yii::t('phrase', 'History Passwords');
		if($user != null) {
			$data = Users::model()->findByPk($user);
			$pageTitle = Yii::t('phrase', 'History Password: $user_displayname level $level_name', array ('$user_displayname'=>$data->displayname,'$level_name'=>Phrase::trans($data->level->name)));
		}
		
		$model=new UserHistoryPassword('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserHistoryPassword'])) {
			$model->attributes=$_GET['UserHistoryPassword'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_history_password',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionSubscribe($user=null) 
	{
		$pageTitle = Yii::t('phrase', 'History Subscribe/Unsubscribe');
		if($user != null) {
			$data = Users::model()->findByPk($user);
			$pageTitle = Yii::t('phrase', 'History Subscribe/Unsubscribe: $user_displayname level $level_name', array ('$user_displayname'=>$data->displayname,'$level_name'=>Phrase::trans($data->level->name)));
		}
		
		$model=new UserNewsletterHistory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserNewsletterHistory'])) {
			$model->attributes=$_GET['UserNewsletterHistory'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = $pageTitle;
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_history_subscribe',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = UserHistoryLogin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-history-login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}