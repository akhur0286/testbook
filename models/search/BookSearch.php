<?php

declare(strict_types=1);

namespace app\models\search;

use app\models\Book;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
	public function rules(): array
	{
		return [
			[['name', 'description', 'isbn'], 'string'],
			[['issue_year', 'created_by', 'updated_by'], 'integer'],
		];
	}

	public function scenarios(): array
	{
		return Model::scenarios();
	}

	public function search(array $params): ActiveDataProvider
	{
		$query = Book::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id' => $this->id,
			'issue_year' => $this->issue_year,
			'created_by' => $this->created_by,
			'updated_by' => $this->updated_by,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'isbn', $this->isbn]);

		return $dataProvider;
	}
}
