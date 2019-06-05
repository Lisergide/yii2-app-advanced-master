<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190519_204053_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fx_task_user_executor', 'task', ['executor_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user_creator', 'task', ['creator_id'], 'user', ['id']);
        $this->addForeignKey('fx_task_user_updater', 'task', ['updater_id'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');

        return true;
    }
}
