let expiryTable;

$(document).ready(function(){
	let test;
    expiryTable = $('#expiryProductTable').DataTable({
		'ajax': 'php_action/fetchExpiringProduct.php',
		'order': [],
	});
});