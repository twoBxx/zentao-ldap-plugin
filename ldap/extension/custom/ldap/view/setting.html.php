<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/datepicker.html.php';?>
<div id='mainContent' class='main-content'>
    <div class='center-block'>
        <form method="post" class="main-form" action='<?php echo inlink('save');?>' id='ldapForm'>
            <div class='detail-title'><?php echo $lang->ldap->base?></div>
            <table class='table table-form'>
                <!-- 功能开启状态 -->
                <tr>
                    <th class='thWidth'><?php echo $lang->ldap->turnon?></th>
                    <td class='w-400px'>
                        <?php echo html::select('turnon', $lang->ldap->turnonList, $config->ldap->turnon, "class='form-control  chosen'")?>
                    </td>
                    <td></td>
                </tr>
                <!-- LDAP HOST -->
                <tr>
                    <th><?php echo $lang->ldap->ssl?></th>
                    <td class='required'>
                        <?php echo html::select('ssl',$lang->ldap->sslList,empty($config->ldap->ssl) ? 'ldap://' : $config->ldap->ssl,"class='form-control chosen'");?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $lang->ldap->host?></th>
                    <td class='required'>
                        <?php echo html::input('host', $config->ldap->host, "class='form-control' autocomplete='off'")?>
                    </td>
                    <td><?php echo $lang->ldap->example . 'ldap.test.com'?></td>
                </tr>
                <!-- LDAP PORT -->
                <tr>
                    <th><?php echo $lang->ldap->port?></th>
                    <td class='required'>
                        <?php echo html::input('port', $config->ldap->port, "class='form-control' autocomplete='off'")?>
                    </td>
                    <td><?php echo $lang->ldap->example . '389'?></td>
                </tr>
                <!-- VERSION -->
                <tr>
                    <th><?php echo $lang->ldap->version?></th>
                    <td><?php echo html::select('version',$lang->ldap->versionList, empty($config->ldap->version) ? '3' : $config->ldap->version, "class='form-control chosen'")?>
                    </td>
                </tr>
                <!-- LDAP Base DN -->
                <tr>
                    <th><?php echo $lang->ldap->baseDN; ?></th>
                    <td class='required'>
                        <?php echo html::input('baseDN', $config->ldap->baseDN, "class='form-control'");?></td>
                    <td><?php echo $lang->ldap->example . 'ou=users,dc=test,dc=com'?></td>
                </tr>
                <!-- LDAP Admin Bind DN -->
                <tr>
                    <th><?php echo $lang->ldap->bindDN; ?></th>
                    <td class='required'>
                        <?php echo html::input('bindDN', $config->ldap->bindDN, "class='form-control'");?></td>
                    <td><?php echo $lang->ldap->example . 'cn=admin,dc=test,dc=com'?></td>
                </tr>
                <!-- LDAP Admin Bind Password -->
                <tr>
                    <th><?php echo $lang->ldap->password; ?></th>
                    <td class='required'>
                        <?php echo html::password('bindPWD', $config->ldap->bindPWD, "class='form-control'");?></td>
                </tr>
            </table>
            <div class='detail-title'><?php echo $lang->ldap->attr?></div>
            <table class='table table-form'>
                <!-- LDAP UID 映射字段 -->
                <tr>
                    <th class='thWidth'><?php echo $lang->ldap->uid?></th>
                    <td class='w-400px required'>
                        <?php echo html::input('uid', empty($config->ldap->uid) ? 'uid' : $config->ldap->uid, "class='form-control' autocomplete='off'")?>
                    </td>
                    <td><?php echo $lang->ldap->accountPS?></td>
                </tr>
                <!-- 默认导入分组 -->
                <tr>
                    <th><?php echo $lang->ldap->group; ?></th>
                    <td>
                        <?php echo html::select('group', $groupList, (!empty($group) ? $group : '1'), "class='form-control chosen'");?>
                    </td>
                    <td><?php echo $lang->ldap->placeholder->group;?></td>
                </tr>
                <!-- LDAP 真实姓名字段 -->
                <tr>
                    <th><?php echo $lang->ldap->name?></th>
                    <td><?php echo html::input('name', empty($config->ldap->name) ? 'cn' : $config->ldap->name, "class='form-control' autocomplete='off'")?>
                    </td>
                </tr>
                <!-- LDAP 邮箱字段映射-->
                <tr>
                    <th><?php echo $lang->ldap->mail?></th>
                    <td><?php echo html::input('mail', empty($config->ldap->mail) ? 'mail' : $config->ldap->mail, "class='form-control' autocomplete='off'")?>
                    </td>
                </tr>
                <!-- LDAP 手机号字段 -->
                <tr>
                    <th><?php echo $lang->ldap->mobile?></th>
                    <td><?php echo html::input('mobile', empty($config->ldap->mobile) ? 'mobile' : $config->ldap->mobile, "class='form-control' autocomplete='off'")?>
                    </td>
                </tr>
                <!-- LDAP 操作按钮 -->
                <tr>
                    <td colspan='3' class="text-center form-actions">
                        
                        <?php $disabled = empty($config->ldap->turnon) ? 'disabled' : '';?>
                        <!-- 提交按钮 -->
                        <?php echo html::submitButton($lang->ldap->save, '', 'btn btn-secondary btn-wide');?>
                        <!-- 测试链接 -->
                        <?php echo html::commonButton($lang->ldap->test, "onclick='javascript:onClickTest()' $disabled",'btn btn-primary') ?>
                        <!-- 同步数据 -->
                        <?php echo html::commonButton($lang->ldap->sync, "onclick='javascript:sync()' $disabled",'btn btn-primary');?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
<?php
  echo '<script>';
include '../js/setting.js';
echo '</script>';
;?>
