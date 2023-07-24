<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Author;
use app\models\Book;
use app\models\BookToAuthor;
use RuntimeException;
use yii\web\NotFoundHttpException;

class AuthorRepository
{

	public function save(Author $model): void
	{
		if(!$model->save())
		{
			throw new RuntimeException('Author saving error.');
		}
	}

	public function remove(Author $model): void
	{
		if(!$model->delete())
		{
			throw new RuntimeException('Author deleting error.');
		}
	}

	public function get(int $id): Author
	{
		if(!$model = Author::findOne($id))
		{
			throw new NotFoundHttpException('Author is not found.');
		}

		return $model;
	}

	/**
	 * @param int $year
	 * @param int $limit
	 * @return Author[]|array
	 */
	public function getTop(int $year, int $limit = 10): array
	{
		return Author::find()
			->alias('a')
			->select(['count(b2a.book_id) as count', 'a.*'])
			->andWhere(['b.issue_year' => $year])
			->innerJoin(BookToAuthor::tableName().' b2a', 'b2a.author_id=a.id')
			->innerJoin(Book::tableName() .' b', 'b.id=b2a.book_id')
			->groupBy('b2a.author_id')
			->orderBy(['count' => SORT_DESC])
			->limit($limit)
			->all();
	}
}
