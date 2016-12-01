<?php class Project
{
	private $connection;
	
	
	function __construct($mysqli)
	{
			// osobennost v PHP   $this ukazivaet na objekt klassa
	  $this->connection = $mysqli;
	  
	}

		// TEISED FUNKTISOONID
	function saveProject($project,$customer,$deadline,$contact)
	{
		
		$this->connection->set_charset("utf8");
		// sqli rida
		$stmt = $this->connection->prepare("INSERT INTO project_details (project,customer,deadline,contact) VALUES (?,?,?,?)");
		
		
		echo $this->connection->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		$stmt->bind_param("ssss",$project,$customer,$deadline,$contact);
		
		//täida käsku
		if($stmt->execute())
		{
			echo "salvsestamine õnnestus";
		}
		else
		{
			echo "ERROR ".$stmt->error;
		}
		
		//panen ühenduse kinni
		$stmt->close();
	
	}
		function deleteProject()
	{
			
				$this->connection->set_charset("utf8");
				// sqli rida
				$dealID = $_GET['remove'];
				$stmt = $this->connection->prepare("UPDATE  project_details SET deleted=NOW() WHERE id = '$dealID'");
				
				
				echo $this->connection->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
				
				
				//täida käsku
				if($stmt->execute())
				{
					echo "salvsestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				//panen ühenduse kinni
				$stmt->close();
				
		
	}
	function updateProject($project,$customer,$deadline,$contact)
	{
		
		
		$this->connection->set_charset("utf8");
		// sqli rida
		$dealID = $_GET['edit'];
		
		$stmt = $this->connection->prepare("UPDATE  project_details SET project='$project', customer='$customer', deadline='$deadline',contact='$contact' WHERE id = '$dealID'");
		
		echo $this->connection->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
				
				
				//täida käsku
				if($stmt->execute())
				{
					echo "salvsestamine õnnestus";
				}
				else
				{
					echo "ERROR ".$stmt->error;
				}
				
				//panen ühenduse kinni
				$stmt->close();
				
	}
	
	function getAllProjectDetails($search,$sort)
	{
		$allowedSortOptions=["id","project","project1","customer","customer1","deadline","deadline1"];
		// kas sort on lubatud valikute sees
		if(!in_array($sort,$allowedSortOptions))
		{
			$sort="id";
		}
		$orderBy = "ASC";
		$this->connection->set_charset("utf8");
		if($sort == $allowedSortOptions[2] OR $sort == $allowedSortOptions[4] OR $sort == $allowedSortOptions[6])
			{
				$sort = substr($sort, 0, -1);
				$orderBy = "DESC";
			
			}
		// sqli rida
		if($search =="")
		{
			
		$stmt = $this->connection->prepare("SELECT id,project,customer,deadline,contact FROM project_details WHERE deleted IS NULL ORDER BY $sort $orderBy");
		
		//maaran vaartused muutujatesse
		}
		else
		{
		
		$searchword="%".$search."%";
		$stmt = $this->connection->prepare("
		
		SELECT id,project,customer,deadline,contact 
		FROM project_details 
		WHERE deleted IS NULL AND(project LIKE ? OR customer LIKE ? OR deadline LIKE ? OR contact LIKE ?)
		ORDER BY $sort $orderBy"			
		);
		$stmt->bind_param("ssss",$searchword,$searchword,$searchword,$searchword);	
		}
		$stmt ->bind_result($id,$project,$customer,$deadline,$contact);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result=array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		//fetch annab andmeid uhe rea kaupa
		while($stmt->fetch())
		{
			//tekitan objekti
			$proj = new StdClass();
			
			$proj->id = $id;
			$proj->project = $project;
			$proj->customer = $customer;
			$proj->deadline = $deadline;
			$proj->contact = $contact;
			
			//echo $plate."<br>";
			//iga kord massiivi lisan juurde nr. m2rgi
			array_push($result,$proj);
		}
		
		$stmt->close();
		
		
		return $result;
	}
}
?>