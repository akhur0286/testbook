<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $fio
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Author extends ActiveRecord
{
	public int $count = 0; //количество выпустивших книг за год

	public static function getList(): array
	{
		return ArrayHelper::map(self::find()->all(), 'id', 'fio');
	}

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author';
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
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

	public function afterDelete()
	{
		BookToAuthor::deleteAll(['author_id' => $this->id]);

		parent::afterDelete();
	}
}
