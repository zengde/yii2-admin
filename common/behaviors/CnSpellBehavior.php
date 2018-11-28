<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-03-30
 * Time: 17:37
 */

namespace common\behaviors;


use yii\base\InvalidCallException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class CnSpellBehavior extends AttributeBehavior
{
    public $sourceAttribute='name';//源属性
    public $spellAttribute = 'pinyin';//目标属性
    public $isforce=true;
    public $isupdate=true;//是否在更新数据时可用

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT] = $this->spellAttribute;
            if($this->isupdate)
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_UPDATE] = $this->spellAttribute;
        }
    }

    protected function getValue($event)
    {
        if ($this->value === null) {
            $source=$this->owner->{$this->sourceAttribute};
            $spell=$this->owner->{$this->spellAttribute};
            if($this->isforce||empty($spell)){
                require_once \Yii::getAlias('@common/lib/pinyin.class.php');
                return (new \ChineseSpell)->getFullSpell($source, '');
            }elseif(!empty($spell)){
                return $spell;
            }
        }
        return parent::getValue($event);
    }

    /**
     * 手动更新
     * @param $attribute
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('禁止在新增数据时更新');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}