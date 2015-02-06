<?php include('includes/header.php');?>
<?php
if(is_authed()) {
	if(isset($_POST['submit'])) {
		// UPLOAD IMAGE
		$path_to_image_directory = 'uploads/photos/';

		if((isset($_FILES['photo']['name'])) && (preg_match('/[.](jpg)|(gif)|(png)|(JPG)|(GIF)|(PNG)$/', $_FILES['photo']['name']))) {  
			$filename1 = $_FILES['photo']['name'];  

			$filename1 = trim($filename1);
			$filename1 = str_replace(' ','-',$filename1);
			$filename1 = strtolower($filename1);
			$u = uniqid();
			$filename1 = 'a'.$u.$filename1;

			$source1 = $_FILES['photo']['tmp_name'];     
			$target1 = $path_to_image_directory.$filename1;  
			move_uploaded_file($source1, $target1);  
		}
		else $filename1 = $_POST['photo'];

		$id 				= $_POST['id'];

		$name 				= addslashes($_POST['name']);
		$lastname 			= addslashes($_POST['lastname']);
		$age 				= addslashes($_POST['age']);

		$address 			= addslashes($_POST['address']);
		$location 			= addslashes($_POST['location']);
		$county 			= addslashes($_POST['county']);
		$country 			= addslashes($_POST['country']);
		$phone 				= addslashes($_POST['phone']);
		$mobile 			= addslashes($_POST['mobile']);
		$email 				= addslashes($_POST['email']);

		$linkedin 			= addslashes($_POST['linkedin']);

		$diplomas1 			= addslashes($_POST['diplomas1']);
		$diplomas2 			= addslashes($_POST['diplomas2']);
		$diplomas3 			= addslashes($_POST['diplomas3']);
		$pqe 				= addslashes($_POST['pqe']);
		$languages 			= addslashes($_POST['languages']);
		$status 			= addslashes($_POST['status']);

		$category 			= addslashes($_POST['category']);
		$currentworkplace 	= addslashes($_POST['currentworkplace']);
		$currentrole 		= addslashes($_POST['currentrole']);
		$lastworkplace 		= addslashes($_POST['lastworkplace']);
		$previousrole 		= addslashes($_POST['previousrole']);
		$currentroletype 	= addslashes($_POST['currentroletype']);
		$available 			= addslashes($_POST['available']);
		$duration 			= addslashes($_POST['duration']);

		$roles_complete 	= '';
		while(list($key, $value) = each($_POST['roles'])) {
			$roles_complete .= ($value.',');
		}

		//$roles 			= substr($roles_complete,0,-2);
		$roles 				= $roles_complete;
		$areamove 			= addslashes($_POST['areamove']);
		$followup 			= addslashes($_POST['followup']);
		$salary 			= addslashes($_POST['salary']);
		$travel 			= addslashes($_POST['travel']);

		$interviews 		= addslashes($_POST['interviews']);
		$lastcontact 		= addslashes($_POST['lastcontact']);
		$senttoclient 		= addslashes($_POST['senttoclient']);
		$placedby 			= addslashes($_POST['placedby']);
		$placed 			= addslashes($_POST['placed']);
		$dateofplacement 	= addslashes($_POST['dateofplacement']);

		$comments 			= addslashes($_POST['comments']);
		$feedback 			= addslashes($_POST['feedback']);
		$meetingnotes 		= addslashes($_POST['meetingnotes']);

		$photo 				= $filename1;

		$sql = "
			UPDATE items SET
				name 			= '$name',
				lastname 		= '$lastname',
				age 			= '$age',

				address 		= '$address',
				location 		= '$location',
				county 			= '$county',
				country 		= '$country',
				phone 			= '$phone',
				mobile 			= '$mobile',
				email 			= '$email',

				linkedin 		= '$linkedin',

				diplomas1 		= '$diplomas1',
				diplomas2 		= '$diplomas2',
				diplomas3 		= '$diplomas3',
				pqe 			= '$pqe',
				languages 		= '$languages',
				status 			= '$status',

				category 			= '$category',
				currentworkplace 	= '$currentworkplace',
				currentRole 		= '$currentrole',
				lastworkplace 		= '$lastworkplace',
				previousRole 		= '$previousrole',
				currentRoleType 	= '$currentroletype',
				available 			= '$available',
				duration 			= '$duration',

				roles 				= '$roles',
				areamove 			= '$areamove',
				followup 			= '$followup',
				salary 				= '$salary',
				travel 				= '$travel',

				interviews 			= '$interviews',
				lastContact 		= '$lastcontact',
				sentToClient 		= '$senttoclient',
				placedBy 			= '$placedby',
				placed 				= '$placed',
				dateOfPlacement 	= '$dateofplacement',

				comments 			= '$comments',
				feedback 			= '$feedback',
				meetingnotes 		= '$meetingnotes',

				photo 			= '$filename1'
			WHERE id = '$id';
		";
		mysql_query($sql) or die();
		echo '<div class="confirm">'.$lang['CV_EDITED'].'</div>';

		// BEGIN ACTIVITY FEED
		$aUser = $_SESSION['username'];
		$aAction = '<strong>'.$aUser.'</strong> modified a CV (<a href="edit.php?id='.$id.'">'.$id.'</a>)!';
		$sql = "INSERT INTO activity (aDate, aUser, aAction) VALUES (NOW(), '$aUser', '$aAction');";
		mysql_query($sql);
		// END ACTIVITY FEED

			// begin multiple file upload
			$number_of_file_fields = 0;
		    $number_of_uploaded_files = 0;
		    $number_of_moved_files = 0;
		    $uploaded_files = array();
		    $upload_directory = dirname(__file__) . '/uploads/resumes/'; //set upload directory
		    /**
		     * we get a $_FILES['images'] array, we process this array while iterating with simple for loop 
		     * you can check this array by print_r($_FILES['images']); 
		     */
			for($i = 0; $i < count($_FILES['images']['name']); $i++) {
				$number_of_file_fields++;
				$u = uniqid();
				if($_FILES['images']['name'][$i] != '') { //check if file field empty or not
					$number_of_uploaded_files++;

					$attachmentname = $_FILES['images']['name'][$i];

					$attachmentname = trim($attachmentname);
					$attachmentname = str_replace(' ','-',$attachmentname);
					$attachmentname = str_replace('&','-',$attachmentname);
					$attachmentname = str_replace(';','-',$attachmentname);
					$attachmentname = strtolower($attachmentname);
					$attachmentname = $u.'-'.$attachmentname;

					$uploaded_files[] = $attachmentname;
					if(move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_directory.$attachmentname)) {
						$number_of_moved_files++;
					}
				}
				if($number_of_uploaded_files > 0)
					mysql_query("INSERT INTO attachments (attachment, itemid) VALUES ('".$attachmentname."', '".$id."')");
			}
		}
		else {
			if(isset($_GET['id']))
				$id = mysql_real_escape_string($_GET['id']);
			$sql = "SELECT * FROM items WHERE id = '$id' LIMIT 1";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			?>
			<h2><?php echo $lang['EDIT_CV'];?></h2>

			<form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
				<div><input type="hidden" name="id" value="<?php echo $id;?>" /></div>
<div class="table-wrap">
				<table class="table-add">
					<tr>
						<td colspan="2"><h3><?php echo $lang['PERSONAL_INFORMATION'];?></h3></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['FIRST_NAME'];?></th>
						<td><input type="text" name="name" value="<?php echo $row['name'];?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['LAST_NAME'];?></th>
						<td><input type="text" name="lastname" value="<?php echo $row['lastname'];?>" /></td>
					</tr>
					<tr>
						<th scope="row">Age</th>
						<td><input type="text" name="age" value="<?php echo $row['age'];?>" /></td>
					</tr>
					<tr>
						<td colspan="2"><h3><?php echo $lang['CONTACT_INFORMATION'];?></h3></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['ADDRESS_1'];?></th>
						<td><input type="text" name="address" value="<?php echo $row['address'];?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['CITY'];?></th>
						<td><input type="text" name="location" value="<?php echo $row['location'];?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['COUNTY'];?></th>
						<td><input type="text" name="county" value="<?php echo $row['county'];?>" /></td>
					</tr>
			        <tr>
						<th scope="row">Current Location</th>
						<td>
							<select name="country">
								<option value="<?php echo $row['country'];?>" selected="selected"><?php echo $row['country'];?></option>
								<option value="Afghanistan">Afghanistan</option>
								<option value="Albania">Albania</option>
								<option value="Algeria">Algeria</option>
								<option value="American Samoa">American Samoa</option>
								<option value="Andorra">Andorra</option>
								<option value="Angola">Angola</option>
								<option value="Anguilla">Anguilla</option>
								<option value="Antarctica">Antarctica</option>
								<option value="Antigua And Barbuda">Antigua And Barbuda</option>
								<option value="Argentina">Argentina</option>
								<option value="Armenia">Armenia</option>
								<option value="Aruba">Aruba</option>
								<option value="Australia">Australia</option>
								<option value="Austria">Austria</option>
								<option value="Azerbaijan">Azerbaijan</option>
								<option value="Bahamas">Bahamas</option>
								<option value="Bahrain">Bahrain</option>
								<option value="Bangladesh">Bangladesh</option>
								<option value="Barbados">Barbados</option>
								<option value="Belarus">Belarus</option>
								<option value="Belgium">Belgium</option>
								<option value="Belize">Belize</option>
								<option value="Benin">Benin</option>
								<option value="Bermuda">Bermuda</option>
								<option value="Bhutan">Bhutan</option>
								<option value="Bolivia, Plurinational State Of">Bolivia, Plurinational State Of</option>
								<option value="Bosnia And Herzegovina">Bosnia And Herzegovina</option>
								<option value="Botswana">Botswana</option>
								<option value="Bouvet Island">Bouvet Island</option>
								<option value="Brazil">Brazil</option>
								<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
								<option value="Brunei Darussalam">Brunei Darussalam</option>
								<option value="Bulgaria">Bulgaria</option>
								<option value="Burkina Faso">Burkina Faso</option>
								<option value="Burundi">Burundi</option>
								<option value="Cambodia">Cambodia</option>
								<option value="Cameroon">Cameroon</option>
								<option value="Canada">Canada</option>
								<option value="Cape Verde">Cape Verde</option>
								<option value="Cayman Islands">Cayman Islands</option>
								<option value="Central African Republic">Central African Republic</option>
								<option value="Chad">Chad</option>
								<option value="Chile">Chile</option>
								<option value="China">China</option>
								<option value="Christmas Island">Christmas Island</option>
								<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
								<option value="Colombia">Colombia</option>
								<option value="Comoros">Comoros</option>
								<option value="Congo">Congo</option>
								<option value="Congo, The Democratic Republic Of The">Congo, The Democratic Republic Of The</option>
								<option value="Cook Islands">Cook Islands</option>
								<option value="Costa Rica">Costa Rica</option>
								<option value="Côte D'Ivoire">Côte D'Ivoire</option>
								<option value="Croatia">Croatia</option>
								<option value="Cuba">Cuba</option>
								<option value="Cyprus">Cyprus</option>
								<option value="Czech Republic">Czech Republic</option>
								<option value="Denmark">Denmark</option>
								<option value="Djibouti">Djibouti</option>
								<option value="Dominica">Dominica</option>
								<option value="Dominican Republic">Dominican Republic</option>
								<option value="Ecuador">Ecuador</option>
								<option value="Egypt">Egypt</option>
								<option value="El Salvador">El Salvador</option>
								<option value="Equatorial Guinea">Equatorial Guinea</option>
								<option value="Eritrea">Eritrea</option>
								<option value="Estonia">Estonia</option>
								<option value="Ethiopia">Ethiopia</option>
								<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
								<option value="Faroe Islands">Faroe Islands</option>
								<option value="Fiji">Fiji</option>
								<option value="Finland">Finland</option>
								<option value="France">France</option>
								<option value="French Guiana">French Guiana</option>
								<option value="French Polynesia">French Polynesia</option>
								<option value="French Southern Territories">French Southern Territories</option>
								<option value="Gabon">Gabon</option>
								<option value="Gambia">Gambia</option>
								<option value="Georgia">Georgia</option>
								<option value="Germany">Germany</option>
								<option value="Ghana">Ghana</option>
								<option value="Gibraltar">Gibraltar</option>
								<option value="Greece">Greece</option>
								<option value="Greenland">Greenland</option>
								<option value="Grenada">Grenada</option>
								<option value="Guadeloupe">Guadeloupe</option>
								<option value="Guam">Guam</option>
								<option value="Guatemala">Guatemala</option>
								<option value="Guernsey">Guernsey</option>
								<option value="Guinea">Guinea</option>
								<option value="Guinea-Bissau">Guinea-Bissau</option>
								<option value="Guyana">Guyana</option>
								<option value="Haiti">Haiti</option>
								<option value="Heard Island And Mcdonald Islands">Heard Island And Mcdonald Islands</option>
								<option value="Honduras">Honduras</option>
								<option value="Hong Kong">Hong Kong</option>
								<option value="Hungary">Hungary</option>
								<option value="Iceland">Iceland</option>
								<option value="India">India</option>
								<option value="Indonesia">Indonesia</option>
								<option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option>
								<option value="Iraq">Iraq</option>
								<option value="Ireland">Ireland</option>
								<option value="Isle Of Man">Isle Of Man</option>
								<option value="Israel">Israel</option>
								<option value="Italy">Italy</option>
								<option value="Jamaica">Jamaica</option>
								<option value="Japan">Japan</option>
								<option value="Jersey">Jersey</option>
								<option value="Jordan">Jordan</option>
								<option value="Kazakhstan">Kazakhstan</option>
								<option value="Kenya">Kenya</option>
								<option value="Kiribati">Kiribati</option>
								<option value="Korea, Democratic People's Republic Of">Korea, Democratic People's Republic Of</option>
								<option value="Korea, Republic Of">Korea, Republic Of</option>
								<option value="Kuwait">Kuwait</option>
								<option value="Kyrgyzstan">Kyrgyzstan</option>
								<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
								<option value="Latvia">Latvia</option>
								<option value="Lebanon">Lebanon</option>
								<option value="Lesotho">Lesotho</option>
								<option value="Liberia">Liberia</option>
								<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
								<option value="Liechtenstein">Liechtenstein</option>
								<option value="Lithuania">Lithuania</option>
								<option value="Luxembourg">Luxembourg</option>
								<option value="Macao">Macao</option>
								<option value="Macedonia, The Former Yugoslav Republic Of">Macedonia, The Former Yugoslav Republic Of</option>
								<option value="Madagascar">Madagascar</option>
								<option value="Malawi">Malawi</option>
								<option value="Malaysia">Malaysia</option>
								<option value="Maldives">Maldives</option>
								<option value="Mali">Mali</option>
								<option value="Malta">Malta</option>
								<option value="Marshall Islands">Marshall Islands</option>
								<option value="Martinique">Martinique</option>
								<option value="Mauritania">Mauritania</option>
								<option value="Mauritius">Mauritius</option>
								<option value="Mayotte">Mayotte</option>
								<option value="Mexico">Mexico</option>
								<option value="Micronesia, Federated States Of">Micronesia, Federated States Of</option>
								<option value="Moldova, Republic Of">Moldova, Republic Of</option>
								<option value="Monaco">Monaco</option>
								<option value="Mongolia">Mongolia</option>
								<option value="Montenegro">Montenegro</option>
								<option value="Montserrat">Montserrat</option>
								<option value="Morocco">Morocco</option>
								<option value="Mozambique">Mozambique</option>
								<option value="Myanmar">Myanmar</option>
								<option value="Namibia">Namibia</option>
								<option value="Nauru">Nauru</option>
								<option value="Nepal">Nepal</option>
								<option value="Netherlands">Netherlands</option>
								<option value="Netherlands Antilles">Netherlands Antilles</option>
								<option value="New Caledonia">New Caledonia</option>
								<option value="New Zealand">New Zealand</option>
								<option value="Nicaragua">Nicaragua</option>
								<option value="Niger">Niger</option>
								<option value="Nigeria">Nigeria</option>
								<option value="Niue">Niue</option>
								<option value="Norfolk Island">Norfolk Island</option>
								<option value="Northern Mariana Islands">Northern Mariana Islands</option>
								<option value="Norway">Norway</option>
								<option value="Oman">Oman</option>
								<option value="Pakistan">Pakistan</option>
								<option value="Palau">Palau</option>
								<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
								<option value="Panama">Panama</option>
								<option value="Papua New Guinea">Papua New Guinea</option>
								<option value="Paraguay">Paraguay</option>
								<option value="Peru">Peru</option>
								<option value="Philippines">Philippines</option>
								<option value="Pitcairn">Pitcairn</option>
								<option value="Poland">Poland</option>
								<option value="Portugal">Portugal</option>
								<option value="Puerto Rico">Puerto Rico</option>
								<option value="Qatar">Qatar</option>
								<option value="Réunion">Réunion</option>
								<option value="Romania">Romania</option>
								<option value="Russian Federation">Russian Federation</option>
								<option value="Rwanda">Rwanda</option>
								<option value="Saint Barthélemy">Saint Barthélemy</option>
								<option value="Saint Helena, Ascension And Tristan Da Cunha">Saint Helena, Ascension And Tristan Da Cunha</option>
								<option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option>
								<option value="Saint Lucia">Saint Lucia</option>
								<option value="Saint Martin">Saint Martin</option>
								<option value="Saint Pierre And Miquelon">Saint Pierre And Miquelon</option>
								<option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option>
								<option value="Samoa">Samoa</option>
								<option value="San Marino">San Marino</option>
								<option value="Sao Tome And Principe">Sao Tome And Principe</option>
								<option value="Saudi Arabia">Saudi Arabia</option>
								<option value="Senegal">Senegal</option>
								<option value="Serbia">Serbia</option>
								<option value="Seychelles">Seychelles</option>
								<option value="Sierra Leone">Sierra Leone</option>
								<option value="Singapore">Singapore</option>
								<option value="Slovakia">Slovakia</option>
								<option value="Slovenia">Slovenia</option>
								<option value="Solomon Islands">Solomon Islands</option>
								<option value="Somalia">Somalia</option>
								<option value="South Africa">South Africa</option>
								<option value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option>
								<option value="Spain">Spain</option>
								<option value="Sri Lanka">Sri Lanka</option>
								<option value="Sudan">Sudan</option>
								<option value="Suriname">Suriname</option>
								<option value="Svalbard And Jan Mayen">Svalbard And Jan Mayen</option>
								<option value="Swaziland">Swaziland</option>
								<option value="Sweden">Sweden</option>
								<option value="Switzerland">Switzerland</option>
								<option value="Syrian Arab Republic">Syrian Arab Republic</option>
								<option value="Taiwan, Province Of China">Taiwan, Province Of China</option>
								<option value="Tajikistan">Tajikistan</option>
								<option value="Tanzania, United Republic Of">Tanzania, United Republic Of</option>
								<option value="Thailand">Thailand</option>
								<option value="Timor-Leste">Timor-Leste</option>
								<option value="Togo">Togo</option>
								<option value="Tokelau">Tokelau</option>
								<option value="Tonga">Tonga</option>
								<option value="Trinidad And Tobago">Trinidad And Tobago</option>
								<option value="Tunisia">Tunisia</option>
								<option value="Turkey">Turkey</option>
								<option value="Turkmenistan">Turkmenistan</option>
								<option value="Turks And Caicos Islands">Turks And Caicos Islands</option>
								<option value="Tuvalu">Tuvalu</option>
								<option value="Uganda">Uganda</option>
								<option value="Ukraine">Ukraine</option>
								<option value="United Arab Emirates">United Arab Emirates</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="United States">United States</option>
								<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
								<option value="Uruguay">Uruguay</option>
								<option value="Uzbekistan">Uzbekistan</option>
								<option value="Vanuatu">Vanuatu</option>
								<option value="Vatican City State">Vatican City State</option>
								<option value="Venezuela, Bolivarian Republic Of">Venezuela, Bolivarian Republic Of</option>
								<option value="Viet Nam">Viet Nam</option>
								<option value="Virgin Islands, British">Virgin Islands, British</option>
								<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
								<option value="Wallis And Futuna">Wallis And Futuna</option>
								<option value="Western Sahara">Western Sahara</option>
								<option value="Yemen">Yemen</option>
								<option value="Zambia">Zambia</option>
								<option value="Zimbabwe">Zimbabwe</option>
								<option value="Åland Islands">Åland Islands</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['PHONE'];?></th>
						<td><input type="text" name="phone" value="<?php echo $row['phone'];?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['MOBILE'];?></th>
						<td><input type="text" name="mobile" value="<?php echo $row['mobile'];?>" /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['EMAIL'];?></th>
						<td><input type="text" name="email" value="<?php echo $row['email'];?>" /></td>
					</tr>
					<tr>
						<td colspan="2"><h3><?php echo $lang['BUSINESS_SOCIAL'];?></h3></td>
					</tr>
					<tr>
						<th scope="row"><img src="images/social/linkedIn.png" alt="" class="icon" /> <a href="<?php echo $row['linkedin'];?>" rel="external" target="_blank"><?php echo $lang['LINKEDIN'];?></a></th>
						<td><input type="text" name="linkedin" id="linkedin" value="<?php echo $row['linkedin'];?>" /></td>
					</tr>
					<tr>
						<td colspan="2"><h3><?php echo $lang['QUALIFICATIONS'];?></h3></td>
					</tr>
			<tr>
				<th scope="row">Degree</th>
				<td><input type="text" name="diplomas1" id="diplomas1" value="<?php echo $row['diplomas1'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Masters</th>
				<td><input type="text" name="diplomas2" id="diplomas2" value="<?php echo $row['diplomas2'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Professional Qualification</th>
				<td><input type="text" name="diplomas3" id="diplomas3" value="<?php echo $row['diplomas3'];?>" /></td>
			</tr>
			<tr><td colspan="2"><hr /></td></tr>
			<tr>
				<th scope="row">Years of Work Experience<br /><small>PQE</small></th>
				<td><input type="text" name="pqe" value="<?php echo $row['pqe'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Languages</th>
				<td><textarea name="languages" rows="2" cols="30"><?php echo $row['languages'];?></textarea></td>
			</tr>
					<tr>
						<th scope="row"><?php echo $lang['STATUS'];?></th>
						<td>
							<select name="status">
								<?php
								$csql = "SELECT * FROM statuses ORDER BY statusName ASC";
								$cresult = mysql_query($csql);
								while($crow = mysql_fetch_array($cresult)) {
									if($crow['sID'] == $row['status']) $selected = ' selected="selected"';
									else $selected = '';
									echo '<option value="'.$crow['sID'].'"'.$selected.'>'.$crow['statusName'].'</option>';
								}
								?>
							</select>
						</td>
					</tr>
</table>
</div>
<div class="table-wrap">
				<table class="table-add">
			<tr>
				<td colspan="2"><h3>Industry &amp; Employment</h3></td>
			</tr>
					<tr>
						<th scope="row"><?php echo $lang['CATEGORY'];?></th>
						<td>
							<select name="category">
								<?php
								$csql = "SELECT * FROM categories ORDER BY categoryname ASC";
								$cresult = mysql_query($csql);
								while($crow = mysql_fetch_array($cresult)) {
									if($crow['cid'] == $row['category']) $selected = ' selected="selected"';
									else $selected = '';
									echo '<option value="'.$crow['cid'].'"'.$selected.'>'.$crow['categoryname'].'</option>';
								}
								?>
							</select>
						</td>
					</tr>
			<tr>
				<th scope="row">Current Employer</th>
				<td><input type="text" name="currentworkplace" value="<?php echo $row['currentworkplace'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Current Role</th>
				<td><input type="text" name="currentrole" value="<?php echo $row['currentRole'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Previous Employer</th>
				<td><input type="text" name="lastworkplace" value="<?php echo $row['lastworkplace'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Previous Role</th>
				<td><input type="text" name="previousrole" value="<?php echo $row['previousRole'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Current Role Type<br /><small>PERMANENT/CONTRACT</small></th>
				<td>
					<select name="currentroletype">
						<option value="<?php echo $row['currentRoleType'];?>"><?php echo strtoupper($row['currentRoleType']);?></option>
						<option value="Permanent">PERMANENT</option>
						<option value="Contract">CONTRACT</option>
						<option value="Unemployed">UNEMPLOYED</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo $lang['AVAILABLE'];?><br /><small>(if role is CONTRACT)</small></th>
				<td><input type="text" name="available" id="availablepicker" value="<?php echo $row['available'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Contract Duration<br /><small>(end date // approximate)</small></th>
				<td><input type="text" name="duration" id="durationpicker" value="<?php echo $row['duration'];?>" /></td>
			</tr>
					<tr>
						<th scope="row">Roles of interest to candidate</th>
						<td>
							<select name="roles[]" multiple="multiple" size="15">
								<?php
								$csql = "SELECT * FROM roles ORDER BY rolename ASC";
								$cresult = mysql_query($csql);
								$aaa = explode(',',$row['roles']);
								while($crow = mysql_fetch_array($cresult)) {
									$selected = (in_array($crow['rid'], $aaa)) ? ' selected="selected"' : '';
//									echo '<option value="'.$crow['rid'].'"'.$selected.'>'.$row['roles'].' - '.$aaa[0].' - '.$crow['rolename'].' - '.$crow['rid'].'</option>';
									echo '<option value="'.$crow['rid'].'"'.$selected.'>'.$crow['rolename'].'</option>';
								}
								?>
							</select>
						</td>
					</tr>
			<tr>
				<th scope="row">Area would like to move to</th>
				<td><input type="text" name="areamove" value="<?php echo $row['areamove'];?>" /></td>
			</tr>

			<tr>
				<th scope="row">Follow up</th>
				<td><input type="text" name="followup" id="followuppicker" value="<?php echo $row['followup'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Salary Expectation</th>
				<td><input type="text" name="salary" value="<?php echo $row['salary'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Travel abroad?</th>
				<td>
					<select name="travel">
						<option value="<?php echo $row['travel'];?>"><?php echo strtoupper($row['travel']);?></option>
						<option value="Yes">YES</option>
						<option value="No">NO</option>
					</select>
				</td>
			</tr>
</table>
</div>

<div class="clear"></div>
<hr />
<div class="table-wrap">
		<table class="table-add">
			<tr>
				<th scope="row">Interviews Undertaken</th>
				<td><textarea name="interviews" rows="2" cols="30"><?php echo $row['interviews'];?></textarea></td>
			</tr>
			<tr>
				<th scope="row">Last Contact</th>
				<td><input type="text" name="lastcontact" value="<?php echo $row['lastContact'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Sent to Client</th>
				<td><input type="text" name="senttoclient" value="<?php echo $row['sentToClient'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Placed by<br /><strong>Horizon Recruitment</strong></th>
				<td>
					<select name="placedby">
						<option value="<?php echo $row['placedBy'];?>"><?php echo strtoupper($row['placedBy']);?></option>
						<option value="Yes">YES</option>
						<option value="No">NO</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">Placed</th>
				<td><input type="text" name="placed" value="<?php echo $row['placed'];?>" /></td>
			</tr>
			<tr>
				<th scope="row">Date of Placement</th>
				<td><input type="text" name="dateofplacement" id="placementpicker" value="<?php echo $row['dateOfPlacement'];?>" /></td>
			</tr>
		</table>
</div>
<div class="table-wrap">
		<table class="table-add">
			<tr>
				<th scope="row">Our Comments</th>
				<td><textarea name="comments" rows="4" cols="30"><?php echo $row['comments'];?></textarea></td>
			</tr>
			<tr>
				<th scope="row">Feedback on Interviews Undertaken</th>
				<td><textarea name="feedback" rows="4" cols="30"><?php echo $row['feedback'];?></textarea></td>
			</tr>
			<tr>
				<th scope="row">Meeting Notes</th>
				<td><textarea name="meetingnotes" rows="4" cols="30"><?php echo $row['meetingnotes'];?></textarea></td>
			</tr>
		</table>
</div>


<div class="clear"></div>
<hr />
<div class="table-wrap-wide">
				<table class="table-add">
					<tr>
						<td colspan="3"><h3>Attachments</h3></td>
					</tr>
					<tr>
						<th scope="row"><?php echo $lang['PHOTO'];?></th>
						<td>
							<?php if($row['photo'] != '') {?><input type="hidden" name="photo" value="<?php echo $row['photo'];?>" /><a href="includes/timthumb.php?src=uploads/photos/<?php echo $row['photo'];?>&amp;w=600&amp;zc=1&amp;q=100" class="photo"><img src="includes/timthumb.php?src=uploads/photos/<?php echo $row['photo'];?>&amp;h=40&amp;w=40&amp;zc=1&amp;q=100" alt="" /></a> <a href="delete-photo.php?id=<?php echo $row['id'];?>"><img src="images/icon-delete.png" alt="<?php echo $lang['DELETE'];?>" title="<?php echo $lang['DELETE'];?>" /></a><?php }?>
							<?php if($row['photo'] == '') {?><input type="file" name="photo" /><?php }?>
						</td>
						<td></td>
					</tr>

					<tr>
						<th scope="row"><?php echo $lang['ATTACHMENTS'];?></th>
						<td>
							<hr />
							<div id="file_container"><input name="images[]" type="file" /><br /></div><a href="javascript:void(0);" onclick="add_file_field();"><?php echo $lang['ADD_ATTACHMENT'];?></a><br />
						</td>
						<td>
							<hr />
							<?php
							$aquery = "SELECT * FROM attachments WHERE itemid='".$row['id']."'";
							$aresult = mysql_query($aquery);
							while($arow = mysql_fetch_array($aresult)) {
								echo '<a href="delete-attachment.php?aid='.$arow['aid'].'"><img src="images/icon-delete.png" alt="'.$lang['DELETE'].'" title="'.$lang['DELETE'].'" style="vertical-align: middle" /></a> <a href="uploads/resumes/'.$arow['attachment'].'">'.$arow['attachment'].'</a><br />';
							}
							?>
						</td>
					</tr>

					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:right"><input type="submit" name="submit" class="button" value="<?php echo $lang['EDIT_CV'];?>" /></td>
					</tr>
				</table>
			</div>
		</form>
	<?php }?>
<?php }?>
<?php include('includes/footer.php');?>
