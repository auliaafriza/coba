<?php include("header.php");?>
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
  $updateSQL = sprintf("UPDATE pencabutan_pesta SET no_reg=%s, tgl_pencabutan=%s WHERE id=%s",
                       GetSQLValueString($_POST['no_reg'], "text"),
                       GetSQLValueString($_POST['tgl_pencabutan'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "daftar_pencabutan2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit = "-1";
if (isset($_GET['id'])) {
  $colname_edit = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit = sprintf("SELECT * FROM pencabutan_pesta WHERE id = %s ORDER BY no_reg DESC", GetSQLValueString($colname_edit, "int"));
$edit = mysql_query($query_edit, $koneksi) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Pencabutan</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left"><strong>ID</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><?php echo $row_edit['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left"><strong>No_Reg</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><input type="text" name="no_reg" value="<?php echo htmlentities($row_edit['no_reg'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left"><strong>Tanggal_Pencabutan</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><input type="date" name="tgl_pencabutan" value="<?php echo htmlentities($row_edit['tgl_pencabutan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" id="Submit" value="SIMPAN" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_edit['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit);
?>
<?php include("footer.php");?>