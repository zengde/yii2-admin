<?php

namespace backend\models;

use backend\components\Helper;
use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $code
 * @property integer $pid
 * @property integer $status
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'pid'], 'required'],
            [['code', 'pid', 'status'], 'integer'],
            [['name', 'title'], 'string', 'max' => 50],
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
            'title' => 'Title',
            'code' => 'Code',
            'pid' => 'Pid',
            'status' => 'Status',
        ];
    }

    public static function cache_area_tree($cache=null,$force=false){
        $cache=$cache? :Yii::$app->cache;
        $key='area_tree';
        if(($res = $cache->get($key)) === false||$force){
            $treedata = Area::find()->select('id,name,pid parentid,code')->where('status=1')->orderBy('id asc')->indexBy('id')->asArray()->all();
            $res = Helper::genTree5($treedata);
            $cache->set($key, $res);
        }
        return $res;
    }

    //缓存所有地区信息，计算arrchildid,arrparentid,fullname
    public static function cache_area_all($cache=null,$force=false){
        $cache=$cache? :Yii::$app->cache;
        $key='area_all';
        if(($res = $cache->get($key)) === false||$force){
            $rescopy=$res = Area::find()->select('id,name,pid parentid,code')->where('status=1')->orderBy('id asc')->indexBy('id')->asArray()->all();
            foreach($res as $areaid => $area){
                $temp=self::get_arrparentid($rescopy,$areaid);
                $res[$areaid]['name']=$temp['name'];
                $res[$areaid]['arrparentid']=$temp['arrparentid'];
                $res[$areaid]['arrchildid']=self::get_arrchildid($rescopy,$areaid);
            }
            $cache->set($key, $res);
        }
        return $res;
    }

    public static function get_arrchildid($all,$areaid){
        $arrchildid = "$areaid";
        foreach($all as $id => $area) {
            if($area['parentid'] && $id != $areaid && $area['parentid']==$areaid) {
                $arrchildid .= ','.self::get_arrchildid($all,$id);
            }
        }
        return $arrchildid;
    }

    public static function get_arrparentid($all,$areaid){
        $parent=$all[$areaid]['parentid'];
        $all[$areaid]['arrparentid']="$parent";
        if(!empty($all[$parent])){
            $temp=self::get_arrparentid($all,$parent);
            $all[$areaid]['name']=$temp['name'].'/'.$all[$areaid]['name'];
            $all[$areaid]['arrparentid']=$temp['arrparentid'].','.$all[$areaid]['arrparentid'];
        }
        return $all[$areaid];
    }
}
