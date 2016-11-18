$(document).ready(function(){	
	$(".display_pert").hide();
	
	$(".button_sprint_pert").click(function(){
		var sprint = $(this).data("sprint");
		$(".display_pert").hide();
		$(".display_pert[data-sprint="+sprint+"]").show();
	});

});
