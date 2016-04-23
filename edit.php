<?php include ("header.php"); ?>
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
  $updateSQL = sprintf("UPDATE pemohon_pesta SET nama_pemohon=%s, alamat=%s, daya=%s, p_awal=%s, p_akhir=%s, p_satuan=%s, no_hp=%s, k_x=%s, k_y=%s, no_alat=%s, tgl_nyala=%s, tgl_berhenti=%s WHERE no_reg=%s",
                       GetSQLValueString($_POST['nm'], "text"),
                       GetSQLValueString($_POST['alm'], "text"),
                       GetSQLValueString($_POST['daya'], "text"),
                       GetSQLValueString($_POST['p1'], "text"),
                       GetSQLValueString($_POST['p2'], "text"),
                       GetSQLValueString($_POST['p3'], "text"),
                       GetSQLValueString($_POST['hp'], "text"),
                       GetSQLValueString($_POST['x'], "text"),
                       GetSQLValueString($_POST['y'], "text"),
                       GetSQLValueString($_POST['alat'], "text"),
                       GetSQLValueString($_POST['tgl'], "date"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['rgs'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "daftar_layanan2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit = "-1";
if (isset($_GET['no_reg'])) {
  $colname_edit = $_GET['no_reg'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit = sprintf("SELECT * FROM pemohon_pesta WHERE no_reg = %s", GetSQLValueString($colname_edit, "text"));
$edit = mysql_query($query_edit, $koneksi) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2><strong>Input Data Permohonan Layanan Pesta
</strong></h2>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="1096" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="131" valign="top">Nama Pemohon</td>
      <td width="20" align="center" valign="top">:</td>
      <td width="923" valign="top"><span id="sprytextfield1">
        <label for="nm"></label>
        <input name="nm" type="text" id="nm" value="<?php echo $row_edit['nama_pemohon']; ?>" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong</span></span></td>
    </tr>
    <tr>
      <td valign="top">Alamat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextarea1">
        <label for="alm"></label>
        <textarea name="alm" id="alm" cols="45" rows="5"><?php echo $row_edit['alamat']; ?></textarea>
      <span class="textareaRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Daya</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield2">
        <label for="daya"></label>
        <input name="daya" type="text" id="daya" value="<?php echo $row_edit['daya']; ?>" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Pembatas</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="spryselect1">
        <label for="p1"></label>
        <select name="p1" id="p1">
          <option value="" <?php if (!(strcmp("", $row_edit['p_awal']))) {echo "selected=\"selected\"";} ?>>Pilih</option>
          <option value="1" <?php if (!(strcmp(1, $row_edit['p_awal']))) {echo "selected=\"selected\"";} ?>>1</option>
          <option value="2" <?php if (!(strcmp(2, $row_edit['p_awal']))) {echo "selected=\"selected\"";} ?>>2</option>
          <option value="3" <?php if (!(strcmp(3, $row_edit['p_awal']))) {echo "selected=\"selected\"";} ?>>3</option>
        </select>
      <span class="selectRequiredMsg">Silahkan Dipilh!</span></span><span id="spryselect2">
      <label for="p2"></label>
      <select name="p2" id="p2">
        <option value="" <?php if (!(strcmp("", $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>Pilih</option>
        <option value="1" <?php if (!(strcmp(1, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>7</option>
        <option value="8" <?php if (!(strcmp(8, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>8</option>
        <option value="9" <?php if (!(strcmp(9, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>9</option>
        <option value="10" <?php if (!(strcmp(10, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>10</option>
        <option value="11" <?php if (!(strcmp(11, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>11</option>
        <option value="12" <?php if (!(strcmp(12, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>12</option>
        <option value="13" <?php if (!(strcmp(13, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>13</option>
        <option value="14" <?php if (!(strcmp(14, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>14</option>
        <option value="15" <?php if (!(strcmp(15, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>15</option>
        <option value="16" <?php if (!(strcmp(16, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>16</option>
        <option value="17" <?php if (!(strcmp(17, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>17</option>
        <option value="18" <?php if (!(strcmp(18, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>18</option>
        <option value="19" <?php if (!(strcmp(19, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>19</option>
        <option value="20" <?php if (!(strcmp(20, $row_edit['p_akhir']))) {echo "selected=\"selected\"";} ?>>20</option>
      </select>
      <span class="selectRequiredMsg">Silahkan Dipilih!</span></span>
      <label for="p3"></label>
      <input name="p3" type="text" id="p3" value="A" size="5" readonly="readonly" /></td>
    </tr>
    <tr>
      <td valign="top">No HP</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield3">
        <label for="hp"></label>
        <input name="hp" type="text" id="hp" value="<?php echo $row_edit['no_hp']; ?>" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Titik Koordinat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield4">
        <label for="x"></label>
        <input name="x" type="text" id="x" value="<?php echo $row_edit['k_x']; ?>" size="5" />
      <span class="textfieldRequiredMsg">Silahkan Dipilih!</span></span><span id="sprytextfield5">      
      <label for="y"></label>
      <input name="y" type="text" id="y" value="<?php echo $row_edit['k_y']; ?>" size="5" />
      <span class="textfieldRequiredMsg">Silahkan Dipilih!</span></span></td>
    </tr>
    <tr>
      <td valign="top">No Alat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield6">
        <label for="alat"></label>
        <input name="alat" type="text" id="alat" value="<?php echo $row_edit['no_alat']; ?>" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Tanggal Nyala</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label for="datetime"></label>
      <input name="tgl" type="date" id="tgl" value="<?php echo $row_edit['tgl_nyala']; ?>" /></td>
    </tr>
    <tr>
      <td valign="top">Tanggal Berhenti</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label for="tanggal"></label>
      <input name="tanggal" type="date" id="tanggal" value="<?php echo $row_edit['tgl_berhenti']; ?>" /></td>
    </tr>
    <tr>
      <td valign="top">No Registrasi</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield7">
        <label for="rgs"></label>
        <input name="rgs" type="text" id="rgs" value="<?php echo $row_edit['no_reg']; ?>" readonly="readonly" />
      <span class="textfieldRequiredMsg"><br />
      Silahkan Dipilih</span></span></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
      <td valign="top"><input type="submit" name="submit" id="submit" value="SIMPAN" /></td>
    </tr>
    <tr>
      <td colspan="3" valign="top">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p><strong></strong></p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($edit);
?>
<?php include("footer.php"); ?>
