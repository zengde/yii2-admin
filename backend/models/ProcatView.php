<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "procat".
 *
 * @property integer $id
 * @property integer $catid
 * @property string $name
 * @property string $pinyin
 * @property string $smalltext
 * @property integer $status
 * @property integer $intro
 * @property integer $clickcount
 * @property integer $uid
 * @property string $price
 * @property string $jprice
 * @property string $lprice
 * @property string $goods_img
 * @property string $thumb_img
 * @property string $adpic
 * @property string $size
 * @property string $lwh
 * @property integer $power
 * @property integer $weight
 * @property string $unit
 * @property string $tedian
 * @property string $newstext
 * @property string $document
 * @property integer $rdate
 * @property string $jdate
 * @property string $pdate
 * @property string $ldate
 * @property string $last_time
 * @property integer $is_top
 * @property string $material
 * @property string $catname
 * @property integer $video
 * @property string $keywords
 * @property string $packagesize
 * @property string $packageprice
 * @property string $biaozhi
 */
class ProcatView extends \yii\db\ActiveRecord
{
    public $is_hot=0;
    public $is_new=0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'procat';
    }
    
    public static function primaryKey() {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catid', 'status', 'intro', 'clickcount', 'uid', 'power', 'weight', 'rdate', 'is_top', 'video'], 'integer'],
            [['catid', 'name', 'pinyin', 'uid', 'rdate', 'catname'], 'required'],
            [['price', 'jprice', 'lprice', 'packageprice'], 'number'],
            [['tedian', 'newstext', 'document'], 'string'],
            [['last_time'], 'safe'],
            [['name', 'pinyin', 'smalltext', 'lwh', 'catname'], 'string', 'max' => 50],
            [['goods_img', 'thumb_img'], 'string', 'max' => 100],
            [['adpic'], 'string', 'max' => 120],
            [['size', 'keywords', 'packagesize', 'biaozhi'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 5],
            [['jdate', 'pdate', 'ldate'], 'string', 'max' => 10],
            [['material'], 'string', 'max' => 20]
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
            'intro' => 'Intro',
            'clickcount' => 'Clickcount',
            'uid' => 'Uid',
            'price' => '售价',
            'jprice' => '进货价',
            'lprice' => '最低价',
            'goods_img' => 'Goods Img',
            'thumb_img' => '商品图片',
            'adpic' => 'Adpic',
            'size' => 'Size',
            'lwh' => '尺寸',
            'power' => '功率',
            'weight' => '重量',
            'unit' => '单位',
            'tedian' => '特点',
            'newstext' => '详情',
            'document' => '说明书',
            'rdate' => 'Rdate',
            'jdate' => 'Jdate',
            'pdate' => 'Pdate',
            'ldate' => 'Ldate',
            'last_time' => 'Last Time',
            'is_top' => 'Is Top',
            'material' => '材质',
            'catname' => '类别',
            'video' => 'Video',
            'keywords' => 'Keywords',
            'packagesize' => 'Packagesize',
            'packageprice' => 'Packageprice',
            'biaozhi' => 'Biaozhi',
        ];
    }
 
}
