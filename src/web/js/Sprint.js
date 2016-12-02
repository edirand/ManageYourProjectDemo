var element;
function setDragg(){
	$('.post-it-container-todo').draggable({
						 containement : "colonnes",
						 revert : 'invalid',
						 start : function(){
							element = $(this);
						 }
	});
	$('.post-it-container-ongo').draggable({
										   containement : "colonnes",
										   revert : 'invalid',
										   start : function(){
										   element = $(this);
										   }
										 });
};

function setDrop(id){
	$('#colonnes').height($('#colonnes').height()+300);
	$('#OnGoing').droppable({
							accept : '.post-it-container-todo',
							drop : function(){
							$(element).attr('class', 'post-it-container-ongo');
							$.post("Handlers/SetEtatHandler.php", {id : $(element).attr('id'), state : 1});
							$.post('Handlers/Projet_sprint_handler.php',{sprint_id: id}, function(tableau){
								   $('div#content').html((tableau));
								   setDragg();
								   setDrop(id);
								   })
							}});
	$('#ToDo').droppable({
							accept : 'non',
							drop : function(){
							}});
	$('#Done').droppable({
							accept : '.post-it-container-ongo',
							drop : function(){
							$('.pop-background').fadeIn();
							$('.pop').fadeIn();
							$("#val").click(function(){
								$.post("Handlers/SetEtatHandler.php", {id : $(element).attr('id'), state : 2});
								$.post('Handlers/Projet_sprint_handler.php',{sprint_id: id}, function(tableau){
									   $('div#content').html((tableau));
									   setDragg();
									   setDrop(id);
									});
									$('.pop-background').fadeOut();
									$('.pop').fadeOut();
							});
							$("#annul").click(function(){
								$.post('Handlers/Projet_sprint_handler.php',{sprint_id: id}, function(tableau){
									   $('div#content').html((tableau));
									   setDragg();
									   setDrop(id);
									   $('.pop-background').fadeOut();
									   $('.pop').fadeOut();
								  });
							});
						}});
	

};
