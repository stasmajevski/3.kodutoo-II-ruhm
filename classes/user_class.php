<?php class User
{
	private $connection;
	
	
	function __construct($mysqli)
	{
			// osobennost v PHP   $this ukazivaet na objekt klassa
	  $this->connection = $mysqli;
	  
	}

		// TEISED FUNKTISOONID
		
	function signUP($email,$password,$birthday,$gender)
	{
		
		
		// sqli rida
		$stmt = $this->connection->prepare("INSERT INTO login (email,password,birthday,gender) VALUES (?,?,?,?)");
		
		
		echo $this->connection->error;
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		$stmt->bind_param("ssss",$email,$password,$birthday,$gender); // sest on email ja password VARCHAR - STRING , ehk siis email - s, password - sa
		
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
	/*
	function login ($email,$password)
	{
		$error = "";
		
		$database = "if16_stanislav";
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		
		// sqli rida
		$stmt = $mysqli->prepare("SELECT id,email,password FROM login WHERE email = ?");
		
		
		echo $mysqli->error; // !!! Kui läheb midagi valesti, siis see käsk printib viga
		
		// asenad kusimargi
		$stmt ->bind_param("s",$email);
		
		//maaran vaartused muutujatesse
		$stmt ->bind_result($id,$emailFromDb,$passwordFromDb);
		// tehakse paring
		$stmt ->execute();
		
		// kas tulid andmed andmebaasist voi mitte
		// on toene kui on vahemalt uks vaste
		if($stmt->fetch())
		{
			// oli sellise meiliga kasutaja
			
			//password millega kasutaja tahab sise logida
			$hash = hash("sha512",$password); // sha512 algoritm
			
			if($hash == $passwordFromDb && $email == $emailFromDb)
			{
				echo "Kasutaja logis sisse ".$id;
				
				//maaran sessiooni muutujad, millele saan ligi teestelt lehtedelt
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
				
			}
			else
			{
				$error = "vale email või parool";
			}
		}
		else
		{
			// ei leidnud kasutajat selle meiliga
			$error = "vale email voi parool";
		}
		
		return $error;
	}
	
	*/
	
	function login ($email, $password) {
		
		
		
		

		$stmt = $this->connection->prepare("
		SELECT id, email, password, created 
		FROM login
		WHERE email = ?");
	
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//määran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}
}
?>