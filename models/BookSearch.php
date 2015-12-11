<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 20:42
 */

namespace app\models;


use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BookSearch extends Book
{

	public $dateFrom;
	public $dateTo;
	public $dateFromTimestamp;
	public $dateToTimestamp;

	public function rules()
	{
		$rules = [
			['dateFrom', 'date', 'timestampAttribute' => 'dateFromTimestamp'],
			['dateTo', 'date', 'timestampAttribute' => 'dateToTimestamp'],
		];
		return ArrayHelper::merge($rules, parent::rules());
	}

	public function search($params)
	{
		$q = self::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $q
		]);

		$isLoaded = $this->load($params);
		$isValid = $this->validate();

		if (!$isLoaded && !$isValid) {
			return $dataProvider;
		}

		/**
		 * поиск по дате книги
		 * Если обе даты переданы, ищем в диапазоне,
		 * Если толь конечная дата, то ищем в диапазоне от 0 и до граничной даты
		 * Если только начальная дата, то ищем именно по ней.
		 */
		if (!empty($this->dateFrom) && !empty($this->dateTo)) {
			$q->andWhere(['between', 'date', $this->dateFromTimestamp, $this->dateToTimestamp]);
		} elseif (empty($this->dateFrom) && !empty($this->dateTo)) {
			$q->andFilterWhere([
				'between',
				'date',
				0,
				$this->dateFromTimestamp
			]);
		} else {
			$q->andFilterWhere([
				'date' => $this->dateFromTimestamp
			]);
		}

		$q->andFilterWhere([
			'like',
			'name',
			$this->name
		]);

		$q->joinWith('author', true);
		$q->andFilterWhere([
			'victor_authors.id' => $this->author_id
		]);

		return $dataProvider;
	}

} 