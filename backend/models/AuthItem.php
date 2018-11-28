<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\rbac\Item;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * 角色&权限的创建方法
     * @return boolean 返回成功或者失败的状态值
     */
    public function addItem()
    {
        //实例化AuthManager类
        $auth = Yii::$app->authManager;
        if($this->type ==Item::TYPE_ROLE){
            $item = $auth->createRole($this->name);
            $item->description = $this->description?:'创建['.$this->name.']角色';
        }else{
            $item = $auth->createPermission($this->name);
            $item->description = $this->description?:'创建['.$this->name.']权限';
        }
        return $auth->add($item);
    }
    /**
     * 角色&权限的删除方法
     * @return boolean 返回成功或者失败的状态值
     */
    public function romoveItem()
    {
        $this->name = trim($this->name);
        if($this->validate()){
            $auth = Yii::$app->authManager;
            $item = $auth->getRole($this->name)?:$auth->getPermission($this->name);
            return $auth->remove($item);
        }

        return false;
    }

    /**
     * 编辑权限
     * @param string $item_name
     * @return boolean
     */
    public function updateItem()
    {
        $oldname=$this->getOldAttribute('name');
        $auth = Yii:: $app-> authManager;
        if($this->type == Item::TYPE_ROLE){
            $item = $auth->createRole($this-> name);
            $item-> description = $this-> description?: '创建['.$this-> name. ']角色';
        }else{
            $item = $auth->createPermission($this-> name);
            $item-> description = $this-> description?: '创建['.$this-> name. ']权限';
        }
        return $auth->update($oldname, $item);
    }

    /**
     * Adds an item as a child of another item.
     * @param array $items
     * @return int
     */
    public function addChildren($items)
    {
        $manager = Yii::$app->getAuthManager();
        $success = 0;
        $item = $this->type === Item::TYPE_ROLE ? $manager->getRole($this->name) : $manager->getPermission($this->name);
        if ($item) {
            foreach ($items as $name) {
                $child = $manager->getPermission($name);
                if ($this->type == Item::TYPE_ROLE && $child === null) {
                    $child = $manager->getRole($name);
                }
                try {
                    $manager->addChild($item, $child);
                    $success++;
                } catch (\Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }
        }
        if ($success > 0) {
            Route::invalidate();
            if($this->type==Item::TYPE_PERMISSION)
                AuthItemChild::invalidate();
        }
        return $success;
    }

    /**
     * Remove an item as a child of another item.
     * @param array $items
     * @return int
     */
    public function removeChildren($items)
    {
        $manager = Yii::$app->getAuthManager();
        $success = 0;
        $item = $this->type === Item::TYPE_ROLE ? $manager->getRole($this->name) : $manager->getPermission($this->name);
        if ($item !== null) {
            foreach ($items as $name) {
                $child = $manager->getPermission($name);
                if ($this->type == Item::TYPE_ROLE && $child === null) {
                    $child = $manager->getRole($name);
                }
                try {
                    $manager->removeChild($item, $child);
                    $success++;
                } catch (\Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }
        }
        if ($success > 0) {
            Route::invalidate();
        }
        return $success;
    }
}
