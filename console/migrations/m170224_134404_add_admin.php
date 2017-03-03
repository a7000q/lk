<?php

use yii\db\Migration;

class m170224_134404_add_admin extends Migration
{
    public function up()
    {

        $this->insert("user", [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'mHkfy6uhml2ahHKt4lkGRZBTzx-wA3mr',
            'password_hash' => md5("123456"),
            'email' => "a7000q@gmail.com",
            'status' => 10,
            'created_at' => time()
        ]);
    }

    public function down()
    {
        $this->delete("user", "id=1");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
