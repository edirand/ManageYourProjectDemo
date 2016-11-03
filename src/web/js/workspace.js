
$(document).ready(function(){

	$(".state_options").hide();
	$(".visibility_options").hide();
	
	var _state = "*";
	var _visibility = "*";	
	var _projects_list = $("#projects_display_list li");	
	
	$(".visibility_option").click(function(){
		$("#visibility_selected").text($(this).text());		
		$(".visibility_options").hide();
		_visibility = $(this).attr("data-visibility");
		display_projects(_projects_list,_visibility,_state);
		
	});
	
	$(".state_option").click(function(){
		$("#state_selected").text($(this).text());		
		$(".state_options").hide();
		_state = $(this).attr("data-state");
		display_projects(_projects_list,_visibility,_state);		
	});
	
	$("#visibility_display").click(function(){
		$(".state_options").hide("slow");
		$(".visibility_options").toggle("fast");
	});
	
	$("#state_display").click(function(){
		$(".visibility_options").hide("slow");
		$(".state_options").toggle("fast");		
	});
	
	set_last();
	
	/* Responsive */
	var _size_mini = 860;
	
	if( $(window).width() < _size_mini){
		$(".responsive-2").css("margin","auto");
		$(".responsive-2").css("display","block");
		$(".responsive-2").css("width","80%");				
		$("#timeline").css("border-left","none");
	}
	
	$( window ).resize(function() {
		if($(window).width() < _size_mini){
			$(".responsive-2").css("margin","auto");
			$(".responsive-2").css("display","block");
			$(".responsive-2").css("width","80%");			
			$("#timeline").css("border-left","none");			
			
		}
		else{			
			$(".responsive-2").css("display","inline-block");
			$(".responsive-2").css("width","25%");			
			$("#timeline").css("border-left","1px solid black");
		}
	});
	
	
	
});

var _all = "*";

function display_projects(projects_list, visibility, state){
	//$("#projects_display_list li").hide();
	$("#projects_display_list li").remove();
	$("#projects_display_list").append(projects_list);
	
	if(visibility == _all && state != _all)	{
		$("#projects_display_list li:not([data-state='"+state+"'])").remove();
		//$("#projects_display_list li[data-state='"+state+"']").show();
	}	
	
	else if(state == _all && visibility != _all){
		$("#projects_display_list li:not([data-visibility='"+visibility+"'])").remove();		
		//$("#projects_display_list li[data-visibility='"+visibility+"']").show();		
	}
		
	
	else if(state != _all && visibility != _all){
		$("#projects_display_list li:not([data-visibility='"+visibility+"'][data-state='"+state+"'])").remove();
		//$("#projects_display_list li[data-visibility='"+visibility+"'][data-state='"+state+"']").show();
	}
		
	else{
		//$("#projects_display_list li").show();
	}	
	set_last();
}

function set_last(){
	$("#projects_display_list li").last().attr("id","last_element" );
	
}


