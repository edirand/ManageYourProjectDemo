
$(document).ready(function(){
				  $.get( "Handlers/Parametre_charge_Handler.php", function(text) {
								  })
				  .done(function(text) {
						var res = text.split(",");
						if(res[0] == 1)
						$("input[name='private']").prop('checked', true);
						if(res[1] == 1)
						$("input[name='finished']").prop('checked', true);
						});
});

