<?php

namespace bulldozer\banners\frontend\widgets;

use bulldozer\banners\frontend\ar\Banner;
use yii\base\Widget;

/**
 * Class BannerWidget
 * @package bulldozer\banners\frontend\widgets
 */
class BannerWidget extends Widget
{
    /**
     * @var string
     */
    public $view_path;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $banners = Banner::find()
            ->joinWith(['image'])
            ->all();

        return $this->render($this->view_path, [
            'banners' => $banners,
        ]);
    }
}