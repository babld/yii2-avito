<?php

namespace babld\avito\migrations;

use yii\db\Migration;

class m250719_125730_add_ListingFee_field_in_avito_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('avito', 'listing_fee', $this->string(255)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('avito', 'listing_fee');
    }
}
