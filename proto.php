<?php require_once('Connections/koneksi.php'); ?>
<?php error_reporting(0); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login_user.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login_user.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
  return $theValue;
}
}

mysql_select_db($database_koneksi, $koneksi);
$query_controluser = "SELECT * FROM `user`";
$controluser = mysql_query($query_controluser, $koneksi) or die(mysql_error());
$row_controluser = mysql_fetch_assoc($controluser);
$totalRows_controluser = mysql_num_rows($controluser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aplikasi Layanan Pesta</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='menu_source/styles.css' />
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script type='text/javascript' src='menu_source/menu_jquery.js'></script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="container">
  <div class="header"><!-- end .header --></div>
  <div class="header_menu">
  <div id='cssmenu'>
<ul>
  
   <li class='has-sub'><a href='#'><span>Permohonan Layanan Pesta</span></a>
      <ul>
      <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
         <li class='last'><a href='input_permohonan.php'><span>Permohonan Registration</span></a></li>
         
         <li class='last'><a href='daftar_layanan.php'><span>Daftar Layanan Permohonan Pesta</span></a></li>
         <?php } ?>
         
         <?php if($_SESSION['MM_UserGroup']=="control_user") { ?>
         <li class='last'><a href='daftar_layanan2.php'><span>Daftar Layanan Permohonan Pesta</span></a></li>
        <?php } ?>
      </ul>
   </li>

   <li class='has-sub'><a href='#'><span>Perpanjangan Layanan Pesta</span></a>
      <ul>
      
      <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
         <li class='last'><a href='perpanjangan_pesta.php'><span>Perpanjangan Layanan Pesta</span></a></li>
         
         
         <li class='last'><a href='daftar_perpanjangan.php'><span>Daftar Perpanjangan  Layanan Pesta</span></a></li>
         <?php } ?>
       <?php if($_SESSION['MM_UserGroup']=="control_user") { ?>
       <li class='last'><a href='daftar_perpanjangan2.php'><span>Daftar Perpanjangan  Layanan Pesta</span></a></li>
       <?php } ?>
      </ul>
   </li>

   <li class='has-sub'><a href='#'><span>Pencabutan Layanan Pesta</span></a>
      <ul>
      
       <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
         <li class='last'><a href='input_pencabutan.php'><span>Pencabutan Layanan</span></a></li>
         
         
         <li class='last'><a href='daftar_pencabutan.php'<span>Daftar Data Pencabutan</span></a></li>
         <?php } ?>
         <?php if($_SESSION['MM_UserGroup']=="control_user") { ?>
          <li class='last'><a href='daftar_pencabutan2.php'<span>Daftar Data Pencabutan</span></a></li><?php } ?>
         </ul>
         
   </li>
   
   
      <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
      <li class='has-sub'><a href='#'><span>Control User</span></a>
      <ul>

   
   <li><a href='control.php'><span>Input Control User</span></a></li>
   <li><a href='daftar_user.php'><span>Daftar Control User</span></a></li>
   <?php } ?>
   <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
   <li><a href="edit_user.php?id=<?php echo $row_controluser['id']; ?>"><span>Edit Control User</span></a></li>
   <?php } ?>
</ul>
</li>
  
 <li class='last'>  <a href="<?php echo $logoutAction ?>"><span>Log out</span></a></li>
</ul>
</div>
  </div>
<div class="content">

  <!-- end .content -->
  </div>
  <div class="footer">
    <h2>Copyright@Mahasiswa Unsri 2014</h2>
    <!-- end .footer --></div>
<!-- end .container --></div>
</body>
</html>
<?php
mysql_free_result($controluser);
?>
