<?php

namespace backend\models;

use Yii;
use yii\caching\TagDependency;
use backend\components\Helper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parentid
 * @property string $route
 * @property integer $order
 * @property string $data
 */
class Menu extends \yii\db\ActiveRecord
{
    const CACHE_TAG = 'admin.menu';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parentid', 'order'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 256],
            ['parentid','default','value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parentid' => '父级',
            'route' => '路由',
            'order' => '排序',
            'data' => '描述',
        ];
    }

    public function getAllMenu(){
        return self::find()->all();
    }

    //获取左侧菜单列表
    public static function  getLeftMenuList(){
        $cache=Yii::$app->cache;
        $key = [__METHOD__, Yii::$app->getUniqueId()];
        if(($result = $cache->get($key)) === false){
            $menu=self::find()->indexBy('id')->asArray()->all();
            $result=Helper::genTree5($menu);
            $cache->set($key, $result, "3600", new TagDependency([
                'tags' => self::CACHE_TAG,
            ]));
        }
        return $result;
    }
    /**
     * Ivalidate cache
     */
    public static function invalidate()
    {
        TagDependency::invalidate(Yii::$app->cache, self::CACHE_TAG);
    }
}
