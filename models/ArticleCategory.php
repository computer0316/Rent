<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $articleid
 * @property integer $categoryid
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['articleid', 'categoryid'], 'required'],
            [['articleid', 'categoryid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'articleid' => 'Articleid',
            'categoryid' => 'Categoryid',
        ];
    }
}
