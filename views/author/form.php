<?php

use app\forms\AuthorForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var AuthorForm $formModel
 */

$form = ActiveForm::begin(['id' => 'book-form']);
echo $form->field($formModel, 'fio')->textInput([]);
?>
<div class="button-group">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
</div>

<?php  ActiveForm::end();
