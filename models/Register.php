<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $communityid
 * @property string $address
 * @property integer $target_communityid
 * @property string $updatetime
 */
class Register extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'communityid', 'address', 'target_communityid', 'updatetime'], 'required'],
            [['userid', 'communityid', 'target_communityid'], 'integer'],
            [['updatetime'], 'safe'],
            [['address'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户名',
            'communityid' => '所属小区',
            'address' => '具体楼号',
            'target_communityid' => '目标小区',
            'updatetime' => 'Updatetime',
        ];
    }
}
