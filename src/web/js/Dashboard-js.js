function changeColor(target, img){
	$("#nav-equipe").css("background-color", "#37474F" );
	$("#equipe").attr('src', 'Icons/equipe.png');
	$("#nav-graphe").css("background-color", "#37474F" );
	$("#graphe").attr('src', 'Icons/graphe.png');
	$("#nav-doc").css("background-color", "#37474F" );
	$("#docs").attr('src', 'Icons/docs.png');
	$("#nav-param").css("background-color", "#37474F" );
	$("#param").attr('src', 'Icons/param.png');
	$("#nav-home").css("background-color", "#37474F" );
	$("#home").attr('src', 'Icons/home.png');
	$("#"+target).css("background-color", "#1abc9c" );
	$("#"+img).attr('src', 'Icons/'+img+'W.png');
};

