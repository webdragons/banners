<?php

namespace bulldozer\banners\backend\widgets;

use yii\base\Widget;

/**
 * Class SaveButtonsWidget
 * @package bulldozer\banners\backend\widgets
 */
class SaveButtonsWidget extends Widget
{
    /**
     * @var bool
     */
    public $isNew;

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        return $this->render('save-buttons', [
            'isNew' => $this->isNew,
        ]);
    }
}