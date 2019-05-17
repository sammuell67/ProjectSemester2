<?php
include 'header.php';
include 'dbh.php';
mysqli_set_charset($conn, "utf8");

////////https://www.wunderground.com/weather/api/

//error_reporting(~0);
//ini_set('display_errors', 1);

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
///////////////////////////////////////////////////////////////////////////////
$pieces = explode(",", $details->loc);
$tmp = get_nearest_timezone($pieces[0], $pieces[1], $details->country);
$d = new DateTime("now", new DateTimeZone($tmp));
$cas = $d->format('Y-m-d H:i');
//echo "cas: ".$cas."<br>";

$dateBefore24Hours = date('Y-m-d H:i', (strtotime('-1 day', strtotime($cas))));
///////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * from Casy WHERE ip = '$details->ip' AND stranka = 'index' AND cas > '$dateBefore24Hours'";
//echo "1. ".$sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows == 0) {  // nie je navsteva 
    $sql = "INSERT INTO Casy (cas, stranka, ip) VALUES ('$cas', 'index', '$details->ip')";
    $conn->query($sql);
    //echo "2. ".$sql."<br>";
} else {
    $sql = "UPDATE Casy SET cas = '$cas' WHERE ip = '$details->ip' AND stranka = 'index'";
    $conn->query($sql);
    //echo "3. ".$sql."<br>";
}
///////////////////////////////////////////////////
$ip = $details->ip;
$suradnice = $details->loc;
$skratka = $details->country;

if ($details->city) {
    $mesto = $details->city;
} else {
    $mesto = 'vidiek';
}

$krajiny = json_decode(file_get_contents("http://country.io/names.json"), true);
$krajina = $krajiny[$skratka];

///////////////////////////////////////////////////////////////
$date = date("Y-m-d H:i");
$dateBefore24Hours = date('Y-m-d H:i', (strtotime('-1 day', strtotime($date))));
////////////////////////////////////////////////////////////////
//bola uz navsteva z tejto IP ?
$sql = "SELECT * from Navstevy WHERE ip = '$details->ip' AND mesto = '$mesto' AND krajina = '$krajina'";
$result = $conn->query($sql);
//echo "1. ".$sql."<br>";

if ($result->num_rows == 0) {  // nie je navsteva 
    $sql = "INSERT INTO Navstevy (krajina, mesto, skratka, suradnice, cas, ip, pocet)
   VALUES ('$krajina', '$mesto','$skratka','$suradnice', '$date', '$details->ip', 1)";
    $conn->query($sql);
    //echo "2a. ".$sql."<br>";
} else { // je navsteva
    //bola navsteva pred VIAC alebo pred MENEJ ako 24 hod
    $sql = "SELECT * from Navstevy WHERE ip = '$details->ip' AND cas < '$dateBefore24Hours' AND mesto = '$mesto' AND krajina = '$krajina'";
    $result = $conn->query($sql);
    //echo "3. ".$sql."<br>";

    if ($result->num_rows > 0) {  // navsteva pred VIAC ako 24 hod
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $pocet = $row['pocet'];
        $pocet = $pocet + 1;
        $sql = "UPDATE Navstevy SET pocet = $pocet, cas = '$date' WHERE id = $id";
        $conn->query($sql);
        //echo "4. ".$sql."<br>";
    } else {  // navsteva pred MENEJ ako 24 hod
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $sql = "UPDATE Navstevy SET cas = '$date' WHERE ip = '$details->ip' AND mesto = '$mesto' AND krajina ='$krajina'";
        $conn->query($sql);
        //echo "5. ".$sql."<br>";
    }
}
///////////////////////

if ($details->city) {

    $json_string = curl_download("http://autocomplete.wunderground.com/aq?query=$details->city");

    if ($json_string) {
        $places_array = json_decode($json_string);
        $places_array = $places_array->RESULTS;

        for ($i = 0; $i < count($places_array); $i++) {
            if ($places_array[$i]->c == $details->country) {
                $mesto = $places_array[$i]->zmw;
                break;
            }
        }
        $url = "http://api.openweathermap.org/data/2.5/forecast?q=" . $details->city . ",usl&APPID=bb40c1eee18471552fd54777f9f3dbb1&units=metric";


        $json_string = curl_download($url);

        $parsed_json = json_decode($json_string);


        $json = file_get_contents($url);
        $data = json_decode($json);


        echo '<h1>', $data->city->name, ' (', $data->city->country, ')</h1>';

        // the general information about the weather
        echo '<p><strong>Teplota:</strong> ', $data->list[0]->main->temp, '&deg; C</p>';
        echo '<p><strong>Vlkhosť:</strong> ', $data->list[0]->main->humidity, ' %</p>';
        echo '<p><strong>Tlak:</strong> ', $data->list[0]->main->pressure, ' hPa</p>';
        echo '<p><strong>Rýchlosť vetra</strong> ', $data->list[0]->wind->speed, ' km/h</p>';


    } else {
        echo "mesto sa nedá lokalizovať alebo sa nachádzate na vidieku<br>";
    }
} else {
    echo "mesto sa nedá lokalizovať alebo sa nachádzate na vidieku<br>";
}


function curl_download($Url)
{
    if (!function_exists('curl_init')) {
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

function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
{
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
        : DateTimeZone::listIdentifiers();

    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach ($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat = $location['latitude'];
                $tz_long = $location['longitude'];

                $theta = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                    + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone = $timezone_id;
                    $tz_distance = $distance;
                }

            }
        }
        return $time_zone;
    }
    return 'unknown';
}

?>

</body>
</html>