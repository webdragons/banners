<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \bulldozer\banners\backend\forms\BannerForm $model
 */

$this->title = Yii::t('banners', 'Create banner');
$this->params['breadcrumbs'][] = $this->title;
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
                    'isNew' => true,
                ]) ?>
            </div>
        </section>
    </div>
</div>
