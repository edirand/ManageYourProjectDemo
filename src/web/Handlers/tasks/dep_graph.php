<?php

//graph as an adjacency list
class GraphDep
{
	public $_sprint_time;
	public $_nb_keys ;
	public $_dep;
	public $_rev_dep;
	public $_cost;
	
	public $_soonest; // the soonest it can be done
	public $_latest;  // the latest it can be done
 
	function __construct($nbkeys, $dep, $cost,$sprint_time){
		$this->_sprint_time = $sprint_time;
		$this->_nb_keys = $nbkeys;
		$this->_cost = $cost; 
		
		$this->_dep = $dep; //[nbkey][d1,d2,...]		
		$this->_rev_dep = $this->build_reversed_dep($nbkeys,$dep);
		/*
		foreach($this->_rev_ dep as $i =>$d){
			echo "<br>depkey = ".$i."<br>";
			foreach($d as $v){
				echo $v.",";
			}
		}
		*/
		$this->_soonest = array();//new SplFixedArray($nbkeys);
		$this->_latest = array();//new SplFixedArray($nbkeys);
		
		//$this->ini_latest();
		/*
		for($i = 0; $i < $this->_nb_keys; ++$i ){
			$this->soonest($i);			
			$this->latest($i);
		}
		*/
		
		
		foreach($this->_dep as $k => $v){
			$this->soonest($k);			
			$this->latest($k);
		}
		
	}
	/*
	* Minimal amount of days (after the start of the sprint)
	* required before starting the tasks
	*/
	public function get_soonest_start(){
		$res;
		//for($i = 0; $i < $this->_nb_keys; ++$i){
		foreach($this->_dep as $i => $v){
			$res[$i] = $this->_soonest[$i] - $this->_cost[$i];
			if($res[$i] <0) $res[$i] = 0;
		}	
		//we may have to handle in a proper way when a sprint is too short for all of his tasks
		
		return $res;
		
	}
	
	/*
	* Deadline to start the tasks
	*/
	public function get_latest_start(){
		$res;
		//for($i = 0; $i < $this->_nb_keys; ++$i){
		foreach($this->_dep as $i => $v){
			$res[$i] = $this->_latest[$i] - $this->_cost[$i];
			if($res[$i] < 0) $res[$i] = 0;
		}	
		//we may have to handle in a proper way when a sprint is too short for all of his tasks
		
		return $res;
		
	}	
	
	/*
	* Minimal amout of days (after the start of the sprint)
	* needed to finish the tasks
	*/
	public function get_soonest_end(){
		$res;
		//for($i = 0; $i < $this->_nb_keys; ++$i){
		foreach($this->_dep as $i => $v){
			$res[$i] = $this->_soonest[$i];
			if($res[$i] < 0) $res[$i] = 0;
		}	
		//we may have to handle in a proper way when a sprint is too short for all of his tasks
		
		return $res;
		
	}
	
	/*
	* Deadline to finish the tasks
	*/
	public function get_latest_end(){
		$res;
		//for($i = 0; $i < $this->_nb_keys; ++$i){
		foreach($this->_dep as $i => $v){
			$res[$i] = $this->_latest[$i];
			if($res[$i] < 0) $res[$i] = 0;
		}	
		//we may have to handle in a proper way when a sprint is too short for all of his tasks
		
		return $res;
		
	}
	
	
	/*
	* Build the reversed list of dependencies
	*/
	private function build_reversed_dep($nbkeys, $dep){
		$rev = array();
		//for($i = 0; $i < $nbkeys; ++$i){			
		//echo "<br>REV DEP<br>"
		foreach($this->_dep as $i => $v){
			//foreach($dep[$i] as $d){
			foreach($v as $d){
				if(empty($rev[$d]))
					$rev[$d] = array();
				array_push($rev[$d],$i);
			}
		}		
		return $rev;
	}
	
