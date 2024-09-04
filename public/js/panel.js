/**
 * Подтверждение заявки(записи)
 */

$(document).on("click", ".btn-confim", function () {
  const id = $(this).attr("confirm-id");
  $.ajax({
	url: '/actions/order_confirm.php',
	method: 'post',
	dataType: 'html',
	data: {id: id},
	success: function(data){
		location.reload();
	}
});
});
