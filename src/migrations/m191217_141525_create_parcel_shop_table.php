<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel_shop}}`.
 */
class m191217_141525_create_parcel_shop_table extends Migration
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

        $this->createTable('{{%parcel_shop}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(64),
            'place_id' => $this->string(256),
            'description' => $this->text(),
            'address' => $this->string(256),
            'city' => $this->string(256),
            'zip' => $this->string(16),
            'virtualzip' => $this->string(16),
            'countryISO' => $this->string(3),
            'status' => $this->smallInteger(),
            'gps' => $this->text(),
            'center' => $this->integer(),
            'workDays' => $this->text(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parcel_shop}}');
    }
}