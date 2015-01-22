<?php


require("config.php");



if($go=="install") {




  if (mysql_query("create table $userstable(
id			int(9) unsigned not null auto_increment,
username		varchar(15) default '0' not null,
password		varchar(30) default '0' not null,
email			varchar(75) default '0' not null,

first_name		varchar(30) default '0' not null,
last_name		varchar(30) default '0' not null,
address1		varchar(60) default '0' not null,
address2		varchar(30) default '0' not null,
city			varchar(50) default '0' not null,
state			varchar(50) default '0' not null,
zip			varchar(13) default '0' not null,
country			varchar(45) default '0' not null,

signup			int(13) default '0' not null,
lastpay			varchar(13) default '0' not null,
paytype			varchar(1) default '0' not null,
lastaccess		int(13) default '0' not null,

url			varchar(150) default '0' not null,
category		varchar(45) default '0' not null,
title			varchar(45) default '0' not null,
showsite		tinyint(1) default '0' not null,

countertype		varchar(15) default 'inv' not null,
pageloads		int(13) default '0' not null,
pageloads_month		int(2) default '0' not null,

primary key(id),
key username(username)
);")) {
    echo "table $userstable created successfully<br>"; }
  else { echo "<b>table $userstable was not created ",mysql_error(),"</b><br>"; }






  if (mysql_query("create table $pagestable(
id			int(9) unsigned not null auto_increment,
userid			int(13) default '0' not null,

title			varchar(30) default '0' not null,
url			varchar(150) default '0' not null,
countdisplay		int(20) default '0' not null,
visitordisplay		int(20) default '0' not null,
displaytype		varchar(1) default 'h' not null,
countertype		varchar(15) default '0' not null,
lastaccess		int(13) default '0' not null,
timezone		varchar(3) default '0' not null,
block			text not null,

primary key(id),
key userid(userid)
);")) {
    echo "table $pagestable created successfully<br>"; }
  else { echo "<b>table $pagestable was not created ",mysql_error(),"</b><br>"; }







  if (mysql_query("create table $mainstatstable(
id			int(9) unsigned not null auto_increment,
actual_counts		int(13) default '0' not null,
actual_viewers		int(13) default '0' not null,
actual_members		int(13) default '0' not null,
members_deleted		int(13) default '0' not null,
members_expired		int(13) default '0' not null,
paid			int(13) default '0' not null,
cancelled		int(13) default '0' not null,
trial			int(13) default '0' not null,
primary key(id)
);")) {
    echo "table $mainstatstable created successfully<br>"; }
  else { echo "<b>table $mainstatstable was not created ",mysql_error(),"</b><br>"; }




if (mysql_query("insert into $mainstatstable (id) values ('1')")) echo "$mainstatstable row inserted successfully.<br>";
else echo "<b>$mainstatstable row not inserted ",mysql_error(),"</b><br>";





  echo "If there are no errors you are ready to go. Make sure you delete this file or rename it so nobody stumbles across it.<p>"; }

 




elseif ($go=="uninstall") {

  $c=mysql_query("select id from $userstable order by id desc");
  while($d=mysql_fetch_object($c)) {
    $z=mysql_query("drop table ".$statstableprefix."_".$d->id.""); }
  $z=mysql_query("drop table $userstable");
  $z=mysql_query("drop table $mainstatstable");

echo "Your Database is now History!<p><a href=?go=install>INSTALL DATABASE</a>"; }





else { echo "<a href=?go=install>INSTALL DATABASE</a> - or - <a href=?go=uninstall>DELETE DATABASE</a>"; }



if($go) mysql_close();


?>