function CloseMessage(){
	$("#message").empty();
}
function set() {
		$("#button").val('Обновляем...');
		$.ajax({
				type:'post',
				url:'ajax.php',
				data:{
					'host':$('#host').val(),
					'port':$('#port').val(),
					'sort':$('#sort').val()
				},
				response:'text',
				success: function(html) {
					$("#message").empty();
					$("#message").append(html);
					$("#button").val('Обновить');
				}
		});
}
function ms(id) {
		$.ajax({
				type:'post',
				url:'ajax.php',
				data:{'master':id},
				response:'text',
				success: function(html) {
					$("#message").empty();
					$("#message").append(html);
				}
		});
}
