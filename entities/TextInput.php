<?php

namespace afzalroq\unit\entities;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

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

    private static $_validator;

    public static function addValidation($validatorName = self::STRING)
    {
        switch ($validatorName) {
            case $validatorName == self::STRING:
                self::$_validator = 'string';
                break;
            case $validatorName == self::EMAIL:
                self::$_validator = 'email';
                break;
            case $validatorName == self::INTEGER:
                self::$_validator = 'integer';
                break;
            case $validatorName == self::URL:
                self::$_validator = 'url';
                break;
        }
        Yii::$app->session->set('validator', self::$_validator);
    }

    public static function validatorName($key)
    {
        $list = self::validatorList();
        return $list[$key];
    }

    public static function validatorList()
    {
        return [
            self::STRING => \Yii::t('block', 'String validator'),
            self::EMAIL => \Yii::t('block', 'Email validator'),
            self::INTEGER => \Yii::t('block', 'Integer validator'),
            self::URL => \Yii::t('block', 'Url validator')
        ];
    }

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3', 'data_4'], Yii::$app->session->get('validator')],
            [['data_0', 'data_1', 'data_2', 'data_3', 'data_4'], 'required', 'message' => Yii::t('block', 'Text cannot be blank.')],
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
        $thisLanguage = $language ? '('.$language.')' : '';
        return $form->field($this, '[' . $this->id . ']data_' . $key)->textInput()->label($this->label . $thisLanguage);
    }

    public function load($data, $formName = null)
    {
        $success = false;

        foreach ($data as $postFormName => $formDataArray) {
            if ($this->formName() == 'Text') {
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
