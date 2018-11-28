<?php
/**
 * User: lzkong1029
 * Date: 2016-7-6
 * Time: 15:10
 * Description:静态公共函数类库
 */

namespace backend\components;
use backend\models\Log;
use Yii;

class Helper {

    public static function hello(){
        echo 'hello';
    }

    //历史访客数
    public static function getHistoryVisNum(){
        $res = Log::find()->count();
        return $res;
    }

    //最近一个月访问量
    public static function getMonthHistoryVisNum(){
        $LastMonth = strtotime("-1 month");
        $res = Log::find()->where(['>','create_time',$LastMonth])->count();
        return $res;
    }

    public static function dir_path($path) {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/')
            $path = $path . '/';
        return $path;
    }

    public static function dir_create($file, $mode = 0777) {
        if (is_array($file)) {
            foreach ($file as $f) {
                static::dir_create($f);
            }
        } else {
            $path=  dirname($file);
            if (is_dir($path))
                return TRUE;
            $path = static::dir_path($path);
            $temp = explode('/', $path);
            $cur_dir = '';
            $max = count($temp) - 1;
            for ($i = 0; $i < $max; $i++) {
                $cur_dir .= $temp[$i] . '/';
                if (@is_dir($cur_dir))
                    continue;
                @mkdir($cur_dir, 0777, true);
            }
            return is_dir($path);
        }
    }
    
    public static function genTree5($items) {
        foreach ($items as $item)
            $items[$item['parentid']]['children'][$item['id']] = &$items[$item['id']];
        return isset($items[0]['children']) ? $items[0]['children'] : array();
    }
}