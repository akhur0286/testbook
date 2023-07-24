<?php

declare(strict_types=1);

namespace app\services;

use app\models\Author;
use app\repositories\AuthorRepository;
use app\forms\AuthorForm;
use yii\base\StaticInstanceTrait;

class AuthorService
{
	use StaticInstanceTrait;

	private AuthorRepository $repository;

	public function __construct(AuthorRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param AuthorForm $form
	 * @return int
	 */
	public function create(AuthorForm $form): int
	{
		$model = new Author();
		$model->fio = $form->fio;

		$this->repository->save($model);

		return $model->id;
	}

	/**
	 * @param Author $model
	 * @param AuthorForm $form
	 */
	public function edit(Author $model, AuthorForm $form): void
	{
		$model->fio = $form->fio;

		$this->repository->save($model);
	}
}
