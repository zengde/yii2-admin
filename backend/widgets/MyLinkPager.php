<?php
namespace backend\widgets;

/**
 * Description of MyLinkPager
 *
 * @author zeng
 */
class MyLinkPager extends \yii\widgets\LinkPager{
    public $dataProvider;
    public $options=['class'=>'pagination pagination-lg pull-right'];
    
    public function init() {
        if($this->dataProvider!=null)
            $this->pagination=$this->dataProvider->getPagination();
        parent::init();
    }

}
