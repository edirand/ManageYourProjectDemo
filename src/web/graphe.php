<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<script src = "js/jquery-3.1.1.min.js"></script>
	<script src="js/pert.js"></script>	
	<link href="CSS/pert.css" rel="stylesheet" media="screen">
	<link href="CSS/Graphe.css" rel="stylesheet" media="screen">

    <!-- jQuery -->

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title> Graphes </title>

</head>

<body>

<form action="Handlers/Commit_handler" method="POST">
    <div class = "contenu">
        <h1> Graphes</h1>
        <?php

        $i = 0;

        try{
            $bdd = new PDO('mysql:host=localhost;dbname=MYP;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        $reponse = $bdd->query('Select numero, commit_id from UserStory where projet_id =' .$_SESSION['projet_id'] .  ';');


        echo '<div id="content">';
        echo '<div id="container-burndown"></div>';
		echo '<div class="matrice-tra">';
		echo '<table id = "matriceH">';
		echo '<tr id = "first"><td id = "usH">US</td><td id = "comH">Commit</td></tr>';
		echo '</table>';
		echo '<div class = "matrice-corps">';
        echo '<table id = "matrice">';
        while ($donnees = $reponse->fetch())
        {   $i++;
            echo '<tr>';
            echo '<td id = "numero">'."US#" . $donnees['numero'] . '</td>';
            echo '<td class ="td-btn" id="commit-td">
                <label style="text-align: center" id="label-ic'.$i.'">'. $donnees['commit_id'] .'</label>
                <input  type="text" name="text-ic" id="text-ic'.$i.'"  value="'. $donnees['commit_id'] .'" style="display:none"></button>
                <input type="button" class="edit" name="edit-ic" id="edit-ic'.$i.'" Value="Edit" onClick="edit_click('.$i.')" style="width:18%"></button>
                <input type="button" class="but"  name="save-ic" type="button" id="save-ic'.$i.'" Value="Save" onClick="save_click('.$i.')" style="display:none"></button>

        </a>
        </td>';
            echo '</tr>';
        }
        echo '</table>';
		echo '</div>';
        echo '</div>';
        echo '</div>';

        $reponse = $bdd->query('Select Count(*) as nb from Sprints where projet_id = '. $_SESSION['projet_id']);
        $donnees = $reponse->fetch();
        $nbSprints = $donnees['nb'];

        $reponse = $bdd->query('Select Sum(effort) as Total from UserStory where projet_id = '. $_SESSION['projet_id']);
        $donnees = $reponse->fetch();
        $totalEffort = $donnees['Total'];
        $restePrevu = $totalEffort;
        $resteReel = $totalEffort;
			
			$actualArray[] = (int)$resteReel;
        $idealArray[] = (int)$restePrevu;
        $idealXArray[] = 'Start';

        for($i = 1; $i<=$nbSprints; $i++){
            //On rÈcupËre l'id
            $reponse = $bdd->query('Select id from Sprints where projet_id = '. $_SESSION['projet_id'] . ' and numero = ' . $i);
            $donnees = $reponse->fetch();
            $id = $donnees['id'];
            //On rÈcupËre l'effort prÈvu et l'effort rÈel
            $reponse2 = $bdd->query('Select * from ((Select Sum(effort) as prevu from UserStory where sprint_id = ' . $id . ')as effort_prevu, (Select Sum(effort)as reel from UserStory where sprint_id = ' . $id . ' and commit_id is not null)as effort_reel);');
            $donnees2 = $reponse2->fetch();
            //Calcul de l'effort prÈvu
            $effort = $donnees2['prevu'];
            $restePrevu = (int)$restePrevu-(int)$effort;

            $idealArray[] = (int)$restePrevu;
            $idealXArray[] = 'Sprint'.strval($i);
			
			//Calcul de l'effort rÈel
            $effortReel = $donnees2['reel'];
            if((int)$effortReel != 0){
                $resteReel = (int)$resteReel-(int)$effortReel;
                $actualArray[] = (int)$resteReel;
            }

        }


        ?>

</form>
</div>
	
	<section id="pert_section">
		<h2>PERT</h2>
		<?php
			include("Handlers/tasks/tasks_requests.php");
			$sprints_array = get_sprints($_SESSION['projet_id']);	
			$sprints = $sprints_array['sprints'];
			$sprints_numbers = $sprints_array['numbers'];	
			
			foreach($sprints_numbers as $sn){	
				echo '<button type="button" class="button_sprint_pert" data-sprint="'.$sn.'">Sprint '.$sn.'</button>';
			}
			
			foreach($sprints_numbers as $sn){		
				echo '<div class="display_pert" data-sprint="'.$sn.'">';
				if(array_key_exists($sn,$sprints)){
					display_pert($sn,$sprints);
				} else {
					echo "<p>Aucunes t√¢ches trouv√©es pour le sprint ".$sn."</p>";
				}			
				echo '</div>';
			}			
			function display_pert($sn,$sprints){
				echo "<table class='pert_table' id='table_pert_sprint".$sn."'>";				
					/*HEADER*/
					echo "<tr>";					
					echo "<th></th>";										
					foreach($sprints[$sn] as $t){
						echo "<th>";
							echo $t['numero'];
						echo "</th>";
					}								
					echo "</tr>";	
					
					/*CORE*/										
					foreach($sprints[$sn] as $t_row){
						$dependencies =  explode(",",$t_row['dependances']);						
						echo "<tr>";
							/*ROW*/
							echo "<td class='row_head'>";
							echo $t_row['numero'];
							echo "</td>";
						/*COLS*/	
						foreach($sprints[$sn] as $t_col){							
							if(in_array($t_col['numero'],$dependencies)){
								//echo $t_col['numero'];
								echo "<td class='dependency'></td>";
							}else {
								echo "<td></td>";
							}
						}						
						echo "</tr>";
					}
				echo "</table>";
			}		
				
		?>
	</section>
</body>
</html>

<script>

    function edit_click(no) {

        document.getElementById("edit-ic" + no).style.display = "none";
        document.getElementById("label-ic" + no).style.display = "none";
        document.getElementById("save-ic" + no).style.display = "block";
        document.getElementById("text-ic" + no).style.display = "block";
        document.getElementById("save-ic" + no).style.float = "right";
        document.getElementById("text-ic" + no).style.float = "left";
        document.getElementById("text-ic" + no).style.textAlign = "center";
        document.getElementById("save-ic" + no).style.width ="18%";
        document.getElementById("text-ic" + no).style.width ="82%";
    }

    function save_click(no)
    {
        document.getElementById("save-ic" + no).style.display = "none";
        document.getElementById("edit-ic" + no).style.display = "block";
        document.getElementById("edit-ic" + no).style.float = "right";
        document.getElementById("label-ic" + no).style.display = "block";
        document.getElementById("text-ic" + no).style.display = "none";
        document.getElementById("label-ic" + no).style.float = "left";
        document.getElementById("label-ic" + no).style.width ="82%";
        document.getElementById("label-ic" + no).style.textAlign = "center";


        var valeur = document.getElementById("text-ic" + no).value;
        var id_num = no;

		$.post("Handlers/commit_handler.php", {valeur : valeur, id_num : id_num}, function(){
			   refreshPage();
			   });


    }

    function refreshPage() {
        window.location.reload();
    }


</script>

<script>
    jQuery(document).ready(function() {
        var doc = $(document);

        $('#container-burndown').highcharts({

            title: {
                text: 'Burndown Chart of Project',
                x: -10 //center
            },
            scrollbar: {
                barBackgroundColor: 'gray',
                barBorderRadius: 7,
                barBorderWidth: 0,
                buttonBackgroundColor: 'gray',
                buttonBorderWidth: 0,
                buttonBorderRadius: 7,
                trackBackgroundColor: 'none',
                trackBorderWidth: 1,
                trackBorderRadius: 8,
                trackBorderColor: '#CCC'
            },
            colors: ['blue', 'red'],
            plotOptions: {
                line: {
                    lineWidth: 3
                },
                tooltip: {
                    hideDelay: 200
                }
            },
            subtitle: {
                text: '',
                x: -10
            },
            xAxis: {
                categories: <?php echo json_encode($idealXArray);?>
            },
            yAxis: {
                title: {
                    text: 'Remaining work (effort)'

                },
                type: 'linear',
                max: <?php echo $totalEffort; ?>,
                min:0,
                tickInterval :1

            },

            tooltip: {
                valueSuffix: ' effort',
                crosshairs: true,
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
            series: [{
                name: 'Ideal Burn',
                color: 'rgba(255,0,0,0.25)',
                lineWidth: 2,

                data: <?php echo json_encode($idealArray);?>
            }, {
                name: 'Actual Burn',
                color: 'rgba(0,120,200,0.75)',
                marker: {
                    radius: 6
                },
                data: <?php echo json_encode($actualArray);?>
            }]
        });
    });
</script>
