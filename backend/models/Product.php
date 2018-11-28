<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $catid
 * @property string $name
 * @property string $pinyin
 * @property string $smalltext
 * @property integer $status
 * @property integer $clickcount
 * @property integer $uid
 * @property string $price
 * @property string $goods_img
 * @property string $thumb_img
 * @property string $lwh
 * @property string $newstext
 * @property integer $rdate
 * @property string $last_time
 */
class Product extends \backend\components\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catid', 'name', 'pinyin', 'uid', 'rdate'], 'required'],
            [['catid', 'status', 'clickcount', 'uid', 'rdate',], 'integer'],
            [['price'], 'number'],
            [['newstext'], 'string'],
            [['last_time'], 'safe'],
            [['name', 'pinyin', 'smalltext', 'lwh'], 'string', 'max' => 50],
            [['goods_img', 'thumb_img'], 'string', 'max' => 100],
            [['rdate'], 'unique'],
            ['smalltext','unique','targetAttribute'=>['smalltext','catid','name']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catid' => '类别',
            'name' => '商品名称',
            'pinyin' => 'Pinyin',
            'smalltext' => 'Smalltext',
            'status' => '状态',
            'clickcount' => 'Clickcount',
            'uid' => 'Uid',
            'price' => '售价',
            'goods_img' => 'Goods Img',
            'thumb_img' => '商品图片',
            'lwh' => '尺寸',
            'newstext' => 'Newstext',
            'rdate' => 'Rdate',
            'last_time' => 'Last Time'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        // 产品和分类通过 Category.id -> catid 关联建立一对一关系
        return $this->hasOne(Category::className(), ['id' => 'catid']);
    }

    public static function getDropDownlist($length=100){
        $all=self::find()->asArray()->limit($length)->all();
        return ArrayHelper::map($all,'id','name');
    }
}
