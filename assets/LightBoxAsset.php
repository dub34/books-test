<?php
/**
 * Created by PhpStorm.
 * User: uniqbook
 * Date: 12.12.15
 * Time: 0:48
 */

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LightBoxAsset extends AssetBundle
{
	public $sourcePath = '@bower';


	public $css = [
		'lightbox2/src/css/lightbox.css'

	];

	public $js = [
		'lightbox2/src/js/lightbox.js'
	];

	public $depends = [
		'\yii\web\JqueryAsset'
	];
} 