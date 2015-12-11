<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 21:21
 * @var \app\models\Book $model
 */
?>

<?php $form = \yii\widgets\ActiveForm::begin([
	'action' => \yii\helpers\Url::to(['/books/update', 'id' => $model->id]),
	'method' => "POST",
	'options' => ['enctype' => 'multipart/form-data']
]);
?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'name'); ?>
		</div>
	</div>
	<div class="row">


		<div class="col-md-3">
			<?php if (!empty($model->preview)) : ?>
				<?= \yii\helpers\Html::img($model->getPreviewUrl(), [
					'width' => 200
				]); ?>
			<?php endif; ?>

		</div>

		<div class="col-md-6">
			<?= $form->field($model, 'file')->fileInput(); ?>
		</div>
	</div>
	<div class="row">

		<div class="col-md-6">
			<?= $form->field($model, 'date'); ?>
		</div>
	</div>
	<div class="row">

		<div class="col-md-6">
			<?= \yii\bootstrap\Html::submitButton(); ?>
		</div>
	</div>

<?php $form->end(); ?>