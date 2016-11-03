
$(document).ready(function(){
	var _us_count = 1;
	
	$(document).on('click', '#add_US_button', function(){		
		$("#US_table").append(add_US(++_us_count));
	});
});

function add_US(count){
	var res =	'<tr>\
					<td class="US_td">US#%count</td>\
						<td>\
							<textarea form="add_project_form" name="US[%count][description]"\
							maxlength="1024" class="US_description"></textarea>\
						</td>\
						<td class="US_td"><input type="number" min="1" name="US[%count][cost]" value="1"/></td>\
						<td class="US_td"><input type="number" min="1" name="US[%count][priority]" value="1"/></td>\
				<tr>';
				
	return res.replace(/%count/g,count);
}

function add_US2(count){
	return 	'<div>'+
				'<input type="text" name="US['+count+'][description]"/>'+
				'<input type="text" name="US['+count+'][cost]"/>'+
				'<input type="text" name="US['+count+'][priority]"/>';
}

function perf(func, count){
	var t0 = $.now();
	func(count);
	return $.now() - t0;
}