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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO perpanjangan_pesta (no_reg, tgl_nyala, tgl_berhenti, tgl_perpanjangan,status) VALUES (%s, %s, %s,now(),%s)",
                       GetSQLValueString($_POST['no_reg'], "text"),
                       GetSQLValueString($_POST['tglnyala'], "date"),
                       GetSQLValueString($_POST['tglhenti'], "date"),
					    GetSQLValueString($_POST['stt'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "daftar_perpanjangan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_perpanjangan = "-1";
if (isset($_GET['no_reg'])) {
  $colname_perpanjangan = $_GET['no_reg'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_perpanjangan = sprintf("SELECT * FROM pemohon_pesta WHERE no_reg = %s", GetSQLValueString($colname_perpanjangan, "text"));
$perpanjangan = mysql_query($query_perpanjangan, $koneksi) or die(mysql_error());
$row_perpanjangan = mysql_fetch_assoc($perpanjangan);
$totalRows_perpanjangan = mysql_num_rows($perpanjangan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2><strong>Input Data perpanjangan </strong></h2>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="543" border="0" cellpadding="5">
    <tr>
      <td width="137"><strong>No Reg</strong></td>
      <td width="36" align="center"><strong>:</strong></td>
      <td width="348"><strong>
      <input name="no_reg" type="text" id="no_reg" value="<?php echo $row_perpanjangan['no_reg']; ?>" readonly="readonly" />
      </strong></td>
    </tr>
    <tr>
      <td><strong>Nama</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input name="nama" type="text" id="nama" value="<?php echo $row_perpanjangan['nama_pemohon']; ?>" readonly="readonly" />
      </strong></td>
    </tr>
    <tr>
      <td><strong>Alamat</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <textarea name="alamat" cols="45" rows="5" readonly="readonly" id="alamat"><?php echo $row_perpanjangan['alamat']; ?></textarea>
      </strong></td>
    </tr>
    <tr>
      <td><strong>Tanggal Nyala</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input type="date" name="tglnyala" id="tglnyala" />
      </strong></td>
    </tr>
    <tr>
      <td><strong>Tanggal Berhenti</strong></td>
      <td align="center"><strong>:</strong></td>
      <td><strong>
      <input type="date" name="tglhenti" id="tglhenti" />
      </strong></td>
    </tr>
    <tr>
      <td>Status</td>
      <td align="center">:</td>
      <td>
      <?php $jm = mysql_query ("select * from perpanjangan_pesta where no_reg ='" .$row_perpanjangan['no_reg']. "'"); 
		$h1 = mysql_num_rows($jm);?>
        <?php 
		
		
		$h=$h1+1;
		
		
		?>
      <input name="stt" type="text" value="<?php echo $h; ?>" size="5" readonly="readonly" />
      
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td><strong>
        <input type="submit" name="Submit" id="Submit" value="Perpanjangan" />
      </strong></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($perpanjangan);
?>
<?php include("footer.php");?>