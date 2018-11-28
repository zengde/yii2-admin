<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-05
 * Time: 17:04
 */

namespace backend\behaviors;

use backend\controllers\CategoryController;
use backend\controllers\CacheController;
use backend\models\Category;
use Yii;
use yii\base\Behavior;

class CategoryBehavior extends Behavior
{
    public function events()
    {
        return [
            CategoryController::EVENT_AFTER_INSERT => 'afterinsert',
            CategoryController::EVENT_AFTER_UPDATE => 'afterupdate',
            CategoryController::EVENT_AFTER_DELETE => 'afterdelete',
        ];
    }

    public function afterinsert($event,$isupdate=false){
        /** @var  $owner \frontend\models\Category  */
        $owner=$event->result;
        $id=$owner->id;
        $parentid=$owner->parentid;
        if($parentid!=0){
            $catall=Category::cache_data_category(Yii::$app->cache);
            $parentdata=$catall[$parentid];
            $arrparent=$parentdata['arrparentid'];
            $parents=explode(',',$arrparent);
            $parents[]=$parentid;
            foreach($parents as $i=>$pid){
                if($i==0)
                    continue;
                $child=($isupdate)? $catall[$id]['arrchildid']:$id;
                $arrchildid=$catall[$pid]['arrchildid'].','.$child;
                $model=Category::findOne($pid);
                $model->arrchildid=$arrchildid;
                $model->save();
            }
            $owner->arrparentid=$arrparent.','.$parentid;
        }else{
            $owner->arrparentid=0;
        }
        if(!$isupdate){
            $owner->arrchildid=$id;
            $owner->save();
            $this->invalidate();
        }else{
            $owner->save();
            //更新子分类
            $startid=$id;
            $parentmodel=$owner;
            while($parentmodel&&($model=Category::findOne(['parentid'=>$startid])!==null)){
                $model->arrparentid=$parentmodel['arrparentid'].','.$parentmodel['id'];
                $model->save();
                $parentmodel=$model;
                $startid=$model['id'];
            }
        }
    }

    /**
     * @param bool $isupdate 如果为true是afterupdate手动调用
     */
    public function afterdelete($event,$isupdate=false){
        $catall = Category::cache_data_category(Yii::$app->cache);
        $catdata=$catall[$event->result->id];
        $arrparent=$catdata['arrparentid'];
        $arrchild=$catdata['arrchildid'];
        $parents=explode(',',$arrparent);
        $childs=explode(',',$arrchild);
        foreach($parents as $i=>$pid){
            if($i==0)
                continue;
            $pdata=$catall[$pid];
            $arrchildid=array_diff(explode(',',$pdata['arrchildid']),$childs);
            $arrchildid=implode(',',$arrchildid);
            $model=Category::findOne($pid);
            $model->arrchildid=$arrchildid;
            $model->save();
        }
        if(!$isupdate){
            Category::deleteAll(['id'=>$childs]);
            $this->invalidate();
        }
    }

    /**
     * @param $event \yii\db\AfterSaveEvent
     */
    public function afterupdate($event){
        /** @var  $owner \frontend\models\Category*/
        $catall = Category::cache_data_category(Yii::$app->cache);
        $category=$event->result;
        $oldparentid=$catall[$category['id']]['parentid'];
        $parentid=$category->parentid;
        if($oldparentid!=$parentid){
            //删除旧的
            $this->afterdelete($event,true);
            //添加新的
            $this->afterinsert($event,true);
        }
        $this->invalidate();
    }

    protected function invalidate(){
        $cache = Yii::$app->cache;
        
        Category::cache_category_tree($cache,true);
    }
}