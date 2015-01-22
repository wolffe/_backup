<?php

### LOGOUT PAGE.

  $null="0";
  require("config.php");
  setcookie("twuser",$null);
  setcookie("twpass",$null);


?>


<html>
<head>
<title>Logging Out</title>
<META HTTP-EQUIV=Pragma CONTENT=no-cache> 
</head>
<body><br>Logging you out...<p>BuhBye...
<form name=return action=members.php method=get></form>
<script language=javascript>
document.forms[0].submit();
</script>
</body></html>