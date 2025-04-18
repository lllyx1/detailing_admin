<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%resume_city}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%resume}}`
 * - `{{%city}}`
 */
class m250223_205911_create_junction_table_for_resume_and_city_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%resume_city}}', [
            'resume_id' => $this->integer(),
            'city_id' => $this->integer(),
            'PRIMARY KEY(resume_id, city_id)',
        ]);

        // creates index for column `resume_id`
        $this->createIndex(
            '{{%idx-resume_city-resume_id}}',
            '{{%resume_city}}',
            'resume_id'
        );

        // add foreign key for table `{{%resume}}`
        $this->addForeignKey(
            '{{%fk-resume_city-resume_id}}',
            '{{%resume_city}}',
            'resume_id',
            '{{%resume}}',
            'id',
            'CASCADE'
        );

        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-resume_city-city_id}}',
            '{{%resume_city}}',
            'city_id'
        );

        // add foreign key for table `{{%city}}`
        $this->addForeignKey(
            '{{%fk-resume_city-city_id}}',
            '{{%resume_city}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%resume}}`
        $this->dropForeignKey(
            '{{%fk-resume_city-resume_id}}',
            '{{%resume_city}}'
        );

        // drops index for column `resume_id`
        $this->dropIndex(
            '{{%idx-resume_city-resume_id}}',
            '{{%resume_city}}'
        );

        // drops foreign key for table `{{%city}}`
        $this->dropForeignKey(
            '{{%fk-resume_city-city_id}}',
            '{{%resume_city}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-resume_city-city_id}}',
            '{{%resume_city}}'
        );

        $this->dropTable('{{%resume_city}}');
    }
}
