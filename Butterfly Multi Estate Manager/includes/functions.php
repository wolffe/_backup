<?php
// Refresh page - redirection to 'index.php'
function redirect() {
	echo '<meta http-equiv="refresh" content="0; url=index.php" />';
}

// Mutiuser routines
// Salt Generator
function generate_salt() {
	// Declare $salt
	$salt = '';
	// And create it with random chars
	for ($i = 0; $i < 3; $i++) {
		$salt .= chr(rand(35, 126));
	}
	return $salt;
}

function user_register($username, $password) {
	// Get a salt using our function
	$salt = generate_salt();
	// Now encrypt the password using that salt and lastly, store the information in the database
	$query = "INSERT INTO user (username, password, salt) values ('$username', '$password', '$salt')";
	mysql_query ($query) or die ('Could not create user.');
}

function user_login($username, $password) {
	$query = "SELECT userid, username FROM user WHERE username='$username' AND password='$password'";
	$result = mysql_query($query);
	$user = mysql_fetch_array($result);
	$numrows = mysql_num_rows($result);
	// Now encrypt the data to be stored in the session
	$encrypted_id = md5($user['userid']);
	$encrypted_name = md5($user['username']);
	// Store the data in the session
	$_SESSION['username'] = $username;
	$_SESSION['encrypted_id'] = $encrypted_id;
	$_SESSION['encrypted_name'] = $encrypted_name;
	if($numrows == 1)
		return 'Correct';
	else
		return 'Error';
}

function user_logout() {
	// End the session and unset all vars
	session_unset ();
	session_destroy ();
}

function is_authed() {
	if(isset($_SESSION['username'])) {
		return true;
	}
	else {
		return false;
	}
}
function is_admin() {
	if(isset($_SESSION['username']) && $_SESSION['username'] == 'admin') {
		return true;
	}
	else {
		return false;
	}
}

/**********************************************************************/
function restrictedAccess() {
	echo '<h2>Restricted Access!</h2>';
	echo '<p>You need to be logged in to view this page.</p>';
	echo '<p><a href="register.php"><strong>Register now</strong></a> or <a href="login.php"><strong>log into your account</strong></a>.';
}

function google_maps($lat,$lon,$id,$z,$w,$h,$maptype,$address,$kml,$marker,$markerimage,$traffic,$infowindow) {

	/*
	'lat'   => '0', 
	'lon'    => '0',
	'id' => 'map',
	'z' => '8',
	'w' => '400px',
	'h' => '300',
	'maptype' => 'ROADMAP',
	'address' => '',
	'kml' => '',
	'marker' => '',
	'markerimage' => '',
	'traffic' => 'no',
	'infowindow' => ''
	*/

	$returnme = '
		<div id="'.$id.'" style="width:'.$w.';height:'.$h.'px;"></div>
		<script type="text/javascript">
		var latlng = new google.maps.LatLng('.$lat.', '.$lon.');
		var myOptions = {
			zoom: '.$z.',
			center: latlng,
			mapTypeId: google.maps.MapTypeId.'.$maptype.',
			streetViewControl: true
		};
		var '.$id.' = new google.maps.Map(document.getElementById("'.$id.'"),
		myOptions);';

		//kml
		if($kml != '') {
			//Wordpress converts "&" into "&#038;", so converting those back
			$thiskml = str_replace("&#038;","&",$kml);		
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\''.$thiskml.'\');
			kmllayer.setMap('.$id.');';
		}

		//traffic
		if($traffic == 'yes') {
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap('.$id.');';
		}

		//address
		if($address != '') {
			$returnme .= 'var geocoder_'.$id.' = new google.maps.Geocoder();';

			$returnme .= 'var temp = [';
				$marker_result = mysql_query("SELECT * FROM data WHERE approved='1' ORDER BY date DESC LIMIT 15");
				while($marker_row = mysql_fetch_array($marker_result)) {
					if($marker_row['address'] != '')
						$returnme .= '"' . $marker_row['address'] . '", ';
				}
			$returnme .= '];';
//			$returnme .= 'var temp = ["1667 Balvaird Dr, Lawrenceville, GA 30045", "4158 Oak Crest Drive, Tucker, GA 30084", "1736 Defoor Pl, Atlanta, GA 30318"];
			$returnme .= 'for (var i = 0; i < temp.length; ++i) {
				(function(address) {
					geocoder_' . $id . '.geocode({
						"address": address
					}, function(results) {
						var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location,
							title: address
						});
						/*
						google.maps.event.addListener(marker, "click", function() {
							alert(address);
						});
						*/
					});
				})(temp[i]);
			}';
		}

		$returnme .= '</script>';
		echo $returnme;
}

function google_singular_maps($lat,$lon,$id,$z,$w,$h,$maptype,$address,$kml,$marker,$markerimage,$traffic,$infowindow) {

	/*
	'lat'   => '0', 
	'lon'    => '0',
	'id' => 'map',
	'z' => '8',
	'w' => '400',
	'h' => '300',
	'maptype' => 'ROADMAP',
	'address' => '',
	'kml' => '',
	'marker' => '',
	'markerimage' => '',
	'traffic' => 'no',
	'infowindow' => ''
	*/

	$returnme = '
		<div id="'.$id.'" style="width:'.$w.'px;height:'.$h.'px;"></div><br />
		<script type="text/javascript">
		var latlng = new google.maps.LatLng('.$lat.', '.$lon.');
		var myOptions = {
			zoom: '.$z.',
			center: latlng,
			mapTypeId: google.maps.MapTypeId.'.$maptype.',
			streetViewControl: true
		};
		var '.$id.' = new google.maps.Map(document.getElementById("'.$id.'"),
		myOptions);';

		//kml
		if($kml != '') {
			//Wordpress converts "&" into "&#038;", so converting those back
			$thiskml = str_replace("&#038;","&",$kml);		
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\''.$thiskml.'\');
			kmllayer.setMap('.$id.');';
		}

		//traffic
		if($traffic == 'yes') {
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap('.$id.');';
		}

		//address
		if($address != '') {
			$returnme .= 'var geocoder_'.$id.' = new google.maps.Geocoder();';

			$returnme .= 'var address = \''.$address.'\';
			geocoder_'.$id.'.geocode({ \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					'.$id.'.setCenter(results[0].geometry.location);';

					if($marker !='') {
						//add custom image
						if($markerimage !='') {
							$returnme .= 'var image = "'. $markerimage.'";';
						}
						$returnme .= '
						var marker = new google.maps.Marker({
							map: ' . $id . ', ';
							if ($markerimage !='')
								$returnme .= 'icon: image,';
						$returnme .= '
							position: ' . $id . '.getCenter()
						});';

						//infowindow
						if($infowindow != '') {
							//first convert and decode html chars
							$thiscontent = htmlspecialchars_decode($infowindow);
							$returnme .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
										
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $id . ',marker);
							});';
						}
					}
			$returnme .= '
				} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});';
		}

		//marker: show if address is not specified
		if ($marker != '' && $address == '') {
			//add custom image
			if ($markerimage !='') {
				$returnme .= 'var image = "'. $markerimage .'";';
			}

			$returnme .= '
				var marker = new google.maps.Marker({
				map: ' . $id . ', ';
				if ($markerimage !='') {
					$returnme .= 'icon: image,';
				}
			$returnme .= '
				position: ' . $id . '.getCenter()
			});';

			//infowindow
			if($infowindow != '') {
				$returnme .= '
				var contentString = \'' . $infowindow . '\';

				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
							
				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $id . ',marker);
				});';
			}
		}

		$returnme .= '</script>';
		echo $returnme;
}

?>
