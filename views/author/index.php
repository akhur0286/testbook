<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\search\AuthorSearch $searchModel
 */

$this->title = 'Authors';
?>

<h1><?= $this->title?></h1>

<div class="button-group">
	<a href="/author/top" class="btn btn-primary">Top 10</a>
	<?php if (!Yii::$app->user->isGuest) { ?>
		<a href="/author/create" class="btn btn-primary">Добавить</a>
	<?php } ?>
</div>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		'fio',
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{view} {update} {delete}',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('Посмотреть', ['/author/view', 'id' => $model->id]);
				},
				'update' => function ($url, $model, $key) {
					if (!Yii::$app->user->isGuest) {
						return Html::a('Редактировать', ['/author/edit', 'id' => $model->id]);
					}
				},
				'delete' => function ($url, $model, $key) {
					if (!Yii::$app->user->isGuest) {
						return Html::a('Удалить', ['/author/delete', 'id' => $model->id]);
					}
				},
			]
		],
	],
]); ?>
