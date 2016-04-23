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

$maxRows_cari = 10;
$pageNum_cari = 0;
if (isset($_GET['pageNum_cari'])) {
  $pageNum_cari = $_GET['pageNum_cari'];
}
$startRow_cari = $pageNum_cari * $maxRows_cari;
$i=$startRow_cari+1;
$colname_cari = "-1";
if (isset($_POST['cari'])) {
  $colname_cari = $_POST['cari'];

mysql_select_db($database_koneksi, $koneksi);
$query_cari = sprintf("SELECT * FROM perpanjangan_pesta WHERE no_reg LIKE %s ORDER BY tgl_perpanjangan DESC", GetSQLValueString("%" . $colname_cari . "%", "text"));
$query_limit_cari = sprintf("%s LIMIT %d, %d", $query_cari, $startRow_cari, $maxRows_cari);
$cari = mysql_query($query_limit_cari, $koneksi) or die(mysql_error());
$row_cari = mysql_fetch_assoc($cari);
}
else
{
mysql_select_db($database_koneksi, $koneksi);
//untuk menampilkan seluruh tabel
$query_cari = sprintf("SELECT * FROM perpanjangan_pesta ORDER BY id DESC");
$query_limit_cari = sprintf("%s LIMIT %d, %d", $query_cari, $startRow_cari, $maxRows_cari);
$cari = mysql_query($query_limit_cari, $koneksi) or die(mysql_error());
$row_cari = mysql_fetch_assoc($cari);
}
if (isset($_GET['totalRows_cari'])) {
  $totalRows_cari = $_GET['totalRows_cari'];
} else {
  $all_cari = mysql_query($query_cari);
  $totalRows_cari = mysql_num_rows($all_cari);
}
$totalPages_cari = ceil($totalRows_cari/$maxRows_cari)-1;

$queryString_cari = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cari") == false && 
        stristr($param, "totalRows_cari") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cari = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cari = sprintf("&totalRows_cari=%d%s", $totalRows_cari, $queryString_cari);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Layanan Pesta</title>
</head>

<body>
<h2><strong>Daftar Layanan Perpanjangan
</strong></h2>
<form id="form1" name="form1" method="post" action="">
Masukkan Id/no_reg
  <label for="cari"></label>
  <input type="text" name="cari" id="cari" />
  <input type="submit" name="Submit" id="Submit" value="Search" />
</form>
<p><strong></strong></p>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="right">
        <a href="cetak_perpanjangan.php">
        <input type="submit" name="cetak" id="cetak" value="Eksport Laporan Excel" /></a></td>
    </tr>
  </table>
<?php if ($totalRows_cari > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center" bgcolor="#D5ECF7"><strong>No</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>No Registrasi</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Nyala</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Berhenti</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Tanggal Perpanjangan</strong></td>
      <td align="center" bgcolor="#D5ECF7"><strong>Status</strong></td>
      <td align="center" bgcolor="#D5ECF7">&nbsp;</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td align="right"><?php echo $row_cari['no_reg']; ?></td>
        <td align="right"><?php echo $row_cari['tgl_nyala']; ?></td>
        <td align="right"><?php echo $row_cari['tgl_berhenti']; ?></td>
        <td align="right"><?php echo $row_cari['tgl_perpanjangan']; ?></td>
        
        <td>Perpanjangan Ke-<?php echo $row_cari['status']; ?>
        </td>
        <td><a href="del_ppj.php?id=<?php echo $row_cari['id']; ?>" 
      onclick="return confirm('hapus data  <?php echo $row_cari['id']; ?>?')">Delete</a></td>
        
      </tr>
      <?php } while ($row_cari = mysql_fetch_assoc($cari)); ?>
  </table>
  
<p>&nbsp;
<table border="0">
  <tr>
    <td><?php if ($pageNum_cari > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cari=%d%s", $currentPage, 0, $queryString_cari); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cari > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cari=%d%s", $currentPage, max(0, $pageNum_cari - 1), $queryString_cari); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cari < $totalPages_cari) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cari=%d%s", $currentPage, min($totalPages_cari, $pageNum_cari + 1), $queryString_cari); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_cari < $totalPages_cari) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cari=%d%s", $currentPage, $totalPages_cari, $queryString_cari); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
</p>


<?php if ($totalRows_cari == 0) { // Show if recordset empty ?>
  <p>Data Tidak Ada!</p>
  <?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysql_free_result($cari);
?>
<?php include("footer.php");?>
