<?php
require 'koneksi.php';
?>
<?php

$select = "select * from permohonan_pesta ";

$export = mysql_query($select);
$fields = mysql_num_fields($export);
for ($i = 0; $i < $fields; $i++) {
$header .= mysql_field_name($export, $i) . "\t";
}
while($row = mysql_fetch_row($export)) {
$line = '';
foreach($row as $value) {
if ((!isset($value)) OR ($value == "")) {
$value = "\t";
} else {
$value = str_replace('"', '""', $value);
$value = '"' . $value . '"' . "\t";
}
$line .= $value;
}
$data .= trim($line)."\n";
}
$data = str_replace("\r","",$data);
if ($data == "") {
$data = "n(0) record found!\n";
}
$no_reg="text";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=daftar_layanan".$no_reg.".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";

