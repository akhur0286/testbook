<?php

use app\forms\AuthorForm;

/**
 * @var \yii\web\View $this
 * @var AuthorForm $formModel
 */

$this->title = 'Создание автора';
?>

<div>
	<h1><?= $this->title?></h1>

	<div class="form-wrapper">
		<?= $this->render('form', ['formModel' => $formModel])?>
	</div>
</div>
