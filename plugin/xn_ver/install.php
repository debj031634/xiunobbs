<?php

/*
	Xiuno BBS 4.0 插件实例：TAG 插件安装
	admin/plugin-install-xn_tag.htm
*/

!defined('DEBUG') AND exit('Forbidden');

$tablepre = $db->tablepre;

// 加一个版本号字段
$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN vernum char(16) NOT NULL DEFAULT ''";
$r = db_exec($sql);

// 版本更新时间
$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN ver_time int(11) unsigned NOT NULL DEFAULT '0'";
$r = db_exec($sql);

// 加一个图片字段
$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN ver_pic char(255) NOT NULL DEFAULT ''";
$r = db_exec($sql);

// 加一个密码字段
$sql = "ALTER TABLE {$tablepre}thread ADD COLUMN ver_pass char(16) NOT NULL DEFAULT ''";
$r = db_exec($sql);

//$r === FALSE AND message(-1, '创建表结构失败');

?>