<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>   
	<script src="js/go.js"></script>	
	<script src = "js/jquery-3.1.1.min.js"></script>    
	<link href="CSS/diagram_pert.css" rel="stylesheet" media="screen">
    <title> Diagramme de perte </title>

</head>


<?php
	include "Handlers/tasks/tasks_requests.php";

	$gres = update_tasks_sl($_SESSION['projet_id']);
	//$gres = update_tasks_sl(1);
	
	$ini_param = '[';
	foreach($gres as $ksprint => $g){
		$ini_param = $ini_param.$ksprint.',';
	}
	$ini_param = rtrim($ini_param,",");
	$ini_param .= ']';
	echo '<body onload="init('.$ini_param.')">';
	foreach($gres as $ksprint => $g){
	//$g = $gres[2];
		
		echo "<span id='sprint".$ksprint."_tasks_number' data-number='".$g->_nb_keys."'></span>";

		$soonest_start = $g->get_soonest_start(); 
		$latest_end = $g->get_latest_end();
		for($i = 1; $i <= $g->_nb_keys; ++$i){
			$soonest = $soonest_start[$i];
			$latest = $latest_end[$i];
			$cost = $g->_cost[$i];
			echo "<span id='sprint".$ksprint."_task".$i."' data-cost='".$cost."' data-soonest='".$soonest."' data-latest='".$latest."'></span>";
		}

		foreach($g->_rev_dep as $key => $val){
			foreach($val as $d){
				echo "<span class='sprint".$ksprint."_link_data' data-from='".$key."' data-to='".$d."'></span>";
			}
		}
		
		echo '
			<div>
			  <h3>Sprint'.$ksprint.'</h3>
			  <div id="myDiagramDiv'.$ksprint.'" style="border: solid 1px gray; width:100%; height:400px"></div>			  
			</div>';
	}
?>


