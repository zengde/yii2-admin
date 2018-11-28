<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-06
 * Time: 17:31
 */

namespace backend\models\searchs;


use backend\components\MyDataProvider;
use backend\models\Category;
use backend\models\ProcatView;

class ProductSearch extends ProcatView
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['catid','status'],'integer']
        ];
    }

    public function search($params){
        $fields='id,catid,name,smalltext,status,clickcount,price,goods_img,thumb_img,lwh,last_time,catname';
        $query = ProcatView::find()->select($fields)->asArray();
        $dataProvider = new MyDataProvider([
            'query' => $query,
            'pageSize'=>13
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['status'=>$this->status]);
        if($this->catid){
            $arrchildid=Category::find()->where("id=".$this->catid)->select('arrchildid');
            $query->andFilterWhere(['in','catid',$arrchildid]);
        }

        return $dataProvider;
    }

}