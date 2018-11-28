<?php

namespace backend\models;

use backend\components\Helper;
use backend\components\MyUploadedFile;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $parentid
 * @property string $arrparentid
 * @property string $arrchildid
 * @property string $name
 * @property integer $listorder
 * @property integer $is_show
 * @property integer $is_input
 * @property string $app_img
 * @property string $adddate
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid', 'listorder', 'is_show', 'is_input'], 'integer'],
            [['arrchildid'], 'string'],
            [['name'], 'required'],
            [['adddate'], 'safe'],
            [['arrparentid'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
            [['parentid','listorder'],'default','value'=>0],
            ['app_img','image']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentid' => 'Parentid',
            'arrparentid' => 'Arrparentid',
            'arrchildid' => 'Arrchildid',
            'name' => 'Name',
            'listorder' => 'Listorder',
            'is_show' => 'Is Show',
            'is_input' => 'Is Input',
            'app_img' => 'App Img',
            'adddate' => 'Adddate'
        ];
    }

    public function upload() {
        $this->app_img = MyUploadedFile::getInstanceByName('app_img');
        if ($this->validate()) {
            if($this->app_img){
                $upload = Yii::getAlias('@backend/web/uploads/');
                $filename=$this->app_img->saveName . '.' . $this->app_img->extension;
                $srcname='appimg/'.$filename;
                $this->app_img->saveAs($upload.$srcname);
                $this->app_img=$srcname;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $cache \yii\caching\Cache
     * @param bool $force
     * @return array
     */
    public static function cache_data_category($cache=null,$force=false){
        $cache=$cache? :Yii::$app->cache;
        $key='data_category';
        if(($cats = $cache->get($key)) === false||$force){
            $cats = Category::find()->select('id,parentid,arrparentid,arrchildid,name,listorder,is_show,is_input')->indexBy('id')->asArray()->all();
            $cache->set($key, $cats);
        }
        return $cats;
    }

    /**
     * @param $cache \yii\caching\Cache
     * @param bool $force
     * @return array
     */
    public static function cache_category_tree($cache=null,$force=false){
        $cache=$cache? :Yii::$app->cache;
        $key='category_tree';
        if(($res = $cache->get($key)) === false||$force){
            $treedata = Category::find()->select('id,name,parentid')->where('is_input=1')->orderBy('listorder asc')->indexBy('id')->asArray()->all();
            $res = Helper::genTree5($treedata);
            $cache->set($key, $res);
        }
        return $res;
    }
}
