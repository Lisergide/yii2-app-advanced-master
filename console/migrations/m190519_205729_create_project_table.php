<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m190519_205729_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(0),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fx_project_user_creator', 'project', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_project_user_updater', 'project', ['updater_id'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');

        return true;
    }
}
