<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel_account}}`.
 */
class m191211_125414_create_parcel_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%parcel_account}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'username' => $this->text(),
            'password' => $this->text(),
            'default' => $this->tinyInteger()->defaultValue(1),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parcel_account}}');
    }
}