<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 20:36
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\BookSearch $model
 */
\app\assets\LightBoxAsset::register($this);

use yii\helpers\ArrayHelper;
use \yii\bootstrap\Html;

?>

	<h1>Книги</h1>

<?php \yii\widgets\Pjax::begin(); ?>
<?php $form = \yii\widgets\ActiveForm::begin([
	'id' => 'searchForm',
	'method' => 'GET',
	'action' => \yii\helpers\Url::to('/books/index')
]);
?>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(\app\models\Author::find()->all(),
				'id',
				'fullName'), [
				'prompt' => 'Выберите автора'
			]);
			?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'name'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<?= $form->field($model, 'dateFrom'); ?>
		</div>
		<div class="col-md-2">
			<?= $form->field($model, 'dateTo'); ?>
		</div>
		<div class="col-md-2">
			<br>
			<?= Html::submitButton('Искать', ['class' => 'btn btn-success']); ?>
		</div>
	</div>
<?php $form->end(); ?>
<?= \yii\grid\GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		'id',
		'name',
		[
			'attribute' => 'preview',
			'value' => function (\app\models\Book $model) {
				$link = null;
				if (!empty($model->preview)) {
					$img = Html::img($model->getPreviewUrl(), [
						'width' => 50,

					]);

					$link = Html::a($img, $model->getPreviewUrl(), [
						'data-lightbox' => "image-" . $model->id
					]);
				}
				return $link;
			},
			'format' => 'raw'
		],
		[
			'attribute' => 'author_id',
			'value' => function (\app\models\Book $model) {
				return $model->author->fullName;
			}
		],
		'date:date',
		'date_create:date',
		[
			'class' => \yii\grid\ActionColumn::className(),
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
						'class' => 'preview-link',
						'title' => 'Просмотр',
						'data-toggle' => 'modal',
						'data-target' => '#preview-modal',
						'data-id' => $key,
						'data-pjax' => '0',
					]);
				},
			],
		]
	]
]);
?>
<?= $this->render('viewModal'); ?>
<?php \yii\widgets\Pjax::end(); ?>

<?php
$loadUrl = \yii\helpers\Url::to('/books/view');
$js = <<<JS
$('.preview-link').click(function() {
    $.get(
        "{$loadUrl}",
        {
            id: $(this).closest('tr').data('key')
        },
        function (data) {
            $('.modal-body','#preview-modal').html(data);
            $('#preview-modal').modal();
        }
    );
});
JS;

$this->registerJs($js);
?>