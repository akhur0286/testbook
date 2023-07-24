<?php

use app\forms\BookForm;
use app\models\Book;

/**
 * @var \yii\web\View $this
 * @var Book $model
 * @var BookForm $formModel
 */

$this->title = 'Редактирование книги';
?>

<div>
	<h1><?= $this->title?></h1>

	<div class="form-wrapper">
		<?= $this->render('form', ['formModel' => $formModel, 'model' => $model])?>
	</div>
</div>
