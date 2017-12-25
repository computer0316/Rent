<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $password
 * @property string $password1
 * @property string $firsttime
 * @property string $updatetime
 * @property string $ip
 * @property integer $communityid
 * @property string $identification
 * @property string $address
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

	public $password1;
	public $verifyCode;

	// 新用户注册
	public function register(){
		if(!$this->validateIdentification()){
			throw new ErrorException("数据库中不存在这个身份证号码");
		}
	}

	// 验证身份证是否存在
	// 如果存在返回 true
	private function validateIdentification(){
		return User::find()->where(['identification' => $this->identification])->one();
	}

	public static function findByMobile($mobile){
		$user = self::find()->where(['mobile' => $mobile])->one();
		return $user;
	}


	/**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'password', 'password1', 'firsttime', 'updatetime', 'communityid', 'identification', 'address'], 'required'],
            [['firsttime', 'updatetime'], 'safe'],
            [['mobile'], 'string', 'min' => 11, 'max' => 11, 'message' => '请输入11位的手机号'],
            [['communityid'], 'integer'],
            [['name', 'address'], 'string', 'max' => 16],
            [['password', 'password1'], 'string', 'max' => 64],
            [['ip', 'identification'], 'string', 'max' => 32],
            ['password1', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'mobile' => '手机号',
            'password' => '密码',
            'password1' => '确认密码',
            'firsttime' => 'Firsttime',
            'updatetime' => 'Updatetime',
            'ip' => 'Ip',
            'communityid' => '小区名称',
            'identification' => '身份证号',
            'address' => 'Address',
            'verifyCode' => '输入验证码',
        ];
    }
}
