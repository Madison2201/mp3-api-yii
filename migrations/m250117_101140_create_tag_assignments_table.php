<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_assignments}}`.
 */
class m250117_101140_create_tag_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag_assignments}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-tag_assignments}}', '{{%tag_assignments}}', ['post_id', 'tag_id']);

        $this->createIndex('{{%idx-tag_assignments-post_id}}', '{{%tag_assignments}}', 'post_id');
        $this->createIndex('{{%idx-tag_assignments-tag_id}}', '{{%tag_assignments}}', 'tag_id');

        $this->addForeignKey('{{%fk-tag_assignments-post_id}}', '{{%tag_assignments}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-tag_assignments-tag_id}}', '{{%tag_assignments}}', 'tag_id', '{{%tags}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_assignments}}');
    }
}
