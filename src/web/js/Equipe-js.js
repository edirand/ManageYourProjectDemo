function supprimer(target){
	$.post( 'Handlers/Equipe_remove_handler.php', {login: target})
	.done(function( data ) {
		  alert(data);
		  location.reload(true);
		  });
};

function ajouter(target, id){
	$.post( 'Handlers/Equipe_add_handler.php', {login: target})
	.done(function( data ) {
		  search('', id);
		  alert(data);
		  });
};

function search(name, id) {
	$.post('Handlers/Equipe_search_handler.php',{name, id}, function(tableau){
		   $('div#Resultat').html((tableau));
		   });
};
