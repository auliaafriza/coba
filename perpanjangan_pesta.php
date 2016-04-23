<?php include("header.php"); ?>
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

$maxRows_cari = 10;
$pageNum_cari = 0;
if (isset($_GET['pageNum_cari'])) {
  $pageNum_cari = $_GET['pageNum_cari'];
}
$startRow_cari = $pageNum_cari * $maxRows_cari;

$colname_cari = "-1";
if (isset($_POST['cari'])) {
  $colname_cari = $_POST['cari'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_cari = sprintf("SELECT * FROM pemohon_pesta WHERE nama_pemohon LIKE %s or alamat LIKE %s", GetSQLValueString("%" . $colname_cari . "%", "text"), GetSQLValueString("%" . $colname_cari . "%", "text"));
$query_limit_cari = sprintf("%s LIMIT %d, %d", $query_cari, $startRow_cari, $maxRows_cari);
$cari = mysql_query($query_limit_cari, $koneksi) or die(mysql_error());
$row_cari = mysql_fetch_assoc($cari);

if (isset($_GET['totalRows_cari'])) {
  $totalRows_cari = $_GET['totalRows_cari'];
} else {
  $all_cari = mysql_query($query_cari);
  $totalRows_cari = mysql_num_rows($all_cari);
}
$totalPages_cari = ceil($totalRows_cari/$maxRows_cari)-1;
?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<h2><strong>Perpanjangan Layanan Pesta</strong></h2>
<form id="form1" name="form1" method="post" action="">
  <label for="cari"></label>
  <span id="sprytextfield1">
  <input type="text" name="cari" id="cari" />
  <span class="textfieldRequiredMsg"></span></span>
  <input type="submit" name="cr" id="cr" value="Search" />
</form>
<?php
mysql_free_result($cari);
?>
<?php if ($totalRows_cari > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
      <td width="265" bgcolor="#D5ECF7"><strong>Nama Pemohon</strong></td>
      <td width="159" bgcolor="#D5ECF7"><strong>Alamat</strong></td>
      <td width="185" bgcolor="#D5ECF7"><strong>Tanggal Nyala</strong></td>
      <td width="319" bgcolor="#D5ECF7"><strong>Tanggal Berhenti</strong></td>
      <td width="214" bgcolor="#D5ECF7"><strong>Konfirmasi Perpanjangan</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_cari['nama_pemohon']; ?></td>
        <td><?php echo $row_cari['alamat']; ?></td>
        <td><?php echo $row_cari['tgl_nyala']; ?></td>
        <td><?php echo $row_cari['tgl_berhenti']; ?></td>
        <td align="center"><a href="input_perpanjangan.php?no_reg=<?php echo $row_cari['no_reg']; ?>">Konfirmasi Perpanjangan</a></td>
      </tr>
      <?php } while ($row_cari = mysql_fetch_assoc($cari)); ?>
  </table>
  <?php } // Show if recordset not empty ?>

<?php include("footer.php");?>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], hint:"Ketikan Nama / Alamat"});
</script>
