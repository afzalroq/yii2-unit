<?php

namespace afzalroq\unit\entities;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class TextInput extends UnitActiveRecord
{

    const STRING = 1;
    const EMAIL = 2;
    const INTEGER = 3;
    const URL = 4;

    public static function getValidator($validatorKey = self::STRING)
    {
        switch ($validatorKey) {
            case $validatorKey == self::STRING:
                return ['validator' => 'string', 'massege' => Yii::t('block', 'This value is not a string.')];
                break;
            case $validatorKey == self::EMAIL:
                return ['validator' => 'email', 'massege' => Yii::t('block', 'The value "Email" is not a valid email address.')];
                break;
            case $validatorKey == self::INTEGER:
                return ['validator' => 'integer', 'massege' => Yii::t('block', 'This value is not a integer.')];
                break;
            case $validatorKey == self::URL:
                return ['validator' => 'url', 'massege' => Yii::t('block', 'This value is not a URL.')];
                break;
        }
    }

    public static function validatorName($key)
    {
        $list = self::validatorList();
        return $list[$key];
    }

    public static function validatorList()
    {
        return [
            self::STRING => \Yii::t('block', 'String'),
            self::EMAIL => \Yii::t('block', 'Email'),
            self::INTEGER => \Yii::t('block', 'Integer'),
            self::URL => \Yii::t('block', 'Url')
        ];
    }

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3', 'data_4'],
                self::getValidator(Unit::findOne(['data_0' => $this->data_0])->inputValidator)['validator'],
                'message' => self::getValidator(Unit::findOne(['data_0' => $this->data_0])->inputValidator)['massege']],
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
            'data_0' => Yii::t('block', 'Text') . '(' . $language0 . ')',
            'data_1' => Yii::t('block', 'Text') . '(' . $language1 . ')',
            'data_2' => Yii::t('block', 'Text') . '(' . $language2 . ')',
            'data_3' => Yii::t('block', 'Text') . '(' . $language3 . ')',
            'data_4' => Yii::t('block', 'Text') . '(' . $language4 . ')',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getData($key)
    {
        return $this->{'data_' . $key};
    }

    public function get()
    {
        $key = \Yii::$app->params['cms']['languageIds'][\Yii::$app->language];

        if (!$this['data_' . $key]) {
            $key = 0;
        }

        return $this->{'data_' . $key};
    }

    public function getFormField($form, $key, $language)
    {
        $thisLanguage = $language ? '(' . $language . ')' : '';
        return $form->field($this, '[' . $this->id . ']data_' . $key)->textInput()->label($this->label . $thisLanguage);
    }

    public function load($data, $formName = null)
    {
        $success = false;

        foreach ($data as $postFormName => $formDataArray) {
            if ($postFormName == 'TextInput') {
                foreach ($data[$this->formName()] as $id => $formData) {
                    if ($this->id == $id) {
                        $success = Model::load($formDataArray, $id);
                    }
                }
            }
        }

        return $success;
    }
}
