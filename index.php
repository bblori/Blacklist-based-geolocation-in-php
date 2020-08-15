<?php	
	// Engedelyezett orszagok.
	$engedelyezettOrszag = array("Hu", "Ro", "Ge", "Os");
	
	// Latogato ip cime.	
	$ip = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');
	
	// Orszag meghatarozasa ip cim alapjan.
    $json = file_get_contents("https://geolocation-db.com/json/".$ip);
    
    $data = json_decode($json);
    
    $latogato = $data->country_name.'<br>';

	$latogatoOrszag = substr($latogato, 0, 2);
		
	$hossz = count($engedelyezettOrszag);	
	
	if (!in_array($latogatoOrszag, $engedelyezettOrszag)){
		felvetel($ip);	
		header('Location: http://fbi.gov/');
	}
	// Blacklist.txt-re felvetel a nem engedelyezett Ip cim.
	function felvetel($ip){
		$blacklist = __DIR__ .'/blacklist.txt' ;
		$mytext = $ip . PHP_EOL;
		echo file_put_contents ($blacklist, $mytext, FILE_APPEND);
	}
    
?>