<?php

namespace bulldozer\banners\frontend\ar;

use bulldozer\App;
use yii\db\ActiveQuery;

/**
 * Class Banner
 * @package bulldozer\banners\frontend\ar
 */
class Banner extends \bulldozer\banners\common\ar\Banner
{
    /**
     * @inheritdoc
     */
    public static function find(): ActiveQuery
    {
        $query = parent::find();

        if (!App::$app->user->can('banners_manage')) {
            $query->andWhere(['active' => 1]);
        }

        return $query;
    }
}