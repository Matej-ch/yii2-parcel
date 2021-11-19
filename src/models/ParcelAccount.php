<?php

namespace matejch\parcel\models;

use matejch\parcel\Parcel;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "solver_api".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property int $default
 * @property string|null $name
 */
class ParcelAccount extends ActiveRecord
{

    private $key;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel_account';
    }

    public function init()
    {
        parent::init();
        $this->key = Parcel::getInstance()->key;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->username = $this->encryptData($this->username,$this->key);
        $this->password = $this->encryptData($this->password,$this->key);

        if($this->default) {
            foreach (self::find()->all() as $account) {
                /** @var ParcelAccount $account */
                $account->default = false;
                $account->update();
            }
        }

        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        if($this->username) {
            $this->username = $this->decryptData($this->username, $this->key);
        }

        if($this->password) {
            $this->password = $this->decryptData($this->password, $this->key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            [['name'],'string', 'max' => 256],
            [['default'], 'boolean'],
            [['default'], 'default', 'value' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Parcel::t('model','id'),
            'username' => Parcel::t('model','username'),
            'password' => Parcel::t('model','password'),
            'name' => Parcel::t('model','name'),
            'default' => Parcel::t('model','default'),
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => Parcel::t('model','name_hint'),
            'default' => Parcel::t('model','default_hint'),
            'username' => Parcel::t('model','username_hint'),
            'password' => Parcel::t('model','password_hint'),
        ];
    }

    /**
     * Decrypt data
     * @param string $data
     * @param string $key
     * @return string
     */
    private function decryptData(string $data,string $key): string
    {
        $c = base64_decode($data);
        $ivLen = openssl_cipher_iv_length('AES-128-CBC');
        $iv = substr($c, 0, $ivLen);
        $hmac = substr($c, $ivLen, $sha2len=32);
        $cipherTextRaw = substr($c, $ivLen+$sha2len);
        $plainText = openssl_decrypt($cipherTextRaw, 'AES-256-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcMac = hash_hmac('sha256', $cipherTextRaw, $key, $as_binary=true);
        if (hash_equals($hmac, $calcMac)) {
            return $plainText;
        }
        return '';
    }

    /**
     * Encrypt API data before saving them into database
     * @param string $data
     * @param string $key
     * @return string
     */
    private function encryptData(string $data, string $key): string
    {
        $ivSize = openssl_cipher_iv_length('AES-128-CBC');
        $iv = openssl_random_pseudo_bytes($ivSize,$isSourceStrong);
        if(false === $isSourceStrong || false === $iv) {
            throw new \RuntimeException('IV generation failed');
        }
        $cipherStringRaw = openssl_encrypt($data,'AES-256-CBC',$key,OPENSSL_RAW_DATA,$iv);
        $hmac = hash_hmac('sha256', $cipherStringRaw, $key, $as_binary=true);
        return base64_encode($iv . $hmac . $cipherStringRaw);
    }

    public static function findDefault($id = null): ?ParcelAccount
    {
        if($id) {
            return self::findOne(['id' => $id]);
        }

        return self::findOne(['default' => 1]);
    }

}
