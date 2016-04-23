<?php error_reporting(0); ?>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=daftar_pencabutan_pesta.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");
//disini script laporan anda
?>
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
$query_laporan_pencabutan = "SELECT * FROM pencabutan_pesta ORDER BY tgl_pencabutan DESC";
$laporan_pencabutan = mysql_query($query_laporan_pencabutan, $koneksi) or die(mysql_error());
$row_laporan_pencabutan = mysql_fetch_assoc($laporan_pencabutan);
$totalRows_laporan_pencabutan = mysql_num_rows($laporan_pencabutan);
$i=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Pencabutan</title>
</head>

<body>
<h2 align="center">Laporan Data Pencabutan Layanan Pesta</h2>
<p>&nbsp;</p>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr style="background-color:#D5ECF7; color:#333; text-align:center; font-weight:bold;">
    <td align="left"><strong>No</strong></td>
    <td align="left"><strong>No_Reg</strong></td>
    <td align="left"><strong>Tanggal_Pencabutan</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row_laporan_pencabutan['no_reg']; ?></td>
      <td><?php echo $row_laporan_pencabutan['tgl_pencabutan']; ?></td>
    </tr>
    <?php } while ($row_laporan_pencabutan = mysql_fetch_assoc($laporan_pencabutan)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($laporan_pencabutan);
?>
