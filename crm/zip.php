<?php
// TYCOON ZIP ARCHIVER (ON DEMAND) (LA BOTU' CALULUI)
// VERSION: 1.1
// REQUIREMENTS: PHP ZIP extensions with ZipArchive class (included)

$zipit = $_GET['zipit'];
$filename = basename($zipit, '.php'); 

// BEGIN SETTINGS
// directory you want to zip (no ending slash)
// '.' - for root
// 'folder' - for some folder
// 'folder/subfolder' - for some subfolder
$directory = ''.$zipit;

// name of ZIP archive to be created
$zipfile = 'zips/'.$zipit.date('-Ymd-h-i-s').'.zip';

// END SETTINGS
$filenames = array();

// browse the directory and all subdirectories inside
// add all files to an array
function browse($dir) {
	global $filenames;
		if($handle = opendir($dir)) {
			while(false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..' && is_file($dir.'/'.$file)) {
					$filenames[] = $dir.'/'.$file;
				}
				else if($file != '.' && $file != '..' && is_dir($dir.'/'.$file)) {
					browse($dir.'/'.$file);
				}
			}
		closedir($handle);
	}
	return $filenames;
}
browse($directory);

// create ZIP archive, add browsed files
$zip = new ZipArchive();

if($zip->open($zipfile, ZIPARCHIVE::CREATE) !== TRUE) {
	exit("Error: Cannot open <strong>$zipfile</strong>\n");
}

foreach($filenames as $filename) {
	//echo 'Progress: Adding '.$filename.'<br />'; // deactivated because of lack of a proper GUI
	$zip->addFile($filename,$filename);
}

// DEBUG
//echo 'numfiles: '.$zip->numFiles."\n";
//echo 'status: '.$zip->status."\n";
$zip->close();

function forceDownload($filenamea){
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=\"$filenamea\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($filenamea));
	readfile("$filenamea");
}
forceDownload($zipfile);
?>
