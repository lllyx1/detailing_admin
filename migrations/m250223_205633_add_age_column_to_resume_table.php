<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%resume}}`.
 */
class m250223_205633_add_age_column_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%resume}}', 'age', $this->dateTime());
        $this->addColumn('{{%resume}}', 'name', $this->string());
        $this->addColumn('{{%resume}}', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%resume}}', 'age');
        $this->dropColumn('{{%resume}}', 'name');
        $this->dropColumn('{{%resume}}', 'phone');
    }
}
