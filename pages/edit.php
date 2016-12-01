<?php

// me peame uhendama lehed, et session tootaks

	require("../functions.php");
	require("../classes/project_class.php");
	$Project = new Project($mysqli);
	
	// kui ei ole kasutajat id'd
	if(!isset($_SESSION["userID"]))
	{
		//suunan sisselogimise lehele
		header("Location: login.php");
		
		// teper' on ne chitaet kod dalshe
		exit();
	}
	
	//kui on ?logout aadressireal siis login valja
	if(isset($_GET["logout"]))
	{
		session_destroy();
		header("Location: login.php");
	}

	if(isset($_POST["project"]) && isset($_POST["customer"]) && isset($_POST["deadline"]) && isset($_POST["contact"])
		&& !empty($_POST["project"]) && !empty($_POST["customer"]) && !empty($_POST["deadline"]) && !empty($_POST["contact"]))
	{
		//saveCar($Helper->cleanInput($_POST["carPlate"]),$Helper->cleanInput($_POST["carColor"]));
		$Project->updateProject($Helper->cleanInput($_POST["project"]),$Helper->cleanInput($_POST["customer"]),$Helper->cleanInput($_POST["deadline"]),$Helper->cleanInput($_POST["contact"]));
	}
	
	
	
	if(isset($_GET["sort"]))
	{
		$sort = $_GET["sort"];
		
	}
	else
	{
		// kui ei ole maaratud siis vaikis id ja ASC
		$sort = "id";
		
	}
	
	//$carData = getAllCars();
	
	//$projectDetails = $Project->getAllProjectDetails();
	if(isset($_GET["search"]))
	{
		$search=$Helper->cleanInput($_GET["search"]);
		$projectDetails = $Project->getAllProjectDetails($search,$sort);
		
	}
	else
	{
		$search = "";
		$projectDetails = $Project->getAllProjectDetails($search,$sort);
	}
	
?>

<!-- lisasin 'Nunito' fonti -->
 <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
 
 <!-- JS  -->
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>

	$(".deleteProject").click(function(e){
        var c = confirm("Are you sure ?");
		
		if(!c){
			e.preventDefault();
			return;
		}
		else
		{
			
			<?php
			if(isset($_GET["remove"]))
			{
					$Project->deleteProject();
					header("Location: data.php");
			}
			
			?>
			
		}
    });

	$(".editProject").click(function(ev){
        var con = confirm("Are you sure ?");
		
		if(!con){
			ev.preventDefault();
			return;
		}
		else
		{
			
			<?php			    
					foreach($projectDetails as $project)
					{
						if($_GET["edit"] == $project->id)
						{
							$projName = $project->project;
							$projCustomer = $project->customer;
							$projDeadline = $project->deadline;
							$projContact = $project->contact;
							
							break;
						}															
			}
			
			?>			
		}
	
    });
});

</script>
<?php require("../header.php");?>
 <form action="" class="search-form">
               <div class="form-group has-feedback">
            		<label for="search" class="sr-only">Search</label>
            		<input type="text" class="form-control" name="search" id="search" placeholder="search">
              		<span class="glyphicon glyphicon-search form-control-feedback"></span>
                    <br>
					<?php
					if($search != "")
					{
					echo "Searching: ".$search;
					}
					?>
            	</div>
   </form>

<p>Welcome! <?=$_SESSION["userEmail"];?>!</p>

<div>
<a href="?logout=1">Logi välja</a><br>
<a href="data.php">Back</a>
</div>
<!-- Split button -->
<div class="btn-group">
  
  <button type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Sort <span class="caret"></span></button>
   
    
  </button>
  <ul class="dropdown-menu">
    <li><a href="?search=<?php echo $search; ?>&sort=project">Project A-Z</a></li>
    <li><a href="?search=<?php echo $search; ?>&sort=project1">Project Z-A</a></li>
    <li role="separator" class="divider"></li>				
    <li><a href="?search=<?php echo $search; ?>&sort=customer">Customer A-Z</a></li>
    <li><a href="?search=<?php echo $search; ?>&sort=customer1">Customer Z-A</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="?search=<?php echo $search; ?>&sort=deadline">Deadline closest</a></li>
    <li><a href="?search=<?php echo $search; ?>&sort=deadline1">Deadline farthest</a></li>
    
  </ul>
</div>

<br>


<?php
/*
foreach($projectDetails as $project)
					{
						if($_GET['edit'] == $project->id)
						{
							$projName = $project->project;
							$projCustomer = $project->customer;
							$projDeadline = $project->deadline;
							$projContact = $project->contact;
							
							break;
						}				
					}*/
					?>	

<form method="POST" class="forms">
	<h1>Details</h1>
    
	<label for="project">Project: </label>
	<input name="project" type="text" value="<?php if(isset($projName)){ echo $projName;}?>"><br><br>
	
	<label for="customer">Customer: </label>
	<input name="customer" type="text" value="<?php if(isset($projCustomer)){ echo $projCustomer;}?>"><br><br>
	
	<label for="deadline">Deadline: </label>
	<input name="deadline" type="date" value="<?php if(isset($projDeadline)){ echo $projDeadline;}?>"><br><br>
	
	<label for="contact">Contact: </label>
	<input name="contact" type="text" value="<?php if(isset($projContact)){ echo $projContact;}?>"><br><br>
	
	<input type="submit" value="Update" class="button orange" style='background-color:orange;'>
</form>




<img id="pic"  src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTJk9-lPrp64eDqSduXYOTZ6i0m7JNVTHwZgLkrEHlErGQ4B4jN_Q"></img>

<?php
$html = "";
$i = 1;

	foreach($projectDetails as $project)
	{

		$html .= "<div class='details'>";
		$html .= "<p>".$i.")"." ".$project->project." <a class='editProject' href='?edit=".$project->id."'><img class='edit' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzslptp8ATc_JsU0R6B6tT9WiX_BAmPiqh11XAKDCYJ_ueaVDZaw' title=''></a>
		<a class='deleteProject' href='?remove=".$project->id."'><img class='remove' src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSpTYr1csaO4Vk9UzvelQor5uTsw1je50AuIRkSYGPehacYbUX1ug' title='Remove'></a>
		 ";
	
		$i+=1;
		$html .= "<p>".$project->customer."</p>";
		$html .= "<p class='color'>".$project->deadline."</p>";
		$html .= "<p>".$project->contact."</p>";
		$html .= "</div>";
		
	}
	echo $html;
?>
<?php require("../footer.php");?>