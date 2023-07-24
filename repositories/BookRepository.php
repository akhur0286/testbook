<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Book;
use RuntimeException;
use yii\web\NotFoundHttpException;

class BookRepository
{
	public function save(Book $model): void
	{
		if(!$model->save())
		{
			throw new RuntimeException('Book saving error.');
		}
	}

	public function remove(Book $model): void
	{
		if(!$model->delete())
		{
			throw new RuntimeException('Book deleting error.');
		}
	}

	public function get(int $id): Book
	{
		if(!$model = Book::findOne($id))
		{
			throw new NotFoundHttpException('Book is not found.');
		}

		return $model;
	}
}
