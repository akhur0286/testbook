<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Book;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\search\BookSearch $searchModel
 */

$this->title = 'Books';
?>

<h1><?= $this->title?></h1>

<?php if (!Yii::$app->user->isGuest) { ?>
	<div class="button-group">
		<a href="/book/create" class="btn btn-primary">Добавить</a>
	</div>
<?php } ?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		[
			'attribute' => 'photo',
			'value' => static function (Book $model) {
				$data = null;
				if ($model->image) {
					$data = Html::img($model->image, ['width' => 40, 'height' => 40]);
				}
				return $data;
			},
			'format' => 'raw'
		],
		'name',
		'isbn',
		'description',
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{view} {update} {delete}',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('Посмотреть', ['/book/view', 'id' => $model->id]);
				},
				'update' => function ($url, $model, $key) {
					if (!Yii::$app->user->isGuest) {
						return Html::a('Редактировать', ['/book/edit', 'id' => $model->id]);
					}
				},
				'delete' => function ($url, $model, $key) {
					if (!Yii::$app->user->isGuest) {
						return Html::a('Удалить', ['/book/delete', 'id' => $model->id]);
					}
				},
			]
		],
	],
]); ?>