	private function soonest($key){
		//this function involve SIDE EFFECTS on $g		
		//echo $key." key <br>";		
		if( empty($this->_soonest[$key])){	
				
			if(empty($this->_dep[$key])){
				//echo "no dep<br>";
				//echo $key."<br>";
				$this->_soonest[$key] = $this->_cost[$key];			
			}		
			else{
				$first_iteration = true;
				$max;
				
				foreach($this->_dep[$key] as $d){					
					$this->soonest($d);
					//echo $this->_soonest[$d]." soonest found <br>";
					if($first_iteration){
						$first_iteration = false;
						$max = $this->_soonest[$d];
					}	
					if(!$first_iteration && $this->_soonest[$d] > $max){
						$max = $this->_soonest[$d];
					}					
				}	
				$this->_soonest[$key] = $max + $this->_cost[$key];
			}
		}	
		else{
			//echo " already found <br>";
		}
		
	}	
	
	
	private function latest($key){
		/*
		foreach($this->_rev_dep as $i =>$d){
			echo "<br>depkey = ".$i."<br>";
			foreach($d as $v){
				echo $v.",";
			}
		}
		*/
		if( empty($this->_latest[$key])){
			if(empty($this->_rev_dep[$key])){				
				$this->_latest[$key] = $this->_sprint_time ;//- $this->_cost[$key];
			}		
			else{
				$first_iteration = true;
				$min;
				$key_min;
				//echo "<br>key = ".$key."<br>";
				foreach($this->_rev_dep[$key] as $rd){					
					$this->latest($rd);					
					if($first_iteration){
						$first_iteration = false;
						$min = $this->_latest[$rd];
						$key_min = $rd;
					}	
					if(!$first_iteration && $this->_latest[$rd] < $min){
						$min = $this->_latest[$rd];
						$key_min = $rd;
					}					
				}	
				
				$this->_latest[$key] = $min - $this->_cost[$key_min];
			}
		}
	}
	
	/*
	* Initialisation of the _latest list depending on the reversed list of dependencies
	* Deprecated, latest mad it usless
	*/
	private function ini_latest(){
		for($i = 0; $i < $this->_nb_keys; ++$i){
			if(empty($this->_rev_dep[$i])){
				$this->_latest[$i] = $this->_sprint_time;
			}
		}
	}	
}







//deprecated, the graph can make it alone now
function soonest($key, $g){
	//this function involve SIDE EFFECTS on $g
	
	//echo $key." key <br>";
	if( !empty($g->_soonest[$key])){	
		//echo "already found<br>";	
		return $g;
	}
	else if(empty($g->_dep[$key])){
		//echo "no dep<br>";
		$g->_soonest[$key] = $g->_cost[$key];
		return $g;
	}
	$first_iteration = true;
	$max;
	
	foreach($g->_dep[$key] as $d){					
		$tmp = soonest($d,$g);
		//echo $tmp->_soonest[$d]." soonest found <br>";
		if($first_iteration){
			$first_iteration = false;
			$max = $tmp->_soonest[$d];
		}	
		if(!$first_iteration && $tmp->_soonest[$d] > $max){
			$max = $tmp->_soonest[$d];
		}					
	}	
	$g->_soonest[$key] = $max + $g->_cost[$key];		
	return $g;	
}

/*

$dep = array(
	array(),
	array(0,3),
	array(3,4),
	array(4),
	array(0)
);

$dep = array();
$dep[] = array();
$dep[] = array(0,3);
$dep[] = array(3,4);
$dep[] = array(4,);
$dep[] = array(0);

//$cost = array(1,3,2,4,5);
$cost = array();
$cost[] = 1;
$cost[] = 3;
$cost[] = 2;
$cost[] = 4;
$cost[] = 5;

$g = new GraphDep(5,$dep, $cost,15);

foreach($g->_dep as $d){
	foreach($d as $u){		
		echo $u.",";
	}
	echo "<br>";
}

foreach($g->_rev_dep as $rev){
	
	foreach($rev as $k){
		//echo $k.",";
	}
	//echo "<br>";
}

foreach($g->_soonest as $s){
	echo $s.",";
}
echo "<BR>";
foreach($g->_latest as $s){
	echo $s.",";
}
echo "<br>end<BR>";
*/
?>

