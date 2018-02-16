<?php

namespace bulldozer\banners\backend\forms;

use bulldozer\base\Form;
use Yii;
use yii\web\UploadedFile;

/**
 * Class BannerForm
 * @package bulldozer\banners\backend\forms
 */
class BannerForm extends Form
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var integer
     */
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'url'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on' => 'update'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => 'default'],

            ['active', 'boolean'],

            ['sort', 'integer', 'min' => 0],
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        return parent::validate($attributeNames, $clearErrors);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('banners', 'Name'),
            'url' => Yii::t('banners', 'Link'),
            'imageFile' => Yii::t('banners', 'Image'),
            'active' => Yii::t('banners', 'Active'),
            'sort' => Yii::t('banners', 'Display order'),
        ];
    }

    /**
     * @return array
     */
    public function getSavedAttributes(): array
    {
        return ['name', 'url', 'active', 'sort'];
    }
}