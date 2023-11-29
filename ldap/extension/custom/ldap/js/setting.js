$(function () {
	$(document).on('change', '#turnon', function () { changeBtnStatus(); });
});
function onClickTest() {
	$.post(createLink('ldap', 'test'), {
		host: $('#host').val(),
		ssl: $('#ssl').val(),
		port: $('#port').val(),
		dn: $('#bindDN').val(),
		pwd: $('#bindPWD').val(),
	}, function (data) {
		alert(data);
	});
}

function sync() {
	$.get(createLink('ldap', 'sync'), function (ret) {
		alert("同步了" + ret + "位用户信息");
	});
}

function changeBtnStatus() {
	let val = $('#turnon').val();
	if (val == '0') {
		$('#ldapForm .form-actions > button.btn-primary').attr('disabled','disabled')
	} else {
		$('#ldapForm .form-actions > button.btn-primary').removeAttr('disabled');
	}

}