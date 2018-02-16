<?php

namespace bulldozer\banners\backend\services;

use bulldozer\App;
use bulldozer\banners\backend\forms\BannerForm;
use bulldozer\banners\common\ar\Banner;
use bulldozer\files\models\Image;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Class BannerService
 * @package bulldozer\banners\backend\services
 */
class BannerService
{
    /**
     * @param Banner|null $banner
     * @return BannerForm
     * @throws \yii\base\InvalidConfigException
     */
    public function getForm(?Banner $banner = null): BannerForm
    {
        /** @var BannerForm $form */
        $form = App::createObject([
            'class' => BannerForm::class,
        ]);

        if ($banner) {
            $form->setAttributes($banner->getAttributes($form->getSavedAttributes()));
        } else {
            $lastBanner = Banner::find()->orderBy(['sort' => SORT_DESC])->one();

            if ($lastBanner) {
                $form->sort = $lastBanner->sort + 100;
            } else {
                $form->sort = 100;
            }
        }

        return $form;
    }

    /**
     * @param BannerForm $form
     * @param Banner|null $banner
     * @return Banner
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function save(BannerForm $form, ?Banner $banner = null): Banner
    {
        if ($banner === null) {
            $banner = App::createObject([
                'class' => Banner::class,
                'image_id' => 0,
            ]);
        }

        $transaction = App::$app->db->beginTransaction();

        $banner->setAttributes($form->getAttributes($form->getSavedAttributes()));

        if ($banner->save()) {
            if ($form->imageFile) {
                if ($banner->image) {
                    $banner->image->delete();
                }

                $image = App::createObject([
                    'class' => Image::class,
                ]);

                if (!$image->upload($form->imageFile) || !$image->save()) {
                    $transaction->rollback();

                    throw new Exception('Cant save image. Errors: ' . json_encode($image->getErrors()));
                }

                $banner->image_id = $image->id;
                $banner->save();
            }

            $transaction->commit();
            return $banner;
        }

        $transaction->rollback();

        throw new Exception('Cant save banner. Errors: ' . json_encode($banner->getErrors()));
    }
}