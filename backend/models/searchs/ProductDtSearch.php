<?php
/**
 * DataTables 搜索
 * User: zeng
 * Date: 2017-06-08
 * Time: 10:39
 */

namespace backend\models\searchs;


use backend\components\MyDataProvider;
use backend\models\ProcatView;

class ProductDtSearch extends ProcatView
{
    public $draw;
    public $columns;
    public $order;
    public $start;
    public $length;
    public $search;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['columns','order','search'], 'safe'],
            [['draw','start','length'],'integer']
        ];
    }

    public function search($params){
        $this->load($params,'');

        $fields='id,catid,name,smalltext,status,clickcount,price,goods_img,thumb_img,lwh,last_time,catname';
        $query = ProcatView::find()->select($fields)->asArray();
        $dataProvider = new MyDataProvider([
            'query' => $query,
            'pageSize'=>$this->length,
            'pageOffset'=>$this->start
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->search['value']]);

        $order=$this->order[0];
        $orderfield=$this->columns[$order['column']]['data'];
        $orderfield=$orderfield? :'id';
        $query->orderBy("$orderfield {$order['dir']}");

        $res=[
            "draw" => $this->draw,
            'data'=>$dataProvider->getModels(),
            'recordsTotal'=>$dataProvider->getTotalCount(),
            'recordsFiltered'=>$dataProvider->getTotalCount()
        ];
        return $res;
    }
}