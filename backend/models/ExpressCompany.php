<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%express_company}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $cperson
 * @property string $cellphone
 * @property string $qq
 * @property string $email
 * @property string $website
 * @property string $adddate
 */
class ExpressCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%express_company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['adddate'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['cperson', 'email', 'website'], 'string', 'max' => 50],
            [['cellphone', 'qq'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'cperson' => 'Cperson',
            'cellphone' => 'Cellphone',
            'qq' => 'Qq',
            'email' => 'Email',
            'website' => 'Website',
            'adddate' => 'Adddate',
        ];
    }
    
    public static function getlist(){
        return ExpressCompany::find()->select('id,name')
                ->asArray()
                ->all();
    }
}
