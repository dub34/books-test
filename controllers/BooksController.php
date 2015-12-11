<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BooksController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['update', 'view', 'delete'],
				'rules' => [
					[
						'actions' => ['update', 'view', 'delete'],
						'allow' => true,
						'roles' => ['@'],
					]
				],
			],
		];
	}

	public function actionIndex()
	{
		$model = new BookSearch();
		Url::remember('', 'returnUrl');
//		var_dump(\Yii::$app->request->get());
		$dataProvider = $model->search(\Yii::$app->request->get());
		return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $model]);
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);

		return $this->renderAjax('view', ['model' => $model]);
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if ($model->load(\Yii::$app->request->post())) {
			$previewImage = UploadedFile::getInstance($model, 'file');
			if (!empty($previewImage) && $previewImage->tempName) {
				if ($model->validate()) {
					$dir = $model->previewUploadPath();
					$fileName = $model->previewFileName() . '.' . $previewImage->extension;


					if (!empty($model->preview) && is_file($model->getPreviewPath())){
						unlink($model->getPreviewPath());
					}

					$previewImage->saveAs($dir . $fileName);
					$model->preview = $fileName;
					$isSaved = $model->save();
					if (!$isSaved) {
						\Yii::$app->session->setFlash('message', 'Ошибка сохранения');
					}
					return $this->redirect(Url::previous('returnUrl'));
				}
			}
		}

		return $this->render('update', ['model' => $model]);
	}

	public function actionDelete($id)
	{
		return $this->render('update');
	}

	/**
	 * @param $id
	 * @return null|Book
	 * @throws NotFoundHttpException
	 */
	private function loadModel($id)
	{
		$model = Book::findOne($id);

		if (null == $model) {
			throw new NotFoundHttpException('Книга не найдена');
		}
		return $model;
	}

}
