<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $urlgot
 * @property integer $textgot
 * @property string $originurl
 * @property string $content
 * @property string $updatetime
 * @property string $title
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['urlgot', 'textgot'], 'integer'],
            [['originurl', 'updatetime'], 'required'],
            [['content'], 'string'],
            [['updatetime'], 'safe'],
            [['originurl'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'urlgot' => 'Urlgot',
            'textgot' => 'Textgot',
            'originurl' => 'Originurl',
            'content' => 'Content',
            'updatetime' => 'Updatetime',
            'title' => 'Title',
        ];
    }
}
