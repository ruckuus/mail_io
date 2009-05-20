<?php
/*
  PHPWPos, Open Source Point-Of-Sale System
  http://phpwpos.ptwebserve.com

  Copyright (c) 2006 Moisés Sequeira
  Copyright (c) 2006 Dwi Sasongko S

  Released under the GNU General Public License
*/

header('Content-Type:text/xml; charset="iso-8859-1"');
session_start();
if(!isset($_SESSION['user'])){
header("Location:admin.php");
}
include("config.php");

require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);
$result = $db->query("select id, item_name, image, buy_price, unit_price, tax_percent, total_cost, quantity from items where category_id=" .$_GET['category']);
echo '<?xml version="1.0" encoding="iso-8859-1" ?>
';
?>
<items>
<?php
while($row = mysql_fetch_row($result)){
?>
<item>
<id><?php echo $row[0]; ?></id>
<name><?php echo htmlspecialchars($row[1]); ?></name>
<image><?php echo $row[2]; ?></image>
<buyprice><?php echo $row[3]; ?></buyprice>
<unitprice><?php echo $row[4]; ?></unitprice>
<tax><?php echo htmlspecialchars($row[5]); ?></tax>
<price><?php echo htmlspecialchars($row[6]); ?></price>
<qty><?php echo $row[7];?></qty>
</item>
<?php
}
mysql_free_result($result);
$db->close();
?>
</items>

