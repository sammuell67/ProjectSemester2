<?php
  include 'header.php';
  include 'dbh.php';
mysqli_set_charset($conn, "utf8");

echo "<h2>Informácie z IP</h2>";

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

$ip = $details->ip;
$suradnice = $details->loc;
$skratka = $details->country;

if($details->city){
  $mesto = $details->city;
} else{
 $mesto = 'vidiek';
}

$krajiny = json_decode(file_get_contents("http://country.io/names.json"), true);
$krajina =  $krajiny[$skratka];

echo "IP: ".$ip."<br>";
echo "GPS: ".$suradnice."<br>";
if (!$details->city) {
	echo "mesto sa nedá lokalizovať alebo sa nachádzate na vidieku<br>";
}
else {	
	echo "Mesto: ".$mesto."<br>";
}
echo "Krajina: ".$skratka."<br>";

$json_string = curl_download("https://restcountries.eu/rest/v2/alpha/$details->country");
$parsed_json = json_decode($json_string);

$capital = $parsed_json->{'capital'};
echo "Hlavné mesto: ".$capital."<br>";

$pieces = explode(",", $details->loc);
$tmp = get_nearest_timezone($pieces[0], $pieces[1], $details->country) ;
$d = new DateTime("now", new DateTimeZone($tmp));
$cas=  $d->format('Y-m-d H:i');
//echo "cas: ".$cas."<br>";

$dateBefore24Hours = date('Y-m-d H:i',(strtotime ( '-1 day' , strtotime ( $cas) ) ));

$sql = "SELECT * from Casy WHERE ip = '$details->ip' AND stranka = 'ip' AND cas > '$dateBefore24Hours'";
//echo "1. ".$sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows == 0) {  // nie je navsteva 
  $sql = "INSERT INTO Casy (cas, stranka, ip) VALUES ('$cas', 'ip', '$details->ip')";
  $conn->query($sql);
}
else {
  $sql = "UPDATE Casy SET cas = '$cas' WHERE ip = '$details->ip' AND stranka = 'ip'";
  $conn->query($sql);
}

function curl_download($Url){
  if (!function_exists('curl_init')){
    die('Sorry cURL is not installed!');
  }
  
  $ch = curl_init();  
  curl_setopt($ch, CURLOPT_URL, $Url); 
  curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");  
  curl_setopt($ch, CURLOPT_HEADER, 0);  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}


function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                } 

            }
        }
        return  $time_zone;
    }
    return 'unknown';
}
 ?>
  </body>
</html>
