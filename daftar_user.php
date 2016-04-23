<?php include "header.php"; ?>
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
$query_user = "SELECT * FROM `user` WHERE `level` = 'control_user' ORDER BY nama ASC";
$user = mysql_query($query_user, $koneksi) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
$i=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2>Daftar Control User
</h2>

<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td><strong>No</strong></td>
    <td><strong>Nama</strong></td>
    <td><strong>Level</strong></td>
    <td><strong>Rayon</strong></td>
    <td><strong>Username</strong></td>
    <td><strong>Password</strong></td>
    <td colspan="2" align="center"><strong>Action</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row_user['nama']; ?></td>
      <td><?php echo $row_user['level']; ?></td>
      <td><?php echo $row_user['rayon']; ?></td>
      <td><?php echo $row_user['username']; ?></td>
      <td><?php echo $row_user['pwd']; ?></td>
      <td align="center"><a href="control_edit.php?id=<?php echo $row_user['id']; ?>">Edit</a></td>
      <td align="center"><a href="del_user.php?id=<?php echo $row_user['id']; ?>" 
      onclick="return confirm('hapus data  <?php echo $row_user['id']; ?>?')">Hapus</a></td>
    </tr>
    <?php } while ($row_user = mysql_fetch_assoc($user)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($user);
?>
<?php include "footer.php"; ?>