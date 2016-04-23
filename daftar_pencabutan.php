<?php include("header.php");?>
<h2>
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

mysql_select_db($database_koneksi, $koneksi);
$query_pencabutan = "SELECT * FROM pencabutan_pesta";
$pencabutan = mysql_query($query_pencabutan, $koneksi) or die(mysql_error());
$row_pencabutan = mysql_fetch_assoc($pencabutan);
$totalRows_pencabutan = mysql_num_rows($pencabutan);
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <strong>
  <head>
  </strong>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Layanan Pencabutan Pesta</title>
  </head>
  
  <body>
<h2><strong>Daftar Pencabutan Layanan Pesta </strong></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td width="137" align="left" bgcolor="#D5ECF7"><strong>No_reg</strong></td>
    <td width="183" align="left" bgcolor="#D5ECF7"><strong>Tanggal_pencabutan</strong></td>
  </tr>
  <tr>
    <td><?php echo $row_pencabutan['no_reg']; ?></td>
    <td><?php echo $row_pencabutan['tgl_pencabutan']; ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($pencabutan);
?>
<?php include("footer.php"); ?>