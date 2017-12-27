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

	// 新用户注册
	public function register(){
		$this->updatetime	= date("Y-m-d H:i:s");
		$this->ip			= Yii::$app->request->getUserIP();
		return $this->save();
	}

	public static function login($loginForm){
		$user = self::find()->where([
			'mobile'	=> $loginForm->mobile,
			'password'	=> md5($loginForm->password)
			])->one();
		if($user){
			Yii::$app->session->set('userid', $user->id);
		}
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
            [['name', 'mobile', 'password', 'firsttime', 'updatetime', 'communityid', 'identification', 'address'], 'required'],
            [['firsttime', 'updatetime'], 'safe'],
            [['mobile'], 'string', 'min' => 11, 'max' => 11, 'message' => '请输入11位的手机号'],
            [['communityid'], 'integer'],
            [['name', 'address'], 'string', 'max' => 16],
            [['password', 'password1'], 'string', 'max' => 64],
            [['ip', 'identification'], 'string', 'max' => 32],
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
        ];
    }
}
