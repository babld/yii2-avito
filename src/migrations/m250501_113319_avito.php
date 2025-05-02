<?php

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
            'field_name' => $this->integer(),
            'value' => $this->string(1000),
            'item_id' => $this->integer(),
            'model_name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250501_113319_avito cannot be reverted.\n";

        return false;
    }
}
