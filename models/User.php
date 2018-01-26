<?php

namespace app\models;


use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $password
 * @property string $firsttime
 * @property string $updatetime
 * @property string $ip
 * @property integer $communityid
 * @property string $identification
 * @property string $address
 * @property string $area
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

    /*
    */
	public static function login($loginForm){
		$user = self::find()->where(['mobile'	=> $loginForm->mobile])->one();
		if($user){
			Yii::$app->session->set('userid', $user->id);
			$user->updatetime	= date("Y-m-d H:i:s");
			$user->ip			= Yii::$app->request->userIP;
			$user->area			= $user->area + 1;
			$user->save();
			return $user;
		}
		else{
			$user = new User();
			$user->mobile 		= $loginForm->mobile;
			$user->firsttime 	= date("Y-m-d H:i:s");
			$user->updatetime	= date("Y-m-d H:i:s");
			$user->ip			= Yii::$app->request->userIP;
			$user->area			= 1;
			$user->save();
			Yii::$app->session->set('userid', $user->id);
			return $user;
		}
	}

	/*
	*/
	public static function register($user){

	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'firsttime', 'updatetime'], 'required'],
            [['name', 'mobile', 'updatetime', 'communityid', 'identification', 'address'], 'required', 'on' => 'edit'],
            [['mobile'], 'required', 'on' => 'login'],
            [['firsttime', 'updatetime'], 'safe'],
            [['communityid'], 'in', 'range' => [1,2,3,4,5]],
            [['area'], 'number'],
            [['name', 'mobile', 'address'], 'string', 'max' => 16],
            [['ip'], 'string', 'max' => 32],
            [['identification'], 'string', 'length' => [18, 18]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'			=> 'ID',
            'name'			=> '姓名',
            'mobile'		=> '手机号',
            'password'		=> '密码',
            'firsttime'		=> 'Firsttime',
            'updatetime'	=> 'Updatetime',
            'ip' 			=> 'Ip',
            'communityid'	=> '所属小区',
            'identification'=> '身份证号',
            'address'		=> '详细地址',
        ];
    }
}
