<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel_shipment}}`.
 */
class m191218_123108_create_parcel_shipment_table extends Migration
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

        $this->createTable('{{%parcel_shipment}}', [
            'id' => $this->primaryKey(),
            'function' => $this->string(128),
            'model' => $this->string(256),
            'model_id' => $this->integer(),
            'data' => $this->text(),
            'response' => $this->text(),
            'handover_protocol_id' => $this->integer()->defaultValue(0),
            'is_active' => $this->tinyInteger()->defaultValue(1),
            'created_at' => $this->date(),
            'user_id' => $this->integer()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parcel_shipment}}');
    }
}