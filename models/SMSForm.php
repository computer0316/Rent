<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SMSForm extends Model
{
    public $mobile;
    public $identification;
    public $SmsCode;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['mobile', 'identification', 'SmsCode'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile'		=> '手机号',
            'identification'=> '身份证号',
            'SmsCode'	=> '验证码',
        ];
    }

}
