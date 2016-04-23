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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pemohon_pesta (nama_pemohon, alamat, daya, p_awal, p_akhir, p_satuan, no_hp, k_x, k_y, no_alat, tgl_nyala, tgl_berhenti, no_reg, tgl_daftar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, now())",
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
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "daftar_layanan.php";
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1096" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="131" valign="top">Nama Pemohon</td>
      <td width="20" align="center" valign="top">:</td>
      <td width="923" valign="top"><span id="sprytextfield1">
        <label for="nm"></label>
        <input type="text" name="nm" id="nm" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong</span></span></td>
    </tr>
    <tr>
      <td valign="top">Alamat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextarea1">
        <label for="alm"></label>
        <textarea name="alm" id="alm" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Daya</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield2">
        <label for="daya"></label>
        <input type="text" name="daya" id="daya" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Pembatas</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="spryselect1">
        <label for="p1"></label>
        <select name="p1" id="p1">
          <option>Pilih</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      <span class="selectRequiredMsg">Silahkan Dipilh!</span></span><span id="spryselect2">
      <label for="p2"></label>
      <select name="p2" id="p2">
      	<option>Pilih</option>
      	<option value="1">1</option>
      	<option value="2">2</option>
      	<option value="3">3</option>
      	<option value="4">4</option>
      	<option value="5">5</option>
      	<option value="6">6</option>
      	<option value="7">7</option>
      	<option value="8">8</option>
      	<option value="9">9</option>
      	<option value="10">10</option>
      	<option value="11">11</option>
      	<option value="12">12</option>
      	<option value="13">13</option>
      	<option value="14">14</option>
      	<option value="15">15</option>
      	<option value="16">16</option>
      	<option value="17">17</option>
      	<option value="18">18</option>
      	<option value="19">19</option>
      	<option value="20">20</option>
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
      <input type="text" name="hp" id="hp" />
      <span class="textfieldRequiredMsg"><br />
Tidak Boleh Kosong!</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
    </tr>
    <tr>
      <td valign="top">Titik Koordinat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield4">
        <label for="x"></label>
        <input name="x" type="text" id="x" size="5" />
      <span class="textfieldRequiredMsg">Tidak Boleh Kosong!</span></span><span id="sprytextfield5">      
      <label for="y"></label>
      <input name="y" type="text" id="y" size="5" />
      <span class="textfieldRequiredMsg">Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">No Alat</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield6">
        <label for="alat"></label>
        <input type="text" name="alat" id="alat" />
      <span class="textfieldRequiredMsg"><br />
      Tidak Boleh Kosong!</span></span></td>
    </tr>
    <tr>
      <td valign="top">Tanggal Nyala</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label for="datetime"></label>
      <input type="date" name="tgl" id="tgl" /></td>
    </tr>
    <tr>
      <td valign="top">Tanggal Berhenti</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label for="tanggal"></label>
      <input type="date" name="tanggal" id="tanggal" /></td>
    </tr>
    <tr>
      <td valign="top">No Registrasi</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><span id="sprytextfield7">
        <label for="rgs"></label>
        <input type="text" name="rgs" id="rgs" />
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
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p><strong></strong></p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur", "change"], useCharacterMasking:true});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php include("footer.php"); ?>