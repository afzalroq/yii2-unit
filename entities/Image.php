<?php

namespace afzalroq\unit\entities;

use kartik\file\FileInput;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class Image extends UnitActiveRecord
{

    public static function getFileUrl($object): string
    {
        $key = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language];

        if (!$object['photo_' . $key]) {
            $key = 0;
        }

        return $object->getUploadedFileUrl('data_' . $key);
    }

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3' ,'data_4'], 'image'],
        ];
    }

    public function attributeLabels()
    {
        $language0 = Yii::$app->params['cms']['languages2'][0] ?? '';
        $language1 = Yii::$app->params['cms']['languages2'][1] ?? '';
        $language2 = Yii::$app->params['cms']['languages2'][2] ?? '';
        $language3 = Yii::$app->params['cms']['languages2'][3] ?? '';
        $language4 = Yii::$app->params['cms']['languages2'][4] ?? '';

        return [
            'data_0' => Yii::t('block', 'Photo') . '(' . $language0 . ')',
            'data_1' => Yii::t('block', 'Photo') . '(' . $language1 . ')',
            'data_2' => Yii::t('block', 'Photo') . '(' . $language2 . ')',
            'data_3' => Yii::t('block', 'Photo') . '(' . $language3 . ')',
            'data_4' => Yii::t('block', 'Photo') . '(' . $language4 . ')',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            $this->getBehaviorConfig('data_0'),
            $this->getBehaviorConfig('data_1'),
            $this->getBehaviorConfig('data_2'),
            $this->getBehaviorConfig('data_3'),
            $this->getBehaviorConfig('data_4')
        ];
    }

    private function getBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('unit');

        return [
            'class' => ImageUploadBehavior::class,
            'attribute' => $attribute,
            'createThumbsOnRequest' => true,
            'filePath' => $module->storageRoot . '/data/units/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->storageHost . '/data/units/[[attribute_id]]/[[filename]].[[extension]]',
            'thumbPath' => $module->storageRoot . '/cache/units/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
            'thumbUrl' => $module->storageHost . '/cache/units/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
            'thumbs' => array_merge($module->thumbs, [
                'sm' => ['width' => 106, 'height' => 60],
                'md' => ['width' => 212, 'height' => 120],
            ])
        ];
    }

    public function getData($key)
    {
        return $this->getThumbFileUrl('data_' . $key, 'md');
    }

    public function get($thumbProfile = null)
    {
        $key = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language];

        if (!$this['data_' . $key]) {
            $key = 0;
        }

        return $thumbProfile ? $this->getThumbFileUrl('data_' . $key, $thumbProfile) : $this->getImageFileUrl('data_' . $key);
    }

    public function getFormField($form, $key, $language)
    {
        $thisLanguage = $language ? '('.$language.')' : '';
        return $form->field($this, '[' . $this->id . ']data_' . $key)->widget(FileInput::class, [
            'options' => ['accept' => 'image/*'],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'showUpload' => false,
                'showPreview' => true,
                'showCaption' => false,
                'showRemove' => false,
                'showCancel' => false,
                'browseClass' => 'btn btn-primary btn-unit',
                'browseLabel' => Yii::t('block', 'Upload'),
                'layoutTemplates' => [
                    'main1' => '<div class="kv-upload-progress hide"></div>{browse}{preview}',
                ],
                'initialPreview' => [
                    Html::img($this->getThumbFileUrl('data_' . $key, 'md'), ['class' => 'file-preview-image', 'alt' => '', 'title' => '']),
                ],
            ],
        ])->label($this->label . $thisLanguage);
    }


    public function beforeValidate()
    {
        $this->data_0 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_0'));
        $this->data_1 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_1'));
        $this->data_2 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_2'));
        $this->data_3 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_3'));
        $this->data_4 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_4'));
        return parent::beforeValidate();
    }
}
