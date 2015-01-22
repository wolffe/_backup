<?php
/*
Copyright (c) 2010, 2011, 2012 Ciprian Popescu

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
*/

$gbStatsVersion = '1.0.1';

// Full URL address to where this script is installed // no trailing slash
$siteurl = 'http://127.0.0.1:4001/gbStats';

include('config2.php');

##### ADMIN USER AND PASSWORD
$adminuser = "admin";
$adminpass = "admin";



##########################
#### PAYPAL VARIABLES ####
##########################

#### THE FULL URL TO THE PAYPAL IPN SCRIPT
	$paypal_ipn = "http://www.yourdomain.com/paypal_ipn.php";
#### THE CANCEL RETURN PAGE AFTER SOMEONE CANCELS A SUBSCRIPTION SIGNUP 
	$paypal_cancel_return = "$siteurl";
#### THE RETURN PAGE AFTER SUCCESSFUL SUBSCRIPTION SIGNUP
	$paypal_return = "$siteurl";
#### THE IMAGE TO BE USED ON PAYPAL FORMS
	$paypalbuttonimage = "https://www.paypal.com/images/x-click-but20.gif";



#############################
####  DATABASE  CONNECT  ####
#############################

#### MYSQL INFORMATION:
#### HOST, USERNAME, PASSWORD
#### DATABASE NAME
	$a=mysql_connect("localhost", "root", "");
	$b=mysql_select_db("gbStats",$a);
#### MYSQL INFORMATION: NAME OF THE USERS TABLE, NAME OF THE
#### MAIN STATS TABLE, AND THE PREFIX THAT WILL BE PREPENDED
#### TO ALL THE INDIVIDUAL MEMBERS STATS TABLES
	$userstable = "gbS_users";
	$statstableprefix = "gbS_";
	$mainstatstable = "gbS_mainstats";
	$pagestable = "gbS_campaigns";


############################
#### PASSWORD VARIABLES ####
############################

	$min_pass_length=8;
	$max_pass_length=12;
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';



########################
#### FILE VARIABLES ####
########################

	$langfile = "includes/langlist.txt";        ## LANGUAGE FILE CONVERTS en-us FORMAT
	$countryfile = "includes/countries.txt";    ## COUNTRIES FILE, 1 PER LINE
	$categoryfile = "includes/categories.txt";  ## CATEGORIES FILE, 1 PER LINE








#### WHEN SOMEONE TRIES TO VIEW STATS WITHOUT BEING LOGGED IN OR A MEMBER,
#### THEY WILL SEE THIS MESSAGE
	$nologgedin = "To log in, you <b>need cookies enabled</b> on your browser.<br>If you are already logged in under another account you need to logout first <a href=logout.php>here</a>.<br>If you lost your password, have it resent to your email address <a href=lostpass.php>here</a>.<br>No $freeitem yet? Get one <a href=signup.php>here</a>.";



#### MESSAGE SHOWN TO SOMEONE AFTER INVALID USER/PASS ENTERED
	$invaliduser = "<font class=error_font><b>Invalid username or password, please try again.</b></font>";



##### THE 'HELP WITH THIS PAGE' LINK
	$helplink = "<a href=#help><font class=help_font>Click Here for Help Understanding This Page</font></a>";


##### THE 'THANK YOU FOR SIGNING UP' MESSAGE
	$thanks_for_signup = "Thanks for signing up for a $freeitem, your password has been sent to your email address. We recommend changing this password as soon as possible.<p>To activate your account, check the email we just sent you for your password, then simply <a href=members.php>login</a>.";



##### A MESSAGE SHOWN ON THE SIGNUP PAGE
	$signup_page = "Free and easy to set-up website counters hosted on our fast web server. No programming knowledge required. To sign-up for our $freeitem read and accept our Terms and Conditions below.";


##### THE WELCOME MESSAGE FOR NEW USERS
	$welcome_message = "Before you will see stats here, you need to create a campaign to track your stats.<br>This is a very simple process and gives you a small javascript code to place onto the webpage(s) you wish to track.<p><a href=edit.php?m=cc>Click here to begin!</a>";




##### THE WHOLE SET OF OPTIONS IN THE DROPDOWN SELECT MENU FOR CHOOSING A COUNTER STYLE

	$counter_display_options = "
<option class=option value=inv>Invisible Counter (Our Most Popular!)
<option class=option value=txt>Plain Text (Blends Into Site Style!)
<option class=option value=log>Logo Icon (A Tiny Logo, Thanks!)
<option value=\"\">------------------------------
<option value=\"\">Or Select a GIF Image
<option value=\"\">Counter Style Below!
<option value=\"\">------------------------------
<option class=option value=1>Style 1 - LED Small Blue
<option class=option value=2>Style 2 - LED Small Blue
<option class=option value=3>Style 3 - LED Small Green
<option class=option value=4>Style 4 - LED Small Red
<option class=option value=5>Style 5 - LED Small Gray
<option class=option value=6>Style 6 - Slot White on Black Large
<option class=option value=7>Style 7 - Slot Black on White Large
<option class=option value=8>Style 8 - Gray on Black
<option class=option value=9>Style 9 - LED Large Red
<option class=option value=10>Style 10 - LED Large Green
<option class=option value=11>Style 11 - Slot White on Black Small
<option class=option value=12>Style 12 - Slot Black on White Small
<option class=option value=13>Style 13 - Black on White Small1
<option class=option value=14>Style 14 - Red on White
<option class=option value=15>Style 15 - Tiny Black on White
<option class=option value=16>Style 16 - Yellow on Black Digital
<option class=option value=17>Style 17 - Green on Black Digital
<option class=option value=18>Style 18 - Red on Black Digital
<option class=option value=19>Style 19 - Black on White Large
<option class=option value=20>Style 20 - Yellow on Blue
<option class=option value=21>Style 21 - Tiny Black on White Odometer
<option class=option value=22>Style 22 - Neon Green on Black
<option class=option value=23>Style 23 - 70's Alarm Clock
<option class=option value=24>Style 24 - White on Green
<option class=option value=25>Style 25 - Aqua on Navy
<option class=option value=26>Style 26 - Gold on White
<option class=option value=27>Style 27 - White on Black
<option class=option value=28>Style 28 - Black on White
<option class=option value=29>Style 29 - Free-Floating Black on White
<option class=option value=30>Style 30 - Tiny Green Digital
";






##### THE GREEN AND RED COLORS FOR THE GRAPH
##### THAT TURNS RED WHEN NEARING RECORD LIMIT OR PAGELOAD LIMIT
$colo5 = "#66ff66";
$colo6 = "#00aa00";
$colo55 = "#ff6666";
$colo66 = "#aa0000";




#### THIS LINE IS A FIX FOR THE LATEST VERSION OF PHP IN WHICH register_globals IS SET
#### TO OFF, WHICH THIS SCRIPT WAS WRITTEN BASED ON IT BEING SET TO ON.
	foreach($_REQUEST as $mykey => $myvalue) $GLOBALS[$mykey] = $myvalue;


include "includes/functions.php";
?>
