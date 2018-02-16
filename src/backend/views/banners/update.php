<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \bulldozer\banners\backend\forms\BannerForm $model
 * @var \bulldozer\banners\common\ar\Banner $banner
 */

$this->title = Yii::t('banners', 'Update banner: {name}', ['name' => $banner->name]);
$this->params['breadcrumbs'][] = $banner->name;
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                </div>

                <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
            </header>

            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'isNew' => false,
                ]) ?>
            </div>
        </section>
    </div>
</div>
