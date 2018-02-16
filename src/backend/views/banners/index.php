<?php

use bulldozer\banners\common\ar\Banner;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('banners', 'Banners');
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
                <p>
                    <?= Html::a(Yii::t('banners', 'Create banner'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <div class="table-responsive">
                    <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'label' => Yii::t('banners', 'Active'),
                                    'attribute' => 'active',
                                    'format' => 'boolean',
                                ],
                                [
                                    'label' => Yii::t('banners', 'Name'),
                                    'attribute' => 'name',
                                ],
                                [
                                    'label' => Yii::t('banners', 'Link'),
                                    'attribute' => 'url',
                                    'format' => 'url',
                                ],
                                [
                                    'label' => Yii::t('banners', 'Image'),
                                    'content' => function(Banner $model, $key, $index, $column) {
                                        if ($model->image) {
                                            return Html::img($model->image->file_path, ['style' => ['width' => '200px']]);
                                        }
                                    },
                                ],
                                [
                                    'label' => Yii::t('app', 'Created at'),
                                    'attribute' => 'created_at',
                                    'format' => 'datetime',
                                ],
                                [
                                    'label' => Yii::t('app', 'Updated at'),
                                    'attribute' => 'updated_at',
                                    'format' => 'datetime',
                                ],
                                [
                                    'label' => Yii::t('app', 'Creator'),
                                    'attribute' => 'creator.email'
                                ],
                                [
                                    'label' => Yii::t('app', 'Updater'),
                                    'attribute' => 'updater.email'
                                ],
                                [
                                    'label' => Yii::t('banners', 'Display order'),
                                    'attribute' => 'sort',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update} {delete}',
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </section>
    </div>
</div>
