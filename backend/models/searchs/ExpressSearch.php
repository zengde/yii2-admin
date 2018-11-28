<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-09
 * Time: 9:13
 */

namespace backend\models\searchs;


use backend\components\MyDataProvider;
use backend\models\ExpressCompany;

class ExpressSearch extends ExpressCompany
{
    public function search($params){
        $query=ExpressCompany::find();
        $dataProvider=new MyDataProvider([
            'query'=>$query
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}