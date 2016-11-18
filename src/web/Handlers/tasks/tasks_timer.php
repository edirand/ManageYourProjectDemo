<?php
include("tasks_requests");

function getPertGraph($project_id, $sprint_tasks){
	$graph = array();	
	
	foreach($sprint_tasks as $task){
		if(count($task['dependances'])==0 && !find_rec($task['numero'])){
			
		}
	}
}

class Node{
			public $number;	
			public $cost;
			public $sooner;
			public $later;
			
			public $dependencies;
			public $children;
			
			function __construct($number,$cost,$dependencies){
				$this->number= $number;
				$this->dependencies = $dependencies;
				$this->cost = $cost;
				$this->children = array();
			}

		}

		class Graph{
			public $nodes;
			
			function __construct(){
				$this->nodes = array();
			}
			
			function add_node(Node $n){
				$this->nodes[] = $n;				
			}
		}

/*Recursive search of a value in a multidimentional array, return the path as an array of keys or FALSE*/
function find_rec($val,$array){
	$res_keys = array();
	foreach($array as $key => $el){					
		if(is_array($el)){
			$rec = find_rec($val,$el);
			if($rec){
				$res_keys[] = $key;
				if(is_array($rec)) return array_merge($res_keys,$rec);
				else{
					$res_keys[] = $rec;
					return $res_keys;
				}
			}							
		}else if($el == $val){
			return $key;
		}
	}
	return false;
}

?>