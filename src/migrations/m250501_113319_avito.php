<?php

namespace babld\avito\migrations;

use yii\db\Migration;

class m250501_113319_avito extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('avito', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'model_name' => $this->string(),

            'is_active' => $this->boolean(),
            'description' => $this->text()->notNull(),
            'video_url' => $this->string(),
            'internal_id' => $this->string()->unique(),
            'external_id' => $this->integer(),
            'manager_name' => $this->string(),
            'phone' => $this->string(),
            'address' => $this->string(),
            'lat_lon' => $this->string(),
            'contact_method' => $this->string(),
            'category' => $this->string(),
            'price' => $this->string(),
            'internet_calls' => $this->boolean(),
            'operation_type' => $this->string(),
            'rooms' => $this->integer(),
            'property_rights' => $this->integer(),
            'object_type' => $this->integer(),
            'floors' => $this->integer(),
            'walls_type' => $this->string(),
            'square' => $this->string(),
            'land_area' => $this->string(),
            'land_status' => $this->string(),
            'renovation' => $this->string(),
            'safe_demonstration' => $this->integer(),
            'land_additionally' => $this->integer(),
            'bathroom_multi' => $this->integer(),
            'house_services' => $this->integer(),
            'house_additionally' => $this->integer(),
            'parking_type' => $this->integer(),
            'transport_accessibility' => $this->integer(),
            'built_year' => $this->string(),
            'electricity' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('avito');
    }
}
