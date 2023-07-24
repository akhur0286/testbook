<?php

declare(strict_types=1);

namespace app\models\search;

use app\models\Author;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author
{
	public function rules(): array
	{
		return [
			[['fio'], 'string'],
		];
	}

	public function scenarios(): array
	{
		return Model::scenarios();
	}

	public function search(array $params): ActiveDataProvider
	{
		$query = Author::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id' => $this->id,
		]);

		$query->andFilterWhere(['like', 'fio', $this->fio]);

		return $dataProvider;
	}
}
