<?php

namespace app\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'password', 'firsttime', 'updatetime', 'ip', 'communityid', 'identification', 'address'], 'required'],
            [['firsttime', 'updatetime'], 'safe'],
            [['communityid'], 'integer'],
            [['name', 'mobile', 'address'], 'string', 'max' => 16],
            [['password'], 'string', 'max' => 64],
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
            'name' => 'Name',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'firsttime' => 'Firsttime',
            'updatetime' => 'Updatetime',
            'ip' => 'Ip',
            'communityid' => 'Communityid',
            'identification' => 'Identification',
            'address' => 'Address',
        ];
    }
}
