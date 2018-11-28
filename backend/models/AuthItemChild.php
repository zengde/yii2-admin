<?php

namespace backend\models;

use Yii;
use yii\caching\TagDependency;
use yii\rbac\Item;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    const CACHE_TAG = 'admin.itemchild';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }

    public function  getPermission($id){
        $permission = self::find()->where(['parent'=>$id])->asArray()->all();
        return $permission;
    }

    public static function cache_item_tree($cache=null){
        $cache=$cache? :Yii::$app->cache;
        $key = [__METHOD__, Yii::$app->getUniqueId()];
        if(($result = $cache->get($key)) === false){
            $roles=AuthItem::find()->select('name')->where(['type'=>Item::TYPE_ROLE]);
            $childs=AuthItemChild::find()
                ->joinWith('child0')
                ->where(['not in','parent',$roles])
                ->asArray()
                ->all();
            foreach($childs as $child){
                $child=array_merge($child,['id'=>$child['child'],'name'=>$child['child0']['description']]);
                $parent=array_merge($child,['id'=>$child['parent'],'spread'=>true,'name'=>$child['parent']]);
                $result[$child['parent']]=isset($result[$child['parent']])? $result[$child['parent']]:$parent;
                $result[$child['parent']]['children'][]=$child;
            }
            $cache->set($key, $result, "3600", new TagDependency([
                'tags' => self::CACHE_TAG,
            ]));
        }
        return $result;
    }

    public static function invalidate()
    {
        TagDependency::invalidate(Yii::$app->cache, self::CACHE_TAG);
    }
}
