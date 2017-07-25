<html>
  <head>
    <title>Mairies</title>
  </head>
  <body>
<?php
ini_set('max_execution_time', 90000); 
try{  $bdd = new PDO('mysql:host=localhost;dbname=mairies;charset=utf8', 'root', ''); } catch(Exception $e){  die('Erreur : '.$e->getMessage());} 

$csv = array();
$lines = file('49to54224.csv', FILE_IGNORE_NEW_LINES);
$reponse = array();
$apikey = "AIzaSyDY3s4T-Kf6FDDF0C_TDbdmWmIRd31hcDY";

foreach ($lines as $key => $value)
{
    $csv[$key] = str_getcsv($value);
	$csv[$key] = explode(";", $csv[$key][0]);
	$cp = $csv[$key][4];
	$commune = $csv[$key][5];
	$code_insee = $csv[$key][0];
	$commune = str_replace(" ", "+", $commune);
	$query = 'https://maps.googleapis.com/maps/api/geocode/json?address=mairie+de+'.$commune.'+'.$cp.'&key='.$apikey ; 
	$json = file_get_contents($query);  
	$reponse = json_decode($json);
	$nom = $reponse->results['0']->formatted_address;
	$latitude = $reponse->results['0']->geometry->location->lat;
	$longitude = $reponse->results['0']->geometry->location->lng;
	$bdd->exec('
		INSERT INTO mairies 
		VALUES (null, "'.$code_insee.'", "'.$nom.'","'.$latitude.'", "'.$longitude.'");
		
	');
	echo $query;
}  
echo '<h1>Finished ! </h1>';
?>
  </body>
</html>