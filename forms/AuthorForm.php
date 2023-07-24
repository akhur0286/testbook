<?php

declare(strict_types=1);

namespace app\forms;

use app\models\Author;
use yii\base\Model;

class AuthorForm extends Model
{
	public ?string $fio = NULL;

	public function __construct(?Author $model = null, $config = [])
	{
		parent::__construct($config);

		if ($model) {
			$this->fio = $model->fio;
		}
	}

	public function rules(): array
	{
		return [
			['fio', 'required'],
			['fio', 'string', 'max' => 255],
		];
	}

	public function attributeLabels(): array
	{
		return [
			'fio' => 'ФИО'
		];
	}
}
