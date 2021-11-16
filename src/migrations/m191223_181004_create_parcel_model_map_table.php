<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel_model_map}}`.
 */
class m191223_181004_create_parcel_model_map_table extends Migration
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

        $this->createTable('{{%parcel_model_map}}', [
            'id' => $this->primaryKey(),
            'name' =>  $this->string(256),
            'map' => $this->text(),
            'function' => $this->string(128),
            'model' => $this->string(256),
            'default' => $this->tinyInteger()->defaultValue(1),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parcel_model_map}}');
    }
}
