# 简介

这个插件是在 “[禅道开源版LDAP插件](https://github.com/TigerLau1985/ZenTao_LDAP)” 上基础进行的修正
目前测试版本为 **18.7**

## 功能
1. 兼容本地用户和LDAP用户同时登录
    * 插件安装即开启，无数据同步不会对现有登录方式产生任何影响
    * 请检查所使用的数据库中 `zt_user` 是否存在字段 `ldap`，如不存在，则需要在 `db` 目录中增加脚本，详情参考 [禅道二次开发手册](https://www.zentao.net/book/api/144.html) 中的 **目录结构** 章节
    * <span style='color:red' >`admin` 用户也会被覆盖。 LDAP 中要导入的数据存在 `admin` 账户时，切记要先备份原数据</span>
2. 支持默认分组功能，数据落地 DB(`zt_usergroup` 表)
3. 分离 **协议** 、**端口** 字段
4. 新增手机号数据保存

## 说明
参考文档：
- [菜单配置](https://www.zentao.net/book/zentaopmshelp/68.html#3)

### 使用
需要将 `ldap` 目录打成压缩包，或者直接在当前目录执行脚本 `package.sh`
### 菜单配置
*LDAP* 菜单挂载在 `后台->系统设置->LDAP` 中， 属于模块菜单，对应的配置为 `$lang->admin->menuList->system['subMenu']['ldap']`

目前菜单配置在 `admin` 模块下，需要修改的话，只需要修改到对应的模块即可,
EX: `$lang->admin->menuList->company['subMenu']['xxxx'] => array('link' => "{$lang->xxxx->common}|xxxx|index|", 'subModule' => 'xxxx');`

上面的代码，表示 在 `admin` 模块下，对其子模块菜单进行修改，修改的模块为 `company` ，挂载了一个名为 `xxxx` 的新模块，指向自己的模块

### 代码修改
如果要修改/新增自己的数据，比如，要加入 `dingding`/`weixin` 字段
需要修改的地方为:
1. `ldap/model.php` 中 `sync2db` 方法, 修改 `$user` 对象即可,如: `$user->dingding = xxxx`


### Debug 调试
1. 修改文件 `vi /apps/zentao/config/my.php`, 打开 Debug：
将`$config->debug` 值修改为 **`true`**
2. 查看日志，日志目录在 `/apps/zentao/tmp/log` 或 `/apps/zentao/tmp/log.14` , 2个文件夹的区别是版本的区别

### 配置示例

|  选项   | 示例值  | 必填 | 默认值 |
|  ----  | ----  | --- | --- |
|基础配置||||
|||||
| 协议  | 	ldap:// | T | ldap:// |
| LDAP服务器  | 	ldap.test.com | T | |
| 端口  | 	389 | T | |
| searchDN  | ou=users,dc=test,dc=com | T| |
| BindDN  | cn=admin,dc=test,dc=com | T | |
| BindDN 密码  | ou=users,dc=test,dc=com | T | | 
|||||
|属性配置||||
|||||
| 账号字段  | 	uid | T | uid |
| 默认用户组  | 	下拉选择 | F | 管理员 |
| Mail  | 	mail | F | mail |
| 姓名字段  | 	cn | T |cn |
| 手机号  | 	mobile | F | mobile|

### 从钉钉同步信息到ldap

> 参考 https://github.com/anjia0532/virtual-ldap

