<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 21:54
 * @var \app\models\Book $model
 */

use yii\bootstrap\Html;

?>

<h2><?= $model->name; ?></h2>
<div class="row">
	<div class="col-md-3">
		<?= Html::img($model->previewUrl,['width'=>100]); ?>
	</div>
	<div class="col-md-9">
		<p>Автор: <?= $model->author->fullName; ?></p>

		<p>Издана: <?= \Yii::$app->formatter->asDate($model->date); ?></p>

		<p>Добавлена: <?= \Yii::$app->formatter->asDate($model->date_create); ?></p>
	</div>
</div>
