<?php

use app\forms\BookForm;

/**
 * @var \yii\web\View $this
 * @var BookForm $formModel
 */

$this->title = 'Создание книги';
?>

<div>
	<h1><?= $this->title?></h1>

	<div class="form-wrapper">
		<?= $this->render('form', ['formModel' => $formModel, 'model' => new \app\models\Book()])?>
	</div>
</div>
