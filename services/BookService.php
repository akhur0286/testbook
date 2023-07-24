<?php

declare(strict_types=1);

namespace app\services;

use app\models\Book;
use app\models\BookToAuthor;
use app\repositories\BookRepository;
use app\forms\BookForm;
use yii\base\StaticInstanceTrait;
use yii\db\Exception;
use yii\web\UploadedFile;

class BookService
{
	use StaticInstanceTrait;

	private BookRepository $repository;

	public function __construct(BookRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param BookForm $form
	 * @return int
	 */
	public function create(BookForm $form): int
	{
		$transaction = \Yii::$app->db->beginTransaction();

		$model = new Book();
		try {
			$this->fillBook($model, $form);

			$this->repository->save($model);

			$file = UploadedFile::getInstance($form, 'file');

			if(!empty($file)) {
				$this->saveFile($model, $file);
			}

			if(!empty($form->authors)) {
				$this->saveAuthors($model, $form->authors);
			}

			$transaction->commit();
		} catch(\Exception $exception) {
			$transaction->rollBack();
			throw new Exception($exception->getMessage());
		}

		return $model->id;
	}

	/**
	 * @param Book $model
	 * @param BookForm $form
	 * @return void
	 */
	public function edit(Book $model, BookForm $form): void
	{
		$transaction = \Yii::$app->db->beginTransaction();
		try {
			$this->fillBook($model, $form);

			$this->repository->save($model);

			$file = UploadedFile::getInstance($form, 'file');

			if(!empty($file)) {
				$this->saveFile($model, $file);
			}

			if(!empty($form->authors)) {
				$this->saveAuthors($model, $form->authors);
			}
			$transaction->commit();
		} catch(\Exception $exception) {
			$transaction->rollBack();
			throw new Exception($exception->getMessage());
		}
	}

	/**
	 * @param Book $model
	 * @param BookForm $form
	 * @return void
	 */
	private function fillBook(Book $model, BookForm $form): void
	{
		$model->name = $form->name;
		$model->description = $form->description;
		$model->issue_year = $form->issueYear;
		$model->isbn = $form->isbn;
	}

	public function saveAuthors(Book $model, array $authorsIds): void
	{
		foreach($authorsIds as $authorId) {
			$b2a = new BookToAuthor();
			$b2a->book_id = $model->id;
			$b2a->author_id = $authorId;
			$b2a->save();
		}
	}

	public function saveFile(Book $model, UploadedFile $file): void
	{
		$path = \Yii::getAlias('@app/web/uploads/');

		if ($model->photo && file_exists($path . $model->photo)) {
			unlink($path . $model->photo);
		}

		$fileName = md5(time().'-'.$file->name).'.'.$file->extension;

		if ($file->saveAs($path.$fileName)) {
			$model->updateAttributes(['photo' => $fileName]);
		}
	}
}
