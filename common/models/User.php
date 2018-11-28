<?php
namespace common\models;

use backend\models\AuthItem;
use common\behaviors\IpBehavior;
use backend\components\MyUploadedFile;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use backend\models\AuthAssignment;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $realname
 * @property integer $roleid 权限组，yii中仅作为判断超级管理员
 * @property integer $groupid
 * @property integer $phone
 * @property integer $qq
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const ROLE_USER = 2;
    const ROLE_ADMIN = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            IpBehavior::className(),
            [
                'class'=>'common\behaviors\CnSpellBehavior',
                'sourceAttribute'=>'realname',
                'spellAttribute'=>'username',
                'isforce'=>false,
                'isupdate'=>false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash'], 'required','except'=>'update'],
            [['roleid','groupid', 'status','phone','qq'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['username','realname','email'], 'string', 'max' => 100],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username'], 'unique'],
            ['roleid', 'default', 'value' => self::ROLE_USER],
            ['email','email'],
            [['username'],'yii\validators\InlineValidator','skipOnEmpty'=>false,'method'=>'hasName','params'=>'realname']
        ];
    }

    public function hasName($attribute, $params)
    {
        if($this->$attribute==null&&$this->$params==null){
            $this->addError($attribute, '用户名或真实姓名不能为空');
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    public function getIsAdmin()
    {
        return $this->roleid == static::ROLE_ADMIN;
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getAssign()
    {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

    public function getItem()
    {
        return $this->hasOne(AuthItem::class, ['name' => 'item_name'])
            ->via('assign');
    }

    public function getFullname(){
        return $this->realname? :$this->username;
    }
}
