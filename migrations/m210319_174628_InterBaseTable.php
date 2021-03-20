<?php

use yii\db\Migration;

/**
 * Class m210319_174628_InterBaseTable
 */
class m210319_174628_InterBaseTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('allowed_guilds', [
            'id' => 'pk AUTO_INCREMENT',
            'guild_id' => 'int',
            'access_url' => 'varchar(255)'
        ]);
        $this->createTable('guilds_tags', [
            'guild_id' => 'int',
            'tag_id' => 'int'
        ]);
        $this->createTable('users_to_guilds', [
            'guild_id' => 'int',
            'user_id' => 'int',
        ]);
        $this->createTable('dir_tags', [
            'id' => 'pk AUTO_INCREMENT',
            'tag' => 'varchar(50)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('allowed_guilds');
        $this->dropTable('guilds_tags');
        $this->dropTable('users_to_guilds');
        $this->dropTable('dir_tags');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210319_174628_InterBaseTable cannot be reverted.\n";

        return false;
    }
    */
}
