<?php












function secs_to_string ($seconds) {

  if (!$seconds) $seconds = 1;
  $seconds2 = $seconds;

  if ($seconds > 60) {
    $rem_seconds = $seconds % 60;
    $minutes = $minutes + (($seconds - $rem_seconds) / 60);
    $seconds = $rem_seconds; }

  if ($minutes > 60) {
    $rem_minutes = $minutes % 60;
    $hours = $hours + (($minutes - $rem_minutes) / 60);
    $minutes = $rem_minutes; }

  if (!$hours) $hours = "00";
  if (!$minutes) $minutes = "00";
  if (!$seconds) $seconds = "00";

  if (strlen($hours) == 1) $hours = "0".$hours;
  if (strlen($minutes) == 1) $minutes = "0".$minutes;
  if (strlen($seconds) == 1) $seconds = "0".$seconds;

  $minutes += ($hours*60);

  return "$minutes"."mins $seconds"."secs"; } 




















function stripkeywords($referer) {



### DEFINE SOME KNOWN SEARCH ENGINES
    $search_engine = array(

"alltheweb.com" => "AllTheWeb",
"google." => "Google",
"search.msn" => "MSN",
"search.aol" => "AOL",
"hotbot.lycos" => "HotBot",
"search.lycos" => "Lycos",
"hotbot.com" => "HotBot",
"msxml.excite" => "Excite",
"srch.overture" => "Go-Infoseek",
"search.netscape" => "Netscape",
"search.yahoo" => "Yahoo",
"altavista" => "AltaVista",
"dpxml.webcrawler" => "WebCrawler",
"search.dmoz" => "DMOZ",
"nlsearch" => "NorthernLight",
"euroseek" => "Euroseek",
"search.dogpile" => "Dogpile",
".search.com" => "SearchDotCom",
".overture." => "Overture"

);


### DEFINE SAME SEARCH ENGINES SEARCH STRING INPUT NAME FROM THEIR REFERRING URL
    $search_engine_q = array(

"AllTheWeb" => "q",
"Google" => "q",
"MSN" => "q",
"AOL" => "query",
"HotBot" => "query",
"Lycos" => "query",
"Excite" => "qkw",
"Go-Infoseek" => "Keywords",
"Netscape" => "query",
"Yahoo" => "p",
"AltaVista" => "q",
"WebCrawler" => "qkw",
"DMOZ" => "search",
"NorthernLight" => "qr",
"Euroseek" => "string",
"Dogpile" => "q",
"SearchDotCom" => "q",
"Overture" => "Keywords"

);



foreach ($search_engine as $key => $value) {
  if (preg_match("/$key/i", $referer)) $referer2 = $value; }

$parts1 = explode("?",$referer);
$parts2 = explode("&",$parts1[1]);

foreach ($parts2 as $i) {
  $vars = explode("=",$i);	
  if ($vars[0] == $search_engine_q[$referer2]) { 
    $keywords = $vars[1]; } }

if ($keywords) return "$referer2|$keywords";
else return "0";


 }












function format_country_language($code) {

    $file = fopen("includes/listlanguages.txt", "r");
    $readit = fread($file,filesize("includes/listlanguages.txt"));
    $langarray = explode("\n",$readit);
    fclose($file);

    $file = fopen("includes/listcountries.txt", "r");
    $readit = fread($file,filesize("includes/listcountries.txt"));
    $countryarray = explode("\n",$readit);
    fclose($file);


$pair = "";
$pair = explode("-",$code);

if ($pair[1]){
  $mylang = $pair[0];
  $mycountry = $pair[1]; }
else {
  $mylang = $code;
  $mycountry = ""; }

$mylang2 = $mylang;
$mycountry2 = $mycountry;

foreach ($langarray as $df) {
  $trans = explode(";",$df);
  if ($trans[0] == $mylang) $mylang = $trans[1]; }

foreach ($countryarray as $df) {
  $trans = explode(";",$df);
  if ($trans[0] == $mycountry) $mycountry = $trans[1]; }

$mylang = str_replace(" ","&nbsp;",$mylang);

if (!$mylang&&!$mycountry||($code=="Unknown")) $showit = "Unknown";
elseif ($mylang&&!$mycountry) $showit = "Unspecified&nbsp;Country&nbsp;($mylang)";
elseif (!$mylang&&$mycountry) $showit = "$mycountry&nbsp;(Unspecified&nbsp;Language)";
elseif ($mylang&&$mycountry) $showit = "$mycountry&nbsp;($mylang)";

if (!$mycountry2 || $mycountry == "Unknown") $mycountry2 = "-";

$returnstring = "<img src=images/flags/$mycountry2.gif height=12 width=18>&nbsp;$showit";

return $returnstring;

}

?>