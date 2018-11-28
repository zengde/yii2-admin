<?php
namespace backend\components;
use yii\base\InvalidConfigException;
use yii\db\QueryInterface;

/**
 * Description of MyDataProvider
 *
 * @author zeng
 */
class MyDataProvider extends \yii\data\ActiveDataProvider{
    public $pageSize=10;
    public $pageOffset;

    public function setPagination($value) {
        if(is_array($value)){
            $value['pageSize']=isset($value['pageSize'])? $value['pageSize']:$this->pageSize;
        }
        return parent::setPagination($value);
    }

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $offset=$this->pageOffset? :$pagination->getOffset();
            $query->limit($pagination->getLimit())->offset($offset);
        }
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }

        return $query->all($this->db);
    }
}
