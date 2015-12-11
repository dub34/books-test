<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 20:25
 *
 * @property $firstname
 * @property $lastname
 * @property $fullName
 */

namespace app\models;


use yii\db\ActiveRecord;

class Author extends ActiveRecord
{

	public static function tableName()
	{
		return '{{%authors}}';
	}

	public function rules()
	{
		return [
			[['firstname', 'lastname'], 'string'],
		];
	}

	public function getBooks()
	{
		return $this->hasMany(Book::className(), ['id' => 'author_id']);
	}

	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
} 