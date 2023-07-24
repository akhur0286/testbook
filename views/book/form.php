<?php

use app\forms\BookForm;
use yii\widgets\ActiveForm;
use app\models\Author;
use app\models\Book;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var BookForm $formModel
 * @var Book $model
 */

$form = ActiveForm::begin(['id' => 'book-form']);
?>
<?php
echo $form->field($formModel, 'name')->textInput([]);
echo $form->field($formModel, 'issueYear')->textInput();
echo $form->field($formModel, 'isbn')->textInput();
echo $form->field($formModel, 'file')->fileInput();
if ($model->image) {
	echo Html::tag('div', Html::img($model->image, ['width' => 40, 'height' => 40]));
}

echo $form->field($formModel, 'authors')->checkboxList(Author::getList());
echo $form->field($formModel, 'description')->textarea(['row' => 10]);

?>
<div class="button-group">
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
</div>

<?php  ActiveForm::end();
