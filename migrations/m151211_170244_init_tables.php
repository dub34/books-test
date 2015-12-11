<?php

use yii\db\Schema;
use yii\db\Migration;

class m151211_170244_init_tables extends Migration
{
	public $booksTable = "{{%books}}";
	public $authorsTable = "{{%authors}}";

	public function safeUp()
	{
		$this->createTable($this->booksTable, [
			'id' => Schema::TYPE_PK,
			'name' => Schema::TYPE_STRING . ' NOT NULL',
			'date_create' => Schema::TYPE_INTEGER,
			'date_update' => Schema::TYPE_INTEGER,
			'preview' => Schema::TYPE_TEXT,
			'date' => Schema::TYPE_INTEGER,
			'author_id' => Schema::TYPE_INTEGER,
		]);

		$this->createTable($this->authorsTable, [
			'id' => Schema::TYPE_PK,
			'firstname' => Schema::TYPE_STRING . ' NOT NULL',
			'lastname' => Schema::TYPE_STRING,
		]);

		$this->addForeignKey('fk_book_author_id', $this->booksTable, 'author_id', $this->authorsTable, 'id', 'CASCADE',
			'CASCADE');

		$this->batchInsert($this->authorsTable, [
			'firstname',
			'lastname'
		], [
			['Гарри', 'Гаррисон'],
			['Джон', 'Толкиен'],
			['Роджер', 'Желязны'],

		]);

		$this->batchInsert($this->booksTable, [
			'name',
			'author_id',
			'date',
			'date_create',
			'date_update',
		], [
			[
				'Стальная крыса',
				1,
				\Yii::$app->formatter->asTimestamp('1961-01-01 00:00:00'),
				time(),
				time(),
			],
			[
				'Неукротимая планета',
				1,
				\Yii::$app->formatter->asTimestamp('1960-04-01 00:00:00'),
				time(),
				time(),
			],
			[
				'Конные варвары',
				1,
				\Yii::$app->formatter->asTimestamp('1968-06-03 00:00:00'),
				time(),
				time(),
			],
			[
				'Властелин колец. Братство Кольца',
				2,
				\Yii::$app->formatter->asTimestamp('1954-07-29 00:00:00'),
				time(),
				time(),
			],[
				'Властелин колец. Две крепости',
				2,
				\Yii::$app->formatter->asTimestamp('1954-11-11 00:00:00'),
				time(),
				time(),
			],
			[
				'Властелин колец. Возвращение короля',
				2,
				\Yii::$app->formatter->asTimestamp('1954-10-20 00:00:00'),
				time(),
				time(),
			],
			[
				'Девять принцев Амбера',
				3,
				\Yii::$app->formatter->asTimestamp('1970-05-21 00:00:00'),
				time(),
				time(),
			],
		]);
	}

	public function safeDown()
	{
		$this->dropTable($this->booksTable);
		$this->dropTable($this->authorsTable);
	}

}
