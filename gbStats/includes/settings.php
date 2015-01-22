<?php
echo "\n\n";
echo "<table class=options>\n";

########################################################
### ONLY SHOW USERNAME FIELD IF THIS IS A SIGNUP, NOT AN EDIT
### OF ACCOUNT SETTINGS

if (!$noshowsettings) 
  echo "
	<tr>
		<td align=right class=options>Username:</td>
		<td class=options><input class=textinput type=text name=username maxlength=15 value='$username'>&nbsp;<font class=error_font>*</font></td>
	</tr>
\n\n";

########################################################
### SHOW SOME MORE FIELDS GENERIC TO BOTH SIGNUP AND EDIT PAGES

echo "
	<tr>
		<td align=right class=options>Email:</td>
		<td class=options><input class=textinput type=text name=email maxlength=75 value='$email'>&nbsp;<font class=error_font>*</font></td>
	</tr>

	<tr><td align=right class=options colspan=2><hr></td></tr>

	<tr>
		<td align=right class=options>First Name:</td>
		<td class=options><input class=textinput type=text name=first_name maxlength=30 value='$first_name'>&nbsp;<font class=error_font>*</font></td>
	</tr>

	<tr>
		<td align=right class=options>Last Name:</td>
		<td class=options><input class=textinput type=text name=last_name maxlength=30 value='$last_name'>&nbsp;<font class=error_font>*</font></td>
	</tr>

\n\n";

echo "
	<tr><td align=right class=options colspan=2><hr></td></tr>

	<tr>
		<td align=right class=options>Web Site URL:</td>
		<td class=options><input class=textinput type=text name=url maxlength=150 value='$url'>&nbsp;<font class=error_font>*</font></td>
	</tr>
	<tr>
		<td align=right class=options>Web Site Title:</td>
		<td class=options><input class=textinput type=text name=title maxlength=45 value='$title'>&nbsp;<font class=error_font>*</font></td>
	</tr>

\n\n";

########################################################
### SHOW THE OTHER OPTIONS

if (!$id) $showsite_checked = " checked";
echo "
	<tr>
		<td class=options> </td>
		<td class=options><input class=button type=submit value=Submit><p>&nbsp;<font class=error_font>*</font>&nbsp;Required&nbsp;Field</td>
	</tr>
</table>
\n\n";




########################################################
### ONE LAST JAVASCRIPT, SETS THE HIDDEN FIELD countertype TO
### WHATEVER VALUE IT SHOULD BE WHEN PAGE LOADS
  if (!$counter_style) $counter_style = "0";
  echo "<script language=javascript>\n";
  if ($countertype < "31") echo "document.ss.countertype.value = '$countertype';\n";
  else if ($countertype > "69") echo "document.ss.countertypesss.value = '$countertype';\n";
  else echo "document.ss.countertyperrr.value = '$countertype';\n";
  echo "</script>\n\n";  


?>