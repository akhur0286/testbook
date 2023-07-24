<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $name Название книги
 * @property int|null $issue_year год выпуска
 * @property string|null $description описание
 * @property string|null $isbn isbn
 * @property string|null $photo Фотография главной страницы
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property-read Author[] $authors
 * @property-read string|null $image
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

	/**
	 * {@inheritdoc}
	 */
	public function behaviors(): array
	{
		return [
			TimestampBehavior::class,
		];
	}

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['issue_year', 'created_by', 'updated_by'], 'integer'],
            [['name', 'isbn', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'issue_year' => 'Issue Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

	/**
	 * @return ActiveQuery
	 * @throws InvalidConfigException
	 */
	public function getAuthors(): ActiveQuery
	{
		return $this->hasMany(Author::class, ['id' => 'author_id'])
			->viaTable(BookToAuthor::tableName(), ['book_id' => 'id']);
	}

	public function getImage(): ?string
	{
		if ($this->photo) {
			$path = \Yii::getAlias('@app/web/uploads/');
			if (file_exists($path . $this->photo)) {
				return '/uploads/' . $this->photo;
			}

		}

		return null;
	}

	public function afterDelete()
	{
		BookToAuthor::deleteAll(['book_id' => $this->id]);

		parent::afterDelete();
	}
}
