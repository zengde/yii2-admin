<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-05-26
 * Time: 13:59
 */

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\caching\TagDependency;

class Route
{
    const CACHE_TAG = 'admin.route';
    const CACHE_TAG_Admin = 'admin.routeAdmin';

    /**
     * Assign items
     * @param array $routes
     * @return void
     */
    public function addNew($routes)
    {
        $manager = Yii::$app->getAuthManager();
        foreach ($routes as $route) {
            $r = explode('-', $route);
            $item = $manager->createPermission(trim($r[0], '/'));
            if (count($r) > 1) {
                $item->description=$r[1];
            }
            $manager->add($item);
        }
        $this::invalidate();
    }

    /**
     * remove items
     * @param array $routes
     * @return void
     */
    public function remove($routes)
    {
        $manager = Yii::$app->getAuthManager();
        foreach ($routes as $route) {
            try {
                $r = explode('-', $route);
                $route=(count($r)>1)? $r[0]:$route;
                $item = $manager->createPermission(trim($route, '/'));
                $manager->remove($item);
            } catch (Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        $this::invalidate();
    }

    /**
     * Get avaliable and assigned routes
     * @return array
     */
    public function getRoutes($parent='')
    {
        $manager = Yii::$app->getAuthManager();
        $routes = $this->getAppRoutes();
        $exists = [];
        $permissions=$parent? $manager->getChildren($parent):$manager->getPermissions();
        foreach ($permissions as $item) {
            $name=$item->name;
            if (strpos($name,'/')===false ) {
                continue;
            }
            $exists[] = $name.'-'.$item->description;
            unset($routes[$name]);
        }
        return[
            'avaliable' => array_keys($routes),
            'assigned' => $exists
        ];
    }

    /**
     * Get list of application routes
     * @return array
     */
    public function getAppRoutes(){
        $cache=Yii::$app->cache;
        $key = [__METHOD__, Yii::$app->getUniqueId()];
        if(($result = $cache->get($key)) === false){
            $result=$this->getRouteRecrusive('frontend');
            $cache->set($key, $result, "3600", new TagDependency([
                'tags' => self::CACHE_TAG,
            ]));
        }
        return $result;
    }

    public function getAdminRoutes(){
        $cache=Yii::$app->cache;
        $key = [__METHOD__, Yii::$app->getUniqueId()];
        if(($result = $cache->get($key)) === false){
            $result=$this->getRouteRecrusive('backend');
            $cache->set($key, $result, "3600", new TagDependency([
                'tags' => self::CACHE_TAG_Admin,
            ]));
        }
        return $result;
    }

    /**
     * Get route(s) recrusive
     * @param string $module 模块
     * @param bool $isparent 是否包含父类方法
     */
    protected function getRouteRecrusive($module,$isparent=false){
        $files=glob(Yii::getAlias("@$module/controllers/*.php"));
        $res=[];
        foreach($files as $file){
            $classname=basename($file,'.php');
            $controller=strtolower(str_replace('Controller','',$classname));
            $fullclass="$module\controllers\\".$classname;
            $class=new \ReflectionClass($fullclass);
            $methods=$class->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach($methods as $method){
                if(strpos($method->class,'Controller')===false||$method->name=='actions')
                    continue;
                if(!$isparent&&$method->class!==$fullclass)
                    continue;
                if(strpos($method->name,'action')===0){
                    //$res[$controller][]=strtolower(substr($method->name,6));
                    $key=$controller.'/'.strtolower(substr($method->name,6));
                    $res[$key]=1;
                }

            }
        }
        return $res;
    }

    /**
     * Ivalidate cache
     */
    public static function invalidate()
    {
        TagDependency::invalidate(Yii::$app->cache, self::CACHE_TAG);
    }
}