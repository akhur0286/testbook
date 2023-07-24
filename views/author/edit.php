<?php

use app\forms\AuthorForm;
use app\models\Author;

/**
 * @var \yii\web\View $this
 * @var Author $model
 * @var AuthorForm $formModel
 */

$this->title = 'Редактирование автора';
?>

<div>
	<h1><?= $this->title?></h1>

	<div class="form-wrapper">
		<?= $this->render('form', ['formModel' => $formModel])?>
	</div>
</div>
