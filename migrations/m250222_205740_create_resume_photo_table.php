<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%resume_photo}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%resume}}`
 */
class m250222_205740_create_resume_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%resume_photo}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(),
            'resume_id' => $this->integer()->notNull(),
            'sort' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `resume_id`
        $this->createIndex(
            '{{%idx-resume_photo-resume_id}}',
            '{{%resume_photo}}',
            'resume_id'
        );

        // add foreign key for table `{{%resume}}`
        $this->addForeignKey(
            '{{%fk-resume_photo-resume_id}}',
            '{{%resume_photo}}',
            'resume_id',
            '{{%resume}}',
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
            '{{%fk-resume_photo-resume_id}}',
            '{{%resume_photo}}'
        );

        // drops index for column `resume_id`
        $this->dropIndex(
            '{{%idx-resume_photo-resume_id}}',
            '{{%resume_photo}}'
        );

        $this->dropTable('{{%resume_photo}}');
    }
}
