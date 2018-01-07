<?php

use yii\db\Migration;

/**
 * Class m171204_093247_rbac_add_admin_item
 */
class m171204_093247_rbac_add_admin_item extends Migration
{
    const USER_AUTO_INCREMENT_NUM = 1000;

    public function up()
    {
        $now = time();
        $this->insert('{{%auth_item}}', [
            'name' => '/*',
            'type' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $this->insert('{{%auth_item}}', [
            'name' => 'Super administrator',
            'type' => 1,
            'description' => 'Have all the permissions',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'Super administrator',
            'user_id' => self::USER_AUTO_INCREMENT_NUM,
            'created_at' => $now
        ]);

        $this->insert('{{%auth_item_child}}', [
            'parent' => 'Super administrator',
            'child' => '/*'
        ]);
    }

    public function down()
    {
        echo "m171204_093247_rbac_add_admin_item cannot be reverted.\n";

        return false;
    }
}
