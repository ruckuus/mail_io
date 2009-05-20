<?php
/*
  PHPWPos, Open Source Point-Of-Sale System
  http://phpwpos.ptwebserve.com

  Copyright (c) 2006 Moisés Sequeira

  Released under the GNU General Public License
*/

/************************
Configuration file
************************/

//Administrator login
$adminname = "admin";
$adminpassword = "ac43724f16e9241d990427ab7c8f4228";

//Database values
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "mchip";

//GENERAL VALUES
define("POS_DEFAULT_LANGUAGE","english");
define("CATEGORY_IMG_SIZE","32");
define("ITEM_IMG_SIZE","32");
define("CURRENCY","Rp ");
define("ITEMS_PER_PAGE","10"); 
define("ECSMS_ROOT","localhost/mchip");

/* User Level */
define("MCHIP_PUSAT", 1);
define("MCHIP_CABANG", 2);
define("MCHIP_MASTER", 3);
define("MCHIP_RESELLER", 4)
?>
