<?php
  include 'header.php';
  include 'dbh.php';
  mysqli_set_charset($conn, "utf8");

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
///////////////////////////////////////////////////////////////////////////////
$pieces = explode(",", $details->loc);		
$tmp = get_nearest_timezone($pieces[0], $pieces[1], $details->country) ;
$d = new DateTime("now", new DateTimeZone($tmp));
$cas=  $d->format('Y-m-d H:i');

$dateBefore24Hours = date('Y-m-d H:i',(strtotime ( '-1 day' , strtotime ( $cas) ) ));
///////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * from Casy WHERE ip = '$details->ip' AND stranka = 'navstevy' AND cas > '$dateBefore24Hours'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {  // nie je navsteva 
  $sql = "INSERT INTO Casy (cas, stranka, ip) VALUES ('$cas', 'navstevy', '$details->ip')";
  $conn->query($sql);
}
else {
  $sql = "UPDATE Casy SET cas = '$cas' WHERE ip = '$details->ip' AND stranka = 'navstevy'";
  $conn->query($sql);
}
////////////////////////////////////////////////////////////

$sql = "SELECT sum(pocet) AS pocet, krajina, skratka  FROM Navstevy group by krajina, skratka";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<table><tr><th>Vlajka</th><th>Krajina</th><th>Počet</th></tr>";

	while($row = $result->fetch_assoc()) {
		$c = $row['krajina'];
		$sql = "SELECT mesto, sum(pocet) AS pocet FROM Navstevy where krajina = '$c' group by mesto";
		$result2 = $conn->query($sql);

		if ($result2->num_rows > 0) {

			$tabulka = "<table id='malatab'><tr><th>Mesto</th><th>Počet</th></tr>";
			while($row2 = $result2->fetch_assoc()) {
				$tabulka= $tabulka."<tr><td>".$row2["mesto"]."</td><td>".$row2["pocet"]."</td></tr>";
			}

			$tabulka= $tabulka."</table>";

			$skr = strtolower($row["skratka"]);
			echo "<tr>
					<td style='width: 60px;'><img src='http://www.geonames.org/flags/x/{$skr}.gif' alt='flag' width='40' height='25'></td>
					<td class='clickable'>".$row["krajina"]."<div class='okno' style='display:none;'>".$tabulka."</div></td>
					<td>".$row["pocet"]."</td>
				</tr>";
		}

	} 
	echo "</table>";
}

//////////////////////////////////// POCTY NAVSTEV ////////////////////////////////////////////
$sql = "SELECT stranka, count(id) AS pocet FROM Casy GROUP BY stranka ORDER BY count(id) DESC ";
$result = $conn->query($sql);
	echo "<table><tr><th>Stránka</th><th>Počet unikátnych návštev</th></tr>";

	while($row = $result->fetch_assoc()) {
		if ($row["stranka"] == 'index') $row["stranka"] = 'Predpoveď počasia';
		if ($row["stranka"] == 'navstevy') $row["stranka"] = 'Štatistiky návštev';
		if ($row["stranka"] == 'ip') $row["stranka"] = 'Info o IP adrese';
		echo "<tr>
				<td>".$row["stranka"]."</td>
				<td>".$row["pocet"]."</td>
				</tr>";
	}
	echo "</table>";


/////////////////////////////// CASY NAVSTEV ////////////////////////////////////////////
$sql = "SELECT COUNT(id) AS pocet FROM Casy WHERE (SELECT RIGHT(cas,5)) BETWEEN '06:01' AND '14:00' AND stranka = 'index'";
$result = $conn->query($sql);
	echo "<table><tr><th>Časové obdobie</th><th>Počet návštev</th></tr>";

	while($row = $result->fetch_assoc()) {
		echo "<tr><td>6:00 - 15:00</td><td>".$row["pocet"]."</td></tr>";
	}

$sql = "SELECT COUNT(id) AS pocet FROM Casy WHERE (SELECT RIGHT(cas,5)) BETWEEN '14:01' AND '20:00' AND stranka = 'index'";
$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>15:00 - 21:00</td><td>".$row["pocet"]."</td></tr>";
	}

$sql = "SELECT COUNT(id) AS pocet FROM Casy WHERE (SELECT RIGHT(cas,5)) BETWEEN '20:01' AND '23:59' AND stranka = 'index'";
$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>21:00 - 23:59</td><td>".$row["pocet"]."</td></tr>";
	}

$sql = "SELECT COUNT(id) AS pocet FROM Casy WHERE (SELECT RIGHT(cas,5)) BETWEEN '00:00' AND '06:00' AND stranka = 'index'";
$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>00:00 - 06:00</td><td>".$row["pocet"]."</td></tr>";
	}
	echo "</table>";




////////////////////////////////  MAPA   ///////////////////////////////////////////
$return_arr = array();
$sql = "SELECT * FROM Navstevy";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	while($row = $result->fetch_assoc()) {
		$row_array['name'] = $row['mesto'];
		$pieces = explode(",", $row['suradnice']);
		$row_array['lat'] = $pieces[0];
		$row_array['lng'] = $pieces[1];
		array_push($return_arr,$row_array);
	}
} 
$markers =  json_encode($return_arr);

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
 
<div id='map'></div>

<script type='text/javascript'>


	<?php
	echo "var markers=$markers;\n";
	?>
/////https://developers.google.com/maps/documentation/javascript/mysql-to-maps
	function initMap() {

            var latlng = new google.maps.LatLng(48.6688582,18.5750757); // default location
            var myOptions = {
            	zoom: 3,
            	center: latlng,
            	mapTypeId: google.maps.MapTypeId.ROADMAP,
            	mapTypeControl: false
            };

            var map = new google.maps.Map(document.getElementById('map'),myOptions);
            var infowindow = new google.maps.InfoWindow(), marker, lat, lng;

            var count = Object.keys(markers).length;

            for (i = 0; i < count; i++) { 

            	lat = markers[i].lat;
            	lng=markers[i].lng;
            	name=markers[i].name;

            	marker = new google.maps.Marker({
            		position: new google.maps.LatLng(lat,lng),
            		name:name,
            		map: map
            	}); 
            	google.maps.event.addListener( marker, 'click', function(e){
            		infowindow.setContent( this.name );
            		infowindow.open( map, this );
            	}.bind( marker ) );
            }
        }


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyZVqm8uS7NwzTjxfQlCotLCYrzG3iuJI&callback=initMap">
    </script>

