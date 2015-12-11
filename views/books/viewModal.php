<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 11.12.15
 * Time: 21:38
 */
use yii\bootstrap\Modal;

?>

<?php Modal::begin([
	'id' => 'preview-modal',
	'header' => '<h4 class="modal-title">Просмотр</h4>',
	'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Закрыть</a>',
]); ?>

<?php Modal::end(); ?>