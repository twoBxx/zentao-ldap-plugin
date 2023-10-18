<?php
/**
 * The user module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: zh-cn.php 5053 2013-07-06 08:17:37Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->ldap->common 		= "LDAP";
$lang->ldap->setting    	= "设置";

$lang->ldap->base   = '基本配置';
$lang->ldap->attr   = '属性配置';
$lang->ldap->other  = '其他配置';
$lang->ldap->example        = "例如";

$lang->ldap->turnon       = '功能状态';
$lang->ldap->ssl 			= '协议';
$lang->ldap->host 			= 'LDAP服务器';
$lang->ldap->port           = '端口号';
$lang->ldap->version 		= '协议版本';
$lang->ldap->bindDN 		= 'BindDN';
$lang->ldap->password 		= 'BindDN 密码';
$lang->ldap->baseDN 		= 'searchDN';
$lang->ldap->uid 	        = '账号字段';
$lang->ldap->mail 			= '邮箱';
$lang->ldap->name  			= '显示名称';
$lang->ldap->mobile  			= '手机号';
$lang->ldap->group  			= '默认用户组';

$lang->ldap->sync 			= '手动同步';
$lang->ldap->save 			= '保存设置';
$lang->ldap->test 			= '测试连接';

$lang->ldap->placeholder->group 	= '为从ldap通过过来的用户添加一个默认权限';
$lang->ldap->accountPS = 'LDAP服务器中对应个人用户名的字段';

$lang->ldap->turnonList[0] = '关闭';
$lang->ldap->turnonList[1] = '开启';
// 是否开启ssl模式
$lang->ldap->sslList[0] = 'ldap://';
$lang->ldap->sslList[1] = 'ldaps://';

$lang->ldap->versionList[3] = '3';
$lang->ldap->versionList[2] = '2';

$lang->ldap->methodOrder[5] = 'index';
$lang->ldap->methodOrder[10] = 'setting';