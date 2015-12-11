<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 20:20
 *
 * @property $name
 * @property $author_id
 * @property $date
 * @property $date_create
 * @property $date_update
 *
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

class Book extends ActiveRecord
{
	public $file;

	public function init(){
//		if (!is_dir($this->previewUploadPath())){
//			FileHelper::createDirectory($this->previewUploadPath(),0777);
//		}

		parent::init();
	}

	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
				],

			],
		];
	}

	public static function tableName()
	{
		return '{{%books}}';
	}

	public function afterFind()
	{
		$this->date = \Yii::$app->formatter->asDate($this->date);

		parent::afterFind();
	}

	public function beforeSave($insert)
	{
		$this->date = \Yii::$app->formatter->asTimestamp($this->date);


		return parent::beforeSave($insert);
	}

	public function rules()
	{
		return [
			['name', 'string'],
			[['author_id', 'date_create', 'date_update'], 'integer'],
			['date', 'safe'],
			['file', 'file', 'extensions' => ['jpg', 'png']]
		];
	}

	public function getAuthor()
	{
		return $this->hasOne(Author::className(), ['id' => 'author_id']);
	}

	public function previewUploadPath()
	{
		return \Yii::getAlias('@app/web/uploads/');
	}

	public function getPreviewPath()
	{
		return \Yii::getAlias('@app/web/uploads/') . $this->preview;
	}

	public function getPreviewUrl()
	{
		return '/uploads/' . $this->preview;
	}

	public function previewFileName()
	{
		return 'book_' . $this->id;
	}

} 