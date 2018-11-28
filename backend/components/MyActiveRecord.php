<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;

/**
 * Description of MyActiveRecord
 *
 * @author zeng
 */
class MyActiveRecord extends \yii\db\ActiveRecord{
    /**
     * 类似getDirtyAttributes，不使用===
     * @param type $names
     * @return type
     */
    public function getLDirtyAttributes($names = null)
    {
        if ($names === null) {
            $names = $this->attributes();
        }
        $names = array_flip($names);
        $attributes = [];
        $_oldattributes=$this->getOldAttributes();
        $_attributes=$this->getAttributes();
        if ($_oldattributes === null) {
            foreach ($_attributes as $name => $value) {
                if (isset($names[$name])) {
                    $attributes[$name] = $value;
                }
            }
        } else {
            foreach ($_attributes as $name => $value) {
                if (isset($names[$name]) && (!array_key_exists($name, $_oldattributes) || $value != $_oldattributes[$name])) {
                    $attributes[$name] = $value;
                }
            }
        }
        return $attributes;
    }
}
