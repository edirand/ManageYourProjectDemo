function descProjet(){
  $.get('Handlers/Projet_backlog_handler.php', function(tableau){
		$('div#content').html((tableau));
		});
  }

function descSprint(id){
	$.post('Handlers/Projet_sprint_handler.php',{sprint_id: id}, function(tableau){
		  $('div#content').html((tableau));
		  });
}

function getOnglets(id){
	$.get('Handlers/Projet_onglets_handler.php',{projet_id : id}, function(tableau){
		  $('div#onglets').html((tableau));
		  });
}

function changeColor(nb, id){
	$("#projet").css("background-color", "#37474F");
	var num = 1;
	var chaine = "";
	while(num <= nb){
		chaine = "#sprint"+num;
		$(chaine).css("background-color", "#37474F");
		num++;
	}
	if(id == 0){
		$("#projet").css("background-color", "#1abc9c");
	}
	else{
		chaine = "#sprint"+id;
		$(chaine).css("background-color", "#1abc9c");
	}
		
}
