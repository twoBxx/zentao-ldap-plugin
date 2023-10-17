function onClickTest() {
	$.post(createLink('ldap', 'test'),{
		host: $('#ldapHost').val(),
		dn: $('#ldapBindDN').val(),
		pwd: $('#ldapPassword').val(),
	}, function(data) {
		$('#testRlt').html(data);
	});
}

function sync() {
	$.get(createLink('ldap', 'sync'), function(ret){
		alert("同步了"+ret+"位用户信息");
	});
}