<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $year
 * @var \app\models\Author[] $topAuthors
 */

$this->title = 'Top Authors';
?>

<h1><?= $this->title?></h1>
<?php \yii\widgets\ActiveForm::begin(['method' => 'get'])?>
	<?= Html::textInput('year', $year, ['class' => 'form-control'])?>
	<?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px'])?>
<?php \yii\widgets\ActiveForm::end()?>
<div style="margin-top: 30px">
	<?php if ($topAuthors) { ?>
	<?php foreach($topAuthors as $topAuthor) { ?>
		<div><?= $topAuthor->fio?> - количество книг за <?= $year?> год - <?= $topAuthor->count?></div>
	<?php } ?>
	<?php } else {
		echo '<b>Авторов за '.$year.' год не найдено</b>';
	}?>
</div>
