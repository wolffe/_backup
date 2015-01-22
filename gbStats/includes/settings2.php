<?php


########################################################
### THIS FILE DISPLAYS THE FORM USED FOR SIGNING UP, AND
### THE FORM USED IN EDITING ACCOUNT SETTINGS, WHICH ARE
### ALMOST IDENTICAL TO EACH OTHER.

### I RECOMMEND NOT EDITING THIS FILE OTHER THAN CHANGING WORDING,
### IT IS EASY TO SCREW UP IF YOU DON"T KNOW WHAT YOU ARE DOING.


echo "\n\n";
echo "<table class=options>\n";




echo "
	<tr>
		<td class=options align=right valign=top>Campaign Title:</td>
		<td class=options><input class=textinput type=text name=title value=\"$n->title\"></td>
	</tr>
	<tr>
		<td class=options align=right valign=top>Visible Counter Value:</td>
		<td class=options><input class=textinput type=text name=countdisplay value=\"$n->countdisplay\"></td>
	</tr>
	<tr>
		<td class=options align=right valign=top>Display Type:</td>
		<td class=options><select class=select name=displaytype value=\"$n->displaytype\">
		<option value=h>Pageloads</option>
		<option value=v>Unique Visitors</option>
		</td>
	</tr>
	<tr>
		<td class=options align=right valign=top>Do Not Count IPs:<p><i>(Seperated By Comma)<p>You Are ".$_SERVER['REMOTE_ADDR']."</i></td>
		<td class=options><textarea class=textareasmall rows=5 cols=45 name=block>$n->block</textarea></td>
	</tr>

";




########################################################
### SHOW COUNTER STYLE FIELD AND APPROPRIATE JAVASCRIPTS

echo "
	<tr>
		<td class=options valign=top align=right>Campaign Counter Style:</td>
		<td class=options valign=top>

		<table cellpadding=0>
			<tr>
				<td>


<script language=JavaScript>
<!--
function displayStyle(source) {
var zero = \"images/digits/digits0/0.gif\";
var imageURL1 = \"images/digits/digits\" + source + \"/1.gif\";
var imageURL2 = \"images/digits/digits\" + source + \"/2.gif\";
var imageURL3 = \"images/digits/digits\" + source + \"/3.gif\";
if (document.images) {
  document.images.preview1.src = imageURL1;
  document.images.preview2.src = imageURL2;
  document.images.preview3.src = imageURL3;
  document.ss.countertype.value = source; }
else {
  document.images.preview1.src = zero;
  document.images.preview2.src = zero;
  document.images.preview3.src = zero; } }
//-->
</script>



<input type=hidden name=countertype>
<select class=selectlarge name=countertypeqqq onchange='displayStyle(this.value)'>
$counter_display_options;


</select><br>

				</td>
			</tr>
			<tr>
				<td height=50 valign=top align=left><br><font size=1>Style Preview:<p><img name=preview1 src=images/digits/digits0/0.gif alt='1' border=0><img name=preview2 src=images/digits/digits0/0.gif alt='2' border=0><img name=preview3 src=images/digits/digits0/0.gif alt='3' border=0></font></td>
			</tr>
		</table>
		</td>
	</tr>

	<tr><td align=right class=options colspan=2><hr></td></tr>
\n\n";




########################################################
### SHOW THE SUBMIT BUTTON

echo "
	<tr>
		<td class=options> </td>
		<td class=options><input class=button type=submit value=Submit><p></td>
	</tr>
</table>
\n\n";





if ($noshowsettings) {

echo "

<script language=javascript>
document.ss.countertypeqqq.value='$n->countertype';
</script>

";

}

?>