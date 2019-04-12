<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usr'])) {
  $loginUsername=$_POST['usr'];
  $password=$_POST['pwd'];

  $MM_fldUserAuthorization = "level";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login_user.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_koneksi, $koneksi);
  	
  $LoginRS__query=sprintf("SELECT username, pwd, level FROM `user` WHERE username=%s AND pwd=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Admin</title>
<style type="text/css">
<!--
body {
	background-color: #42413C;
	padding: 0;
	color: #000;
	margin-top: 200px;
	margin-right: 0;
	margin-bottom: 0;
	margin-left: 0;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 80%;
	line-height: 1.4;
}

/* ~~ Element/tag selectors ~~ */
ul, ol, dl { /* Due to variations between browsers, it's best practices to zero padding and margin on lists. For consistency, you can either specify the amounts you want here, or on the list items (LI, DT, DD) they contain. Remember that what you do here will cascade to the .nav list unless you write a more specific selector. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
	padding-right: 15px;
	padding-left: 15px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
}
a img { /* this selector removes the default blue border displayed in some browsers around an image when it is surrounded by a link */
	border: none;
}
/* ~~ Styling for your site's links must remain in this order - including the group of selectors that create the hover effect. ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* unless you style your links to look extremely unique, it's best to provide underlines for quick visual identification */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
	text-decoration: none;
}

/* ~~ this fixed width container surrounds the other divs ~~ */
.container {
	width: 400px;
	background-color: #FFF; /* the auto value on the sides, coupled with the width, centers the layout */
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 0;
	margin-left: auto;
}

/* ~~ the header is not given a width. It will extend the full width of your layout. It contains an image placeholder that should be replaced with your own linked logo ~~ */
.header {
	background: #097891;
	background: -moz-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #0b90ae), color-stop(100%, #07586b));
	background: -webkit-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -o-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -ms-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: linear-gradient(to bottom, #0b90ae 0%, #07586b 100%);
	height: 40px;
	font-family: "Courier New", Courier, monospace;
	font-weight: bold;
	text-transform: uppercase;
	color: #CCC;
	padding-top: 10px;
}

/* ~~ This is the layout information. ~~ 

1) Padding is only placed on the top and/or bottom of the div. The elements within this div have padding on their sides. This saves you from any "box model math". Keep in mind, if you add any side padding or border to the div itself, it will be added to the width you define to create the *total* width. You may also choose to remove the padding on the element in the div and place a second div within it with no width and the padding necessary for your design.

*/

.content {
	padding-top: 10px;
	padding-right: 10;
	padding-bottom: 10px;
	padding-left: 10;
}

/* ~~ The footer ~~ */
.footer {
	padding: 10px 0;
	background: #097891;
	background: -moz-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #0b90ae), color-stop(100%, #07586b));
	background: -webkit-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -o-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: -ms-linear-gradient(top, #0b90ae 0%, #07586b 100%);
	background: linear-gradient(to bottom, #0b90ae 0%, #07586b 100%);
	color:#CCC;
	font-weight:bold;
	text-align:center;
	
}

/* ~~ miscellaneous float/clear classes ~~ */
.fltrt {  /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page. The floated element must precede the element it should be next to on the page. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class can be placed on a <br /> or empty div as the final element following the last floated div (within the #container) if the #footer is removed or taken out of the #container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
</style></head>

<body>

<div class="container">
  <div class="header"><!-- end .header -->
    <div align="center">
      <h2>Login USER</h2>
    </div>
  </div>
  <div class="content">
    <form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
      <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td width="27%">Username</td>
          <td width="3%">:</td>
          <td width="70%"><label for="usr"></label>
          <input type="text" name="usr" id="usr" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td><label for="pwd"></label>
          <input type="password" name="pwd" id="pwd" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" name="login" id="login" value="Login" /></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="footer">    <!-- end .footer -->Copyright@DesiCaprina_2014</div>
  <!-- end .container --></div>
</body>
</html>