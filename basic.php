<?php
//Denne koden er skrevet av Patrick S. Lorentzen. -151685

$tabellen = $_GET['tabell'];
$kollonen = $_GET['kollonen']; 
$verdien = $_GET['verdien']; 
$where = $_GET['where'] = ''; 
$temp = $_GET['funksjonsnavn']; 

//Lag en variablel som kobler mot en database.
$tilkobling = new mysqli("itfag.usn.no",
						"v20app2000u1",
						"pw1",
					     "v20app2000db1");



//Sjekker om tilkoblingen fungerer, hvis ikke lever feilmelding og avslutt
if($tilkobling->connect_error) {
 	die("Tilkobling til databasen feilet: " . $tilkobling->connect_error); 
}

$temp($tilkobling,$tabellen,$kollonen, $verdien, $where);

//echo $temp . " " . $tabellen . " " . $kollonen . " " . $verdien;




function søkEtter($tilkobling,$tabellen, $kollonen, $verdien, $where){

$sendUt = []; //Resultatene til funksjonene lagres inni denne tabellen. 
	
 //Lag variabel som inneholder sql spørringen
	$sql = "SELECT * FROM " . $tabellen . " WHERE " . $kollonen . " = " .  $verdien; 
//$sql = "SELECT * FROM " . $tabellen; 


//Kjør sql spørringen mot databasen og få ut hele tabellen inn i variabelen resultat
$resultat = $tilkobling->query($sql);

//Del opp resultatet i rader via fetch assoc
 		while($rad = $resultat->fetch_assoc()){
 			array_push($sendUt, $rad); 
 		}
 		
 		echo json_encode($sendUt);

 		//Vi lukker koblingen
$resultat->close();
}




function slettFra($tilkobling,$tabellen, $kollonen, $verdien, $where){
	//Lag variabel som inneholder sql spørringen
$sql = "DELETE FROM " . $tabellen . " WHERE " . $kollonen . " = " .  "'$verdien'"; 

//Kjør sql spørringen mot databasen
if($tilkobling->query($sql)){
	echo $verdien . " har blitt slettet fra " . $tabellen; 
} else echo "Noe gikk feil! Kontakt Administrator!"; 

}


function settInnNy($tilkobling,$tabellen, $kollonen, $verdien, $where){

 //Lag variabel som inneholder sql spørringen
$sql = "INSERT INTO " . $tabellen ."(" . $kollonen .")"  . " VALUES(" . $verdien . ")"; 


//Kjør sql spørringen mot databasen
if($tilkobling->query($sql)){
	echo $verdien . " har blitt skrevet inn i tabellen " . $tabellen; 
} else echo "Noe gikk feil! Prøv igjen"; 


}

function forandrePå($tilkobling,$tabellen, $kollonen, $verdien, $where){

$sql = "UPDATE " . $tabellen ." SET "  . $kollonen . " = " . $verdien . " WHERE " . $where; 

//Kjør sql spørringen mot databasen
if($tilkobling->query($sql)){
	echo $verdien . " har blitt skrevet inn i raden " . $kollonen; 
} else echo "Noe gikk feil! Enten har du skrevet noe feil i verdiene ellers så må du Kontakt Administrator!"; 
 
} 		 

//Vi lukker koblingen
mysqli_close($tilkobling); 
?>