<?php
include "config.php";


if(!isset($_SESSION["id"]))
{
    header("Location:index.html");
}       

$suffixe = "";
$default = "";
$suffixeActiveAlert="";
$cond="";
if(isset($_GET["search"]))
{
    $default = $_GET["search"];
    $suffixe = "AND (rasion_sociale like '%".$_GET["search"]."%' 
                        OR 
                     nom_alerte like '%".$_GET["search"]."%' 
                        OR 
                     date_alerte = '".$_GET["search"]."' )";
}

$req = $db->prepare("Select * from agenda_comptable where fk_user=? ".$suffixe.$cond); 
$req->execute([$_SESSION["id"]]);
$req0 = $db->prepare("Select * from agenda_comptable where fk_user=? ".$suffixe. "and active =0".$suffixeActiveAlert); 
$req0->execute([$_SESSION["id"]]);

$req1_comming = $db->prepare("Select * from agenda_comptable where fk_user=? and active =1 and DATEDIFF(date_alerte,NOW()) > 6 "); 
$req1_comming->execute([$_SESSION["id"]]);
$req1_now = $db->prepare("Select * from agenda_comptable where fk_user=? and active =1 and DATEDIFF(date_alerte,NOW()) < 6 "); 
$req1_now->execute([$_SESSION["id"]]);
$reqcalc = $db->prepare("SELECT DATEDIFF(date_alerte,NOW()) AS tmp FROM agenda_comptable WHERE DATEDIFF(date_alerte,NOW()) and fk_user=? and active =1"); 
$reqcalc->execute([$_SESSION["id"]]);

$agenda_comptable = $req->fetchAll(PDO::FETCH_ASSOC);
$agenda_comptable0 = $req0->fetchAll(PDO::FETCH_ASSOC);
$agenda_comptable1_now= $req1_now->fetchAll(PDO::FETCH_ASSOC);
$agenda_comptable1_comming= $req1_comming->fetchAll(PDO::FETCH_ASSOC);
$agenda_comptablecalc=$reqcalc->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda Comptable</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container my-5" style="background-color: black; color: #c0c0c0;">
<script>
function confirmation(id){
var ok = confirm('Etes vous sure de vouloir supprimer ?');
if(ok == true)
{
	document.location.href = 'delete.php?id=' + id;
}

}
function switch0(id){
var ok = confirm('Etes vous sure que vous avez Fait votre tache ?');
if(ok == true)
{
	document.location.href = 'switch0.php?id=' + id;
}

}
function search(){
var s = document.querySelector('#search');

if(s.value.trim() != '');
		document.location.href = 'list.php?search=' + s.value.trim();
}
</script>

<h1>Bonjour : <?php echo $_SESSION["nom"]." ".$_SESSION["prenom"];?></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">

			<div class="input-group mb-3">
				<a href="./nouveau.php" class="btn btn-success" role="button">Nouvelle Alert</a>
				<input type="text" class="form-control" value="<?php echo $default; ?>" id="search" placeholder="Rechercher">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" onclick="search()">OK</button>
				</div>
			</div>	
			
		</div>
		<div class="col-md-6">
		<a href="./logout.php" class="btn btn-danger float-right" role="button">Déconnexion</a>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped ">
				<thead style="background-color: black; color: white;">
					<tr>
													<th>Temp resté </th>
						<th>Raison social</th>
						<th>nom alert</th>
						<th>date alert</th>
						<th>Actions</th>
					</tr>
				</thead >
				<tbody>
														<tr style="text-align: center;color: #FFD700 ;background-color: #565f5c;"><td colspan=5 >Innactive Alert</td></tr>
						<?php foreach($agenda_comptable0 as $agenda_comptable0)
						{ ?>
						<tr  style="color: white ;">
						<td> 
							  <?php $date_alerte = new DateTime($agenda_comptable0["date_alerte"]);
						    $current_date = new DateTime();
						    $date_difference = $current_date->diff($date_alerte);
						
						    echo $date_difference->format('%r%a');?> 
						
						 </td>		
						<td> <?php echo $agenda_comptable0["rasion_sociale"]; ?> </td>
						<td ><?php echo $agenda_comptable0["nom_alerte"]; ?></td>
						<td><?php echo $agenda_comptable0["date_alerte"]; ?></td>
						<td>
						<a href="./edit.php?id=<?php echo $agenda_comptable0["id"]; ?>" class='btn btn-primary'>Modifier</a>
						<a href='#' onclick='confirmation("<?php echo $agenda_comptable0["id"]; ?>"); return false;' class='btn btn-danger'>Supprimer</a>
						<a href='#' onclick='switch0("<?php echo $agenda_comptable1_comming["id"]; ?>"); return false;' class='btn btn-danger'>Fait</a>		

						</td>
						</tr>
						<?php } ?>
						
						<tr style="text-align: center;color: #FFD700 ;background-color: #2073b6;"><td colspan=5 >Comming Alert</td></tr>
						<tr>	 
