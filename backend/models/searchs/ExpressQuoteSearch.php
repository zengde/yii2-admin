<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-09
 * Time: 10:50
 */

namespace backend\models\searchs;


use backend\components\MyDataProvider;
use backend\models\Area;
use backend\models\ExpressQuote;

class ExpressQuoteSearch extends ExpressQuote
{
    public $city;//地址
    public $companyname;//物流名称
    public $area_tree;

    public function rules()
    {
        return [
            ['companyid','safe'],
            ['areaid','integer'],
            ['city','string']
        ];
    }

    public function search($params){
        $fields='a.*,b.name city,c.name companyname';
        $query=self::find()->alias('a')->select($fields)
        ->leftJoin('{{%area}} b','a.areaid=b.id')
        ->leftJoin('{{%express_company}} c','a.companyid=c.id');

        $dataProvider=new MyDataProvider([
            'query'=>$query,
            'pageSize'=>20
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['in','a.areaid',$this->getarrChild()])
        ->andFilterWhere(['like','b.name',$this->city]);

        return $dataProvider;
    }

    public function getareaAll(){
        if(!$this->area_tree){
            $this->area_tree=Area::cache_area_all();
        }
        return $this->area_tree;
    }

    public function getarrChild(){
        $area_tree=$this->getareaAll();
        if($this->areaid){
            return explode(',',$area_tree[$this->areaid]['arrchildid']);
        }
    }

    //完整城市名字
    public function getfullCity($areaid,$city){
        return isset($this->area_tree[$areaid])? $this->area_tree[$areaid]['name']:$city;
    }

}