<script id="code">
  function init(sprints) {
	sprints.forEach(function(sprint){   
		
		var $ = go.GraphObject.make;  // for more concise visual tree definitions

		// colors used, named for easier identification
		var blue = "#0288D1";
		var pink = "#B71C1C";
		var pinkfill = "#F8BBD0";
		var bluefill = "#B3E5FC";

		myDiagram =
		  $(go.Diagram, "myDiagramDiv"+sprint,
			{
			  initialAutoScale: go.Diagram.Uniform,
			  initialContentAlignment: go.Spot.Center,
			  layout: $(go.LayeredDigraphLayout)
			});

		// The node template shows the activity name in the middle as well as
		// various statistics about the activity, all surrounded by a border.
		// The border's color is determined by the node data's ".critical" property.
		// Some information is not available as properties on the node data,
		// but must be computed -- we use converter functions for that.
		myDiagram.nodeTemplate =
		  $(go.Node, "Auto",
			$(go.Shape, "Rectangle",  // the border
			  { fill: "white", strokeWidth: 2 },
			  new go.Binding("fill", "critical", function (b) { return (b ? pinkfill : bluefill ); }),
			  new go.Binding("stroke", "critical", function (b) { return (b ? pink : blue); })),
			$(go.Panel, "Table",
			  { padding: 0.5 },
			  $(go.RowColumnDefinition, { column: 1, separatorStroke: "black" }),
			  $(go.RowColumnDefinition, { column: 2, separatorStroke: "black" }),
			  $(go.RowColumnDefinition, { row: 0, separatorStroke: "black", background: "white",coversSeparators: true }),
			  $(go.RowColumnDefinition, { row: 1, separatorStroke: "black", background: "white", coversSeparators: true }),
			  $(go.RowColumnDefinition, { row: 2, separatorStroke: "black" }),         
			  $(go.TextBlock,  // cost
				new go.Binding("text", "cost"),                          
				{ row: 0, column: 0, columnSpan: 3,margin: 5, textAlign: "center" }),
			  $(go.TextBlock, 		  
				new go.Binding("text", "text"),
				{ row: 1, column: 0, columnSpan: 3, margin: 5,
				  textAlign: "center", font: "bold 14px sans-serif" }),

			  $(go.TextBlock,  //soonest start
				new go.Binding("text", "soonestStart"),
				{ row: 2, column: 0, margin: 5, textAlign: "center" }),
			  
			  $(go.TextBlock, // lateest end
				new go.Binding("text", "latestEnd"),
				{ row: 2, column: 2, margin: 5, textAlign: "center" })
			)  // end Table Panel
		  );  // end Node

		// The link data object does not have direct access to both nodes
		// (although it does have references to their keys: .from and .to).
		// This conversion function gets the GraphObject that was data-bound as the second argument.
		// From that we can get the containing Link, and then the Link.fromNode or .toNode,
		// and then its node data, which has the ".critical" property we need.
		//
		// But note that if we were to dynamically change the ".critical" property on a node data,
		// calling myDiagram.model.updateTargetBindings(nodedata) would only update the color
		// of the nodes.  It would be insufficient to change the appearance of any Links.
		function linkColorConverter(linkdata, elt) {
		  var link = elt.part;
		  if (!link) return blue;
		  var f = link.fromNode;
		  if (!f || !f.data || !f.data.critical) return blue;
		  var t = link.toNode;
		  if (!t || !t.data || !t.data.critical) return blue;
		  return pink;  // when both Link.fromNode.data.critical and Link.toNode.data.critical
		}

		// The color of a link (including its arrowhead) is red only when both
		// connected nodes have data that is ".critical"; otherwise it is blue.
		// This is computed by the binding converter function.
		myDiagram.linkTemplate =
		  $(go.Link,
			{ toShortLength: 6, toEndSegmentLength: 20 },
			$(go.Shape,
			  { strokeWidth: 4 },
			  new go.Binding("stroke", "", linkColorConverter)),
			$(go.Shape,  // arrowhead
			  { toArrow: "Triangle", stroke: null, scale: 1.5 },
			  new go.Binding("fill", "", linkColorConverter))
		  );

		// here's the data defining the graph
		
		var nodeDataArray = [];
		var linkDataArray = [];
		//nodeDataArray.push({ key: 0, text: "Start", cost: 0, soonestStart: 0, latestEnd: 0, critical: false });
		var tasks_number = document.getElementById("sprint"+sprint+"_tasks_number").getAttribute("data-number");
		var i = 1;
		for(i; i <= tasks_number; ++i){
			/* nodes */
			var task = document.getElementById("sprint"+sprint+"_task"+i);
			var cost =  task.getAttribute("data-cost");		
			var soonest =  task.getAttribute("data-soonest");		
			var latest =  task.getAttribute("data-latest");		
			nodeDataArray.push({ key: i, text: "Task "+i, cost: cost, soonestStart: soonest, latestEnd: latest, critical: false });
			
			
		}
		
		/*links*/		
		
		var links = document.getElementsByClassName("sprint"+sprint+"_link_data");
		for(var t = 0; t < links.length;++t){
			var dfrom = links[t].getAttribute("data-from"); 
			var dto = links[t].getAttribute("data-to"); 
			linkDataArray.push({ from: dfrom, to: dto});
		}
		
		myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);

		// create an unbound Part that acts as a "legend" for the diagram
		myDiagram.add(
		  $(go.Node, "Auto",
			$(go.Shape, "Rectangle",  // the border
			  { fill: bluefill } ),
			$(go.Panel, "Table",
			  $(go.RowColumnDefinition, { column: 1, separatorStroke: "black" }),
			  $(go.RowColumnDefinition, { column: 2, separatorStroke: "black" }),
			  $(go.RowColumnDefinition, { row: 0, separatorStroke: "black", background: "white", coversSeparators: true }),
			  $(go.RowColumnDefinition, { row: 1, separatorStroke: "black", background: "white", coversSeparators: true }),
			  $(go.RowColumnDefinition, { row: 2, separatorStroke: "black" }),    
			  $(go.TextBlock, "Cost",
			   { row: 0, column: 0, columnSpan: 3,margin: 5, textAlign: "center" }),
			  $(go.TextBlock, "Task",
				{ row: 1, column: 0, columnSpan: 3, margin: 5,
				  textAlign: "center", font: "bold 14px sans-serif" }),
			  $(go.TextBlock, "Soonest Start",
				{ row: 2, column: 0, margin: 5, textAlign: "center" }),         
			  $(go.TextBlock, "Latest End",
				{ row: 2, column: 2, margin: 5, textAlign: "center" })
			)  // end Table Panel
		  ));
	});
  }
  

 
//alert("mak");
</script>
<!--
	<div >
	<div id="sample">
	  <h3>Diagramme de PERT</h3>
	  <div id="myDiagramDiv" style="border: solid 1px gray; width:100%; height:400px"></div>
	  
	</div>
	</div>
	
	-->
</body>