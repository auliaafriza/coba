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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_pemohon = 10;
$pageNum_pemohon = 0;
if (isset($_GET['pageNum_pemohon'])) {
  $pageNum_pemohon = $_GET['pageNum_pemohon'];
}
$startRow_pemohon = $pageNum_pemohon * $maxRows_pemohon;
$i=$startRow_pemohon+1;
$colname_pemohon = "-1";
if (isset($_POST['cari'])) {
  $colname_pemohon = $_POST['cari'];

mysql_select_db($database_koneksi, $koneksi);
$query_pemohon = sprintf("SELECT * FROM pemohon_pesta WHERE nama_pemohon LIKE %s or no_reg LIKE %s ORDER BY tgl_daftar DESC", GetSQLValueString("%" . $colname_pemohon . "%", "text"), GetSQLValueString("" . $colname_pemohon . "", "text"));
$query_limit_pemohon = sprintf("%s LIMIT %d, %d", $query_pemohon, $startRow_pemohon, $maxRows_pemohon);
$pemohon = mysql_query($query_limit_pemohon, $koneksi) or die(mysql_error());
$row_pemohon = mysql_fetch_assoc($pemohon);
}
else
{
mysql_select_db($database_koneksi, $koneksi);
$query_pemohon = sprintf("SELECT * FROM pemohon_pesta ORDER BY tgl_daftar DESC");
$query_limit_pemohon = sprintf("%s LIMIT %d, %d", $query_pemohon, $startRow_pemohon, $maxRows_pemohon);
$pemohon = mysql_query($query_limit_pemohon, $koneksi) or die(mysql_error());
$row_pemohon = mysql_fetch_assoc($pemohon);
	
}
if (isset($_GET['totalRows_pemohon'])) {
  $totalRows_pemohon = $_GET['totalRows_pemohon'];
} else {
  $all_pemohon = mysql_query($query_pemohon);
  $totalRows_pemohon = mysql_num_rows($all_pemohon);
}
$totalPages_pemohon = ceil($totalRows_pemohon/$maxRows_pemohon)-1;

$queryString_pemohon = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pemohon") == false && 
        stristr($param, "totalRows_pemohon") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pemohon = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pemohon = sprintf("&totalRows_pemohon=%d%s", $totalRows_pemohon, $queryString_pemohon);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Layanan Pesta</title>
</head>

<body>
<h2>Daftar Layanan Permohonan Pesta
</h2>
<form id="form1" name="form1" method="post" action="">
Masukkan Nomor Registrasi / Nama
  <label for="cari"></label>
  <input type="text" name="cari" id="cari" />
  <input type="submit" name="cr" id="cr" value="cari" />
</form>
<p>&nbsp;</p>
<?php if ($totalRows_pemohon > 0) { // Show if recordset not empty ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="right">
        <a href="cetak_layanan.php">
        <input type="submit" name="cetak" id="cetak" value="Eksport Laporan Excel" /></a></td>
    </tr>
  </table>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr style="color:#000">
      <td align="center" bgcolor="#D5ECF7"><strong>No</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nama Pemohon</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Alamat</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Daya</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nilai<br />
Awal</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nilai<br />
Akhir</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nilai<br />
Satuan</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nomor HP</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>X</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Y</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nomor Alat</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Nyala</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Berhenti</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Nomor Registrasi</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Daftar</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Edit</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Delete</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td height="31"><?php echo $i++; ?></td>
        <td><?php echo $row_pemohon['nama_pemohon']; ?></td>
        <td><?php echo $row_pemohon['alamat']; ?></td>
        <td align="right"><?php echo $row_pemohon['daya']; ?></td>
        <td align="right"><?php echo $row_pemohon['p_awal']; ?></td>
        <td align="right"><?php echo $row_pemohon['p_akhir']; ?></td>
        <td align="right"><?php echo $row_pemohon['p_satuan']; ?></td>
        <td><?php echo $row_pemohon['no_hp']; ?></td>
        <td align="right"><?php echo $row_pemohon['k_x']; ?></td>
        <td align="right"><?php echo $row_pemohon['k_y']; ?></td>
        <td align="right"><?php echo $row_pemohon['no_alat']; ?></td>
        <td align="right"><?php echo $row_pemohon['tgl_nyala']; ?></td>
        <td align="right"><?php echo $row_pemohon['tgl_berhenti']; ?></td>
        <td align="right"><?php echo $row_pemohon['no_reg']; ?></td>
        <td align="right"><?php echo $row_pemohon['tgl_daftar']; ?></td>
        <td align="center"><a href="edit.php?no_reg=<?php echo $row_pemohon['no_reg']; ?>">Edit</a></td>
        <td align="center"><a href="delete.php?no_reg=<?php echo $row_pemohon['no_reg']; ?>"onclick="return confirm('hapus data  <?php echo $row_pemohon['no_reg']; ?>?')">Delete</a></td>
      </tr>
      <?php } while ($row_pemohon = mysql_fetch_assoc($pemohon)); ?>
  </table>
  

<table border="0">
  <tr>
    <td><?php if ($pageNum_pemohon > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pemohon=%d%s", $currentPage, 0, $queryString_pemohon); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pemohon > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pemohon=%d%s", $currentPage, max(0, $pageNum_pemohon - 1), $queryString_pemohon); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pemohon < $totalPages_pemohon) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pemohon=%d%s", $currentPage, min($totalPages_pemohon, $pageNum_pemohon + 1), $queryString_pemohon); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_pemohon < $totalPages_pemohon) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pemohon=%d%s", $currentPage, $totalPages_pemohon, $queryString_pemohon); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
<?php if ($totalRows_pemohon == 0) { // Show if recordset empty ?>
  <p>Data Tidak Ada!</p>
  <?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($pemohon);
?>
<?php include("footer.php");?>