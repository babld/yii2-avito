<?php

namespace babld\avito\migrations;

use yii\db\Migration;

class m250525_084759_alert_external_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%avito}}', 'external_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%avito}}', 'external_id', $this->integer());
    }
}
