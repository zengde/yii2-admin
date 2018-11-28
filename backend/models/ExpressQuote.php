<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%express_quote}}".
 *
 * @property integer $id
 * @property integer $areaid
 * @property integer $companyid
 * @property integer $sizeprice
 * @property string $weightprice
 * @property string $sendtime
 */
class ExpressQuote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%express_quote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['areaid', 'companyid'], 'required'],
            [['areaid', 'companyid', 'sizeprice'], 'integer'],
            [['weightprice'], 'number'],
            [['sendtime'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaid' => 'Areaid',
            'companyid' => 'Companyid',
            'sizeprice' => 'Sizeprice',
            'weightprice' => 'Weightprice',
            'sendtime' => 'Sendtime',
        ];
    }

    public function getArea(){
        return $this->hasOne(Area::className(), ['id' => 'areaid']);
    }

}
