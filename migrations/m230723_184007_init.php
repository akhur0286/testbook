<?php

use yii\db\Migration;

/**
 * Class m230723_184007_init
 */
class m230723_184007_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%book}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string()->comment('Название книги'),
			'issue_year' => $this->integer()->comment('год выпуска'),
			'description' => $this->text()->comment('описание'),
			'isbn' => $this->string(255)->comment('isbn'),
			'photo' => $this->string(255)->comment('Фотография главной страницы'),
			'created_by' => $this->integer(11)->comment('Создан пользователем'),
			'updated_by' => $this->integer(11)->comment('Обновлен пользователем'),

			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);

		$this->createTable('{{%author}}', [
			'id' => $this->primaryKey(),
			'fio' => $this->string(255),

			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);

		$this->createTable('{{%book_to_author}}', [
			'book_id' => $this->integer()->comment('Книга'),
			'author_id' => $this->integer()->comment('Книга'),
		]);

		$this->addPrimaryKey('pk_book_author', '{{%book_to_author}}', [
			'book_id',
			'author_id'
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropTable('{{%book}}');
		$this->dropTable('{{%author}}');
		$this->dropTable('{{%book_to_author}}');
    }
}
