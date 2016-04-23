<?php error_reporting(0); ?>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=daftar_perpanjangan_pesta.xls");//ganti nama sesuai keperluan
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
$query_laporan_perpanjangan = "SELECT * FROM perpanjangan_pesta ORDER BY tgl_perpanjangan DESC";
$laporan_perpanjangan = mysql_query($query_laporan_perpanjangan, $koneksi) or die(mysql_error());
$row_laporan_perpanjangan = mysql_fetch_assoc($laporan_perpanjangan);
$totalRows_laporan_perpanjangan = mysql_num_rows($laporan_perpanjangan);
$i=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Perpanjangan</title>
</head>

<body>
<h2 align="center">Laporan Data Perpanjangan Pesta</h2>
<p>&nbsp;</p>
<table width="100%" border="1" cellpadding="10" cellspacing="0">
  <tr style="background-color:#D5ECF7; color:#333; text-align:center; font-weight:bold;">
  
    <td align="left"><strong>NO</strong></td>
    <td align="left"><strong>No_Reg</strong></td>
    <td align="left"><strong>Tanggal_Nyala</strong></td>
    <td align="left"><strong>Tanggal_Berhenti</strong></td>
    <td align="left"><strong>Tanggal_Perpanjangan</strong></td>
    <td align="left"><strong>Status</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row_laporan_perpanjangan['no_reg']; ?></td>
      <td><?php echo $row_laporan_perpanjangan['tgl_nyala']; ?></td>
      <td><?php echo $row_laporan_perpanjangan['tgl_berhenti']; ?></td>
      <td><?php echo $row_laporan_perpanjangan['tgl_perpanjangan']; ?></td>
      <td><?php echo "Perpanjangan ke-$row_laporan_perpanjangan[status]" ?></td>
    </tr>
    <?php } while ($row_laporan_perpanjangan = mysql_fetch_assoc($laporan_perpanjangan)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($laporan_perpanjangan);
?>
