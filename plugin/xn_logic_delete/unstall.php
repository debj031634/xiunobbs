<?php

/**
 * 逻辑删除 卸载程序
 *
 * @create 2023-7-27
 * @author 小肥羊
 */

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;


db_exec("ALTER TABLE {$tablepre}thread DROP COLUMN deleted;");
db_exec("ALTER TABLE {$tablepre}post DROP COLUMN deleted;");
db_exec("ALTER TABLE {$tablepre}group DROP COLUMN allowharddelete;");



?>