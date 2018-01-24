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
class LoginForm extends Model
{
    public $mobile;
    public $identification;
    public $smsCode;
    public $verifyCode;
    public $method;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['mobile', 'identification', 'smsCode', 'verifyCode', 'method'], 'required'],
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
            'smsCode'		=> '短信验证码',
            'verifyCode'	=> '验证码',
        ];
    }

}