<!--zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz-->
								<?php ; 
								foreach($agenda_comptable1_comming as $agenda_comptable1_comming)
						{ ?>
						<tr style="background-color:#0FA8BA;" >
						<td> 
							  <?php $date_alerte = new DateTime($agenda_comptable1_comming["date_alerte"]);
						    $current_date = new DateTime();
						    $date_difference = $current_date->diff($date_alerte);
    		        echo $date_difference->format('%r%a');
    					?>  	
						 </td>				
						<td> <?php  echo $agenda_comptable1_comming["rasion_sociale"]; ?> </td>
						<td ><?php echo $agenda_comptable1_comming["nom_alerte"]; ?></td>
						<td><?php echo $agenda_comptable1_comming["date_alerte"]; ?></td>
						<td>
						<a href="./edit.php?id=<?php echo $agenda_comptable1_comming["id"]; ?>" class='btn btn-primary'>Modifier</a>
						<a href='#' onclick='confirmation("<?php echo $agenda_comptable1_comming["id"]; ?>"); return false;' class='btn btn-danger'>Supprimer</a>
						<a href='#' onclick='switch0("<?php echo $agenda_comptable1_comming["id"]; ?>"); return false;' class='btn btn-danger'>Fait</a>		
						</td>
						</tr>
						<?php } ?>						
						<tr style="text-align: center;color: #FFD700 ;background-color: #128f61;"><td colspan=5 >Active Alert</td>
						</tr>
						<tr>	
								<?php ;
								foreach($agenda_comptable1_now as $agenda_comptable1_now)
						{ ?>
								<tr style="
				<?php
				$date_alerte = new DateTime($agenda_comptable1_now["date_alerte"]);
				$current_date = new DateTime();
				$date_difference = $current_date->diff($date_alerte);

				if ($date_difference->days < 2) {
						echo 'background-color: #FF6961;'; // Red
				} elseif ($date_difference->days > 3 ||$date_difference->days < 6) {
						echo 'background-color: #FFA500;'; // Orange
				} else {
						echo 'background-color: #77DD77;'; // Green
				}
				?>">
						<td> 
							  <?php $date_alerte = new DateTime($agenda_comptable1_now["date_alerte"]);
						    $current_date = new DateTime();
						    $date_difference = $current_date->diff($date_alerte);
    if ($date_difference->days == 0) {
        echo "today";
    } else {
        echo $date_difference->format('%r%a');
    }
    ?>  
						
						 </td>				
						<td> <?php  echo $agenda_comptable1_now["rasion_sociale"]; ?> </td>
						<td ><?php echo $agenda_comptable1_now["nom_alerte"]; ?></td>
						<td><?php echo $agenda_comptable1_now["date_alerte"]; ?></td>
						<td>
						<a href="./edit.php?id=<?php echo $agenda_comptable1_now["id"]; ?>" class='btn btn-primary'>Modifier</a>
						<a href='#' onclick='confirmation("<?php echo $agenda_comptable1_now["id"]; ?>"); return false;' class='btn btn-danger'>Supprimer</a>
						<a href='#' onclick='switch0("<?php echo $agenda_comptable1_comming["id"]; ?>"); return false;' class='btn btn-danger'>Fait</a>		
						</td>
						</tr>
						<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>