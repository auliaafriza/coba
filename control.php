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


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user (nama, `level`, rayon, username, pwd) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['control'], "text"),
                       GetSQLValueString($_POST['rayon'], "text"),
                       GetSQLValueString($_POST['usr'], "text"),
                       GetSQLValueString($_POST['pwd'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "daftar_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
      <input type="text" name="nama" id="nama" placeholder="Nama" required="required" />
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
      <input type="text" name="rayon" id="rayon" placeholder="Rayon" required="required"/>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Username</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input type="text" name="usr" id="usr" placeholder="Username" required="required"/>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Password</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input type="text" name="pwd" id="pwd"  placeholder="Password" required="required"/>
      </strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php include "footer.php"; ?>