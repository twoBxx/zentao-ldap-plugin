<?php
$lang->admin->menu->ldap      = array('link' => 'LDAP|ldap|index', 'subModule' => 'ldap');
$lang->ldap      = new stdclass();
$lang->ldap->menu 	   = $lang->admin->menu;
$lang->menugroup->ldap 		  = 'admin';
$lang->admin->menuOrder[100] = 'ldap';
$lang->ldap->menuOrder      = $lang->admin->menuOrder;