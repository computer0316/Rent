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
class RegisterForm extends Model
{
    public $mobile;
    public $identification;
    public $password;
    public $password1;
    public $verifyCode;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['mobile', 'password', 'password1', 'identification', 'verifyCode'], 'required'],
            ['verifyCode', 'captcha', 'message'=>'验证码输入错误'],
            ['password1', 'compare', 'compareAttribute' => 'password', 'message'=>'两次输入的密码不一致！'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile'		=> '手机号',
            'password'		=> '密码',
            'password1'		=> '确认密码',
            'identification'=> '身份证号',
            'verifyCode'	=> '验证码',
        ];
    }

}
