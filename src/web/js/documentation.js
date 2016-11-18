$(document).ready(function(){
	
	$(".to_toggle").hide();
	
	//$(".doc_div h2").click(function(){
	//$(".toggle[data-toggle='true']").click(function(){		
	$(".doc_div").on('click',".toggle[data-toggle='true']",function(){				
		$(this).parent().find(".to_toggle").toggle();
	});
	
	$(".doc_submit_button").hide();
	
	//$(".doc_edit_button").click(function(){
	$(".doc_edit_button").on('click',function(){		
		$(this).parent().parent().find($(".doc_content")).attr("contenteditable",true);
		$(this).parent().parent().find($(".doc_content")).css("border","1px solid black");
		$(this).hide();
		$(this).parent().find(".doc_submit_button").show();
		$(this).parent().parent().parent().find($(".toggle")).attr("data-toggle","false");
	});
	
	$(".doc_submit_button").click(function(){		
		$(this).hide();
		$(this).parent().find(".doc_edit_button").show();
		
		$.ajax({
			method: "POST",
			url: "Handlers/projects/edit_doc_handler.php",
			data: {	adresse_dev: $("#adresse_dev_content").text(),
					adresse_demo: $("#adresse_demo_content").text(),
					politique_tests: $("#politique_tests_content").text(),
					langages_outils: $("#langages_outils_content").text(),
					regles_depot: $("#regles_depot_content").text(),
					regles_qualite: $("#regles_qualite_content").text()}
		});		
		
		$(".doc_content").attr("contenteditable",false);
		$(".doc_content").css("border","none");
		$(".doc_submit_button").hide();
		$(".doc_edit_button").show();
		$(".toggle").attr("data-toggle","true");
	});
	
	
	
	

});
/*
function upload_doc(){	
	
	
}

*/