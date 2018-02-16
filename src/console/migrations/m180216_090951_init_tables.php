<?php

namespace bulldozer\banners\console\migrations;

use bulldozer\App;
use bulldozer\users\rbac\DbManager;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m180216_090951_init_tables
 */
class m180216_090951_init_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(11)->unsigned(),
            'updated_at' => $this->integer(11)->unsigned(),
            'creator_id' => $this->integer(11)->unsigned(),
            'updater_id' => $this->integer(11)->unsigned(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->string(500),
            'image_id' => $this->integer(11)->unsigned()->notNull(),
            'active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer(11)->unsigned(),
        ], $tableOptions);

        $authManager = $this->getAuthManager();

        $manageCatalog = $authManager->createPermission('banners_manage');
        $manageCatalog->name = 'Управление баннерами';
        $authManager->add($manageCatalog);

        $admin = $authManager->getRole('admin');
        $authManager->addChild($admin, $manageCatalog);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%banners}}');

        $authManager = $this->getAuthManager();

        $managePages = $authManager->getPermission('banners_manage');
        $authManager->remove($managePages);
    }

    /**
     * @throws InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = App::$app->getAuthManager();

        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }
}
