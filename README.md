<p align="center">
    <h1 align="center">这个一个基于yii2框架搭建的一个后台模板</h1>
    <br>
</p>

这是一个基于Yii 2 高级版搭建的一个后台模板，下载即可使用

也可以使用 composer create-project ynlc/backstage-template 来创建

若下载下来没有vendor目录 就进入到项目所在路径 然后执行 composer install 如果安装失败就需要翻墙了

项目的controller统一从common/controllers中的CommonController继承，

数据库等配置在config里面通过不同环境配置如dev环境就选择dev目录下的db.php

gii新增xgmodel模块


YII2的migrations目录位于console中, 打开命令行窗口,转到YII框架目录.

1.创建一个新的migrations时间戳文件:

　　输入: yii migrate/create init-user-table, 然后输入yes确认. 这样在console的migrations目录下就生成了一个新的时间戳文件: m170514_041000_init_user_table.php

use yii\db\Migration;

use yii\db\Migration;

class m170514_041000_init_user_table extends Migration
{
    public function up()
    {

    }

    public function down()
    {
        echo "m170514_041000_init_user_table cannot be reverted.\n";

        return false;
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

2.写入代码, 目的是创建一个user表:
use yii\db\Migration;

class m170514_041000_init_user_table extends Migration

{

const TBL_NAME = '{{%user}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(TBL_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable(TBL_NAME);
    }
}

3.执行migrate:

　　在命令行中输入: yii migrate 回车, 再输入yes确认, 这样在MySQL数据库中就生成了一个user表;

yii2版本2.07后，增加了更细致的分类，例如我已经创建了admin表，但少了一个status字段，那可以直接用下面命令便会生成只增加字段的文件

yii migrate/create add_column_to_admin --fields=status:int(10):nontNull

