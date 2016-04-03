$(document).ready(function(){
	$(".expand").click(function(){
		var id = $(this).attr('id') + "Check";
		$("#" + id).toggle();

		return false;
	})
});