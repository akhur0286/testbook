<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Book;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class BookForm extends Model
{
	public ?string $name = NULL;

	public ?string $description = NULL;

	public ?int $issueYear = NULL;

	public ?string $isbn = NULL;

	public array $authors = [];

	public $file;

	public function __construct(?Book $book = NULL, $config = [])
	{
		parent::__construct($config);

		if ($book) {
			$this->name = $book->name;
			$this->isbn = $book->isbn;
			$this->issueYear = $book->issue_year;
			$this->description = $book->description;

			if ($book->authors) {
				$this->authors = ArrayHelper::map($book->authors, 'id', 'id');
			}
		}
	}

	public function rules(): array
	{
		return [
			[['name', 'isbn', 'issueYear', 'authors'], 'required'],
			['issueYear', 'integer'],
			['authors', 'each', 'rule' => ['integer']],
			[['name', 'isbn'], 'string', 'max' => 255],
			[['description'], 'string'],
			[
				'file',
				'file',
				'extensions' => ['png', 'jpg', 'gif', 'jpeg', 'pdf'],
			],
		];
	}

	public function attributeLabels(): array
	{
		return [
			'name' => 'Название',
			'file' => 'Фото главной страницы',
			'authors' => 'Авторы',
			'isbn' => 'ISBN',
		];
	}
}
