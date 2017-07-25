
<?php
ini_set('max_execution_time', 90000); 
try{  $bdd = new PDO('mysql:host=localhost;dbname=mairies;charset=utf8', 'root', ''); } catch(Exception $e){  die('Erreur : '.$e->getMessage());} 

$csv = array();
$lines = file('csvfile.csv', FILE_IGNORE_NEW_LINES);
$reponse = array();
$apikey = "GoogleAPI_key";

foreach ($lines as $key => $value)
{
    $csv[$key] = str_getcsv($value);
	$csv[$key] = explode(";", $csv[$key][0]);
	$parameter = $csv[$key][4];
	$parameter2 = $csv[$key][5];
	$commune = str_replace(" ", "+", $commune);
	$query = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$parameter.'+'.$parameter2.'&key='.$apikey ; 
	
	$json = file_get_contents($query);  
	$reponse = json_decode($json);
	
	$nom = $reponse->results['0']->formatted_address;
	$latitude = $reponse->results['0']->geometry->location->lat;
	$longitude = $reponse->results['0']->geometry->location->lng;
	
	$bdd->exec('
		INSERT INTO table 
		VALUES (values, values);
	');
	echo $query;
}  
echo '<h1>Finished ! </h1>';
?>
