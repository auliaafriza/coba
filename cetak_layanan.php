<?php error_reporting(0); ?>
<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=daftar_layanan_pesta.xls");//ganti nama sesuai keperluan
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
$query_Recordset1 = "SELECT * FROM pemohon_pesta ORDER BY tgl_daftar DESC";
$Recordset1 = mysql_query($query_Recordset1, $koneksi) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Layanan Pesta</title>
</head>

<body>
<h2 align="center">Laporan Data Layanan Pesta</h2>

<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr style="background-color:#D5ECF7; color:#333; text-align:center; font-weight:bold;">
    <td valign="middle">Nama_Pemohon</td>
    <td valign="middle">Alamat</td>
    <td valign="middle">Daya</td>
    <td valign="middle">P_Awal</td>
    <td valign="middle">P_Akhir</td>
    <td valign="middle">P_Satuan</td>
    <td valign="middle">No_HP</td>
    <td valign="middle">K_X</td>
    <td valign="middle">K_Y</td>
    <td valign="middle">No_Alat</td>
    <td valign="middle">Tanggal_Nyala</td>
    <td valign="middle">Tanggal_Berhenti</td>
    <td valign="middle">No_Reg</td>
    <td valign="middle">Tanggal_Daftar</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['nama_pemohon']; ?></td>
      <td><?php echo $row_Recordset1['alamat']; ?></td>
      <td><?php echo $row_Recordset1['daya']; ?></td>
      <td><?php echo $row_Recordset1['p_awal']; ?></td>
      <td><?php echo $row_Recordset1['p_akhir']; ?></td>
      <td><?php echo $row_Recordset1['p_satuan']; ?></td>
      <td><?php echo $row_Recordset1['no_hp']; ?></td>
      <td><?php echo $row_Recordset1['k_x']; ?></td>
      <td><?php echo $row_Recordset1['k_y']; ?></td>
      <td><?php echo $row_Recordset1['no_alat']; ?></td>
      <td><?php echo $row_Recordset1['tgl_nyala']; ?></td>
      <td><?php echo $row_Recordset1['tgl_berhenti']; ?></td>
      <td><?php echo $row_Recordset1['no_reg']; ?></td>
      <td><?php echo $row_Recordset1['tgl_daftar']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
