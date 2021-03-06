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
class Exchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'target_communityid', 'updatetime'], 'required'],
            [['target_communityid'], 'required', 'on' => 'edit'],
            [['userid', 'target_communityid'], 'integer'],
            [['updatetime'], 'safe'],
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
            'target_communityid' => '目标小区',
            'updatetime' => 'Updatetime',
        ];
    }
}
