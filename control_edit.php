<?php include "header.php"; ?>
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
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE user SET nama=%s, `level`=%s, rayon=%s, username=%s, pwd=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['control'], "text"),
                       GetSQLValueString($_POST['rayon'], "text"),
                       GetSQLValueString($_POST['usr'], "text"),
                       GetSQLValueString($_POST['pwd'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "daftar_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_user = "-1";
if (isset($_GET['id'])) {
  $colname_edit_user = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_user = sprintf("SELECT * FROM `user` WHERE id = %s", GetSQLValueString($colname_edit_user, "int"));
$edit_user = mysql_query($query_edit_user, $koneksi) or die(mysql_error());
$row_edit_user = mysql_fetch_assoc($edit_user);
$totalRows_edit_user = mysql_num_rows($edit_user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="352" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td colspan="3" align="center"><h2><strong>Control User</strong></h2></td>
    </tr>
    <tr>
      <td width="109"><strong>Nama</strong></td>
      <td width="28" align="center"><strong>:</strong></td>
      <td width="185"><strong>
      <input name="nama" type="text" required="required" id="nama" placeholder="Nama" value="<?php echo $row_edit_user['nama']; ?>" />
      </strong></td>
    </tr>
    <tr>
      <td><strong>Level</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><label for="control"></label>
      <input name="control" type="text" id="control" value="control_user" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><strong>Rayon</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input name="rayon" type="text" required="required" id="rayon" placeholder="Rayon" value="<?php echo $row_edit_user['rayon']; ?>"/>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Username</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input name="usr" type="text" required="required" id="usr" placeholder="Username" value="<?php echo $row_edit_user['username']; ?>"/>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Password</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input name="pwd" type="text" required="required" id="pwd"  placeholder="Password" value="<?php echo $row_edit_user['pwd']; ?>"/>
      </strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Simpan" /></td>
    </tr>
  </table>
  <input name="id" type="hidden" id="id" value="<?php echo $row_edit_user['id']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($edit_user);
?>
<?php include "footer.php"; ?>