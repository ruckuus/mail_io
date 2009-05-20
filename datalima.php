<?php
ob_start();
//ini_set('display_errors', 0);
//error_reporting(6143);
//ini_set ('log_errors', 1);
/*
 * Created on May 19, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


	define('SMARTY_DIR', "smarty/libs/"); 
require_once(SMARTY_DIR . "Smarty.class.php");

include 'TABEL_MAPPING_FILE.php'; 
 
$smarty = new Smarty; 
$smarty->template_dir = 'templates/model2';
$smarty->compile_dir  = 'templates_c/';
$smarty->caching = 0;
$smarty->cache_lifetime = 1; 


include("header.php");
include("html.php");
include("config.inc.php");
include("jpgfunc.php");
session_start();
$htm = new html();
$html = new body();
$html->header();
$con= new db();

$con->connect();
if(!isset($_SESSION['tgl_akhir']) ||!isset($_SESSION['tgl_awal'])  )
{
session_register("tgl_awal","tgl_akhir");	
}



include 'mchip.inc';


if(!$_POST['tgl_awal'] )
{
	if($_SESSION['tgl_awal'])
	{
$tanggal=$_SESSION['tgl_awal'];
	}
	else
	{
$tanggal=date("m/d/Y",strtotime("1st ".date("M")." ".date("Y")));
	}
	
	
	
		
	
}
else
{
	if($_POST['tgl_awal'])
	{
		$_SESSION['tgl_awal']=$_POST['tgl_awal'];
	}
	if(isset($_SESSION['tgl_awal']))
	{
	$tanggal=$_POST['tgl_awal'];
	$_SESSION['tgl_awal']=$tanggal;
	}
	
}


if(!$_POST['tgl_akhir'] )
{
	if(!isset($_SESSION['tgl_akhir']))
{
	$tanggal2=date("m/d/Y");
	$_SESSION['tgl_akhir']=$tanggal2;
}
else
{
	$tanggal2=$_SESSION['tgl_akhir'];
	
}	
}
else
{
	if($_POST['tgl_akhir'])
	{
		$_SESSION['tgl_akhir']=$_POST['tgl_akhir'];
		//echo $_SESSION['tgl_akhir'];
	}
	if(isset($_SESSION['tgl_akhir']))
	{
	$tanggal2=$_POST['tgl_akhir'];
	}
	
}

$tanggalarray=explode("/",$tanggal);
$tanggalproses=$tanggalarray[2].$tanggalarray[0].$tanggalarray[1];

$tanggalarray2=explode("/",$tanggal2);
$tanggalproses2=$tanggalarray2[2].$tanggalarray2[0].$tanggalarray2[1];
/*
 * Definisi kategori menu disini
 */


$menudata=array("","data","transaksi","tr01","tr02","tr03","tr04","tr06");

/*
 * Definisi gabungan menu disini
 */
$menu1=array_merge(array(""),$menudata);



$menu.="<table >";
/*
$menu.=$html->split("Reporting Win");
$menu.=$html->menu("Churn","$PHP_SELF?aksi=jc");
$menu.=$html->menu("Saldo","$PHP_SELF?aksi=jd");
$menu.=$html->menu("MasterDelete","$PHP_SELF?aksi=tr");
*/

//print_r($_POST);


if($_POST['login'])
{
		$login=addslashes(urlencode($_POST[login]));
		$password=$_POST[pass];
	$db=$DATA[substr($login,0,4)];
	//print_r(substr($login,0,4));

	//echo $db."$login";
	
	if(!$db || !$_SESSION['db'])
	$db='mchip';

	
	if(strlen($login)>4)
	{
	$potongan=substr($login,0,4);
	
	$db=$header[$potongan];
		
	}

$_SESSION['db']=$db;
	//print_r($_SESSION);
		
	
$sql1="select * from $db.hp_reseller where kode_reseller='$login' and hp='$password' limit 1";
//echo $sql1;
	$hasil=$con->sql($sql1);
	
	//echo $sql1."</BR>";
	
	$data=mysql_fetch_array($hasil);
	
	if($data)
	{
	$content.="Login Sukses<BR>";
	$_SESSION['user']=$login;
	$_SESSION['password']=$password;
	

	$sqlx="SELECT * from $db.hp_reseller where kode_reseller='$login'";
//	echo $sqlx;
	$res=$con->sql($sqlx);
	$datar=mysql_fetch_array($res);
	$_SESSION['level']=$datar['i_akses'];
	
	}
	else
	{
	$content.="Login Failed";
	session_destroy();	
	
		}
}
//print_r($_SESSION);
$reseller=array('','1','2','3','4');
$master=array('','1','2','3');
$cabang=array('','1','2');
$pusat=array('','1');
if(!$_SESSION['user'])
{
$login=urldecode($login);

$menu.="<FORM ACTION=\"$PHP_SELF\" METHOD=POST><TR >";	
$menu.="<TD style=\"font-family:verdana; font-size:16;\">Kode Reseller </TD></TR><TR><TD ><INPUT style=\"font-family:verdana; font-size:10;\" TYPE=text name=login maxlength=15 size=25 value=\"$login\"></TD></TR>";
$menu.="<TR><TD style=\"font-family:verdana; font-size:16;\">HP Reseller </TD></TR><TR><TD ><INPUT style=\"font-family:verdana; font-size:10;\"  TYPE=password size=25 name=pass value=\"$login\"></TD></TR>";
$menu.="<TR><TD style=\"font-family:verdana; font-size:16;\" align=right><INPUT TYPE=submit value=login style=\"font-family:verdana; font-size:16;\"></TD></TR>";
$menu.="</FORM>";
}
else
{ // START MENU
/*
$login=$_SESSION['user'];
$dsql="SELECT * from mchip.r_reseller where prefix_reseller=mid('$login',1,4)";
$dres=$con->sql($dsql);
$ddata=mysql_fetch_array($dres);
$db=$ddata['database'];
*/

//echo $_SESSION['tipe'];
	//print_r($menu1);
{


//$menu.=$html->split("MCHIP");
//$menu.=$_SESSION['level'];
$menu.=$html->split("Transaksi","$PHP_SELF?buka=transaksi");
if($_GET['buka']=="transaksi" || array_search($_GET["aksi"],$menudata))
{
	
if(array_search($_SESSION['level'],$reseller)>0)
$menu.=$html->menu("Detail Transaksi","$PHP_SELF?aksi=tr01");
if(array_search($_SESSION['level'],$master)>0)
$menu.=$html->menu("Rekap Transaksi","$PHP_SELF?aksi=tr03");
if(array_search($_SESSION['level'],$master)>0)
$menu.=$html->menu("TOP-10 Reseller","$PHP_SELF?aksi=tr02");
if(array_search($_SESSION['level'],$master)>0)
$menu.=$html->menu("Top-10 Product","$PHP_SELF?aksi=tr04");
if(array_search($_SESSION['level'],$reseller)>0)
$menu.=$html->menu("Detail All Transaksi","$PHP_SELF?aksi=tr06");
}



}



$menu.=$html->split("Logout","$PHP_SELF?buka=logout");
}

if($_GET['buka']=="logout")
{
	session_destroy();
	$host=$_SERVER['HTTP_HOST'];
	header('location: http://'.$host.$_SERVER['PHP_SELF']);
}
$db=$_SESSION['db'];
$menu.="</table>";

if($_GET['dbx'])
{
$db=$_GET['dbx'];
$_SESSION['db']=$db;
}	
if(!$_GET['master'])
{
$master=$_SESSION['user'];
}
else
$master=$_GET['master'];
$content.="<TABLE>";
if(array_search($_SESSION['level'],$pusat)>0)
{
	$sqlx="SELECT distinct TABLE_SCHEMA as tables from information_schema.TABLES where lower(TABLE_SCHEMA) like 'mchip%'";
	$content.=$con->combobox($sqlx,"Cabang","$db",'tables'," onchange=\"location='?aksi=".$_GET['aksi']."&dbx='+this.options[this.selectedIndex].value;\" ");
	//$content.="<BR>";
	//ONCHANGE=\"location=\"?aksi=".$_GET['aksi']."&db=this.options[this.selectedIndex].value;\"
}

if(array_search($_SESSION['level'],$cabang)>0)
{
	$sqlx="SELECT kode_reseller,nama_reseller from $db.reseller where mstatus=1";
	//echo $sqlx;
	$content.=$con->combobox($sqlx,"Master","$master",'nama_reseller'," onchange=\"location='?aksi=".$_GET['aksi']."&master='+this.options[this.selectedIndex].value;\" ");
	//ONCHANGE=\"location=\"?aksi=".$_GET['aksi']."&db=this.options[this.selectedIndex].value;\"
	//$content.="<BR><BR>";
}

$content.="</TABLE>";

if($_GET['aksi']=="tr01" || $_GET['aksi']=="tr05")
{
	$aksii=$_GET['aksi'];

	if(array_search($_SESSION['level'],$cabang)>0)
	{
		$sql="SELECT id,datetime_transaksi as datetime,kode_produk as produk,tujuan,hp_reseller as hp,deposit_awal,deposit_akhir,harga_jual,status from  $db.transaksibcu where kode_reseller='".$master."' and  status=1 and DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2'";
		
//		echo $sql;
	}
else
	{
	$sql="SELECT id,datetime_transaksi as datetime,kode_produk as produk,tujuan,hp_reseller as hp,deposit_awal,deposit_akhir,harga_jual,status from  $db.transaksibcu where kode_reseller='".$_SESSION['user']."'  and  status=1 and DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2'";
	}
	
$querytipe=3;
//echo $sql;
if($_GET['detail'])
{

$sql="SELECT id,kode_transaksi,datetime_sms,datetime_transaksi ,	 kode_produk ,	 produkid, 	 modul ,	 nominal ,	 stok, 	 tujuan, 	 kode_reseller, 	 hth, 	 label, 	 kode_master, 	 hp_reseller, 	 deposit_awal, 	 deposit_akhir ,	 harga_beli ,	 harga_jual, 	 biaya ,	 terminal, 	 status ,	  arstatus 	, jumlah ,	 operator 	, remark ,	  nochip 	 ,stokawal, 	 stokakhir 	, jh ,	 distributor ,	 pesan 	, outbox 	,    debet ,	 kredit from $db.transaksibcu where id='".$_GET['detail']."'";

//echo "<BR>";
//echo $sql;
$query=$con->sql($sql);
$content.="<A HREF=javascript:history.go(-1)>back</A>";
while($data=mysql_fetch_array($query))
{
$content.="<TABLE border=1>";
for($i=0;$i<mysql_num_fields($query);$i++)
{
$content.=$htm->p(mysql_field_name($query,$i),$data[$i],'class=test');
}
$content.="</TABLE>";
}



}
else
{
//	echo "<BR><BR>";
	$xx="tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2;
	if(array_search($_SESSION['level'],$cabang)>0)
	{
		$sqlx="SELECT * from $db.reseller where kode_reseller='".$master."' ";
	}
	else
		$sqlx="SELECT * from $db.reseller where kode_reseller='".$_SESSION['user']."' ";
	
		$res=$con->sql($sqlx);
	
	$data=mysql_fetch_array($res);
$htm = new html();
$content.="<TABLE>";
$content.=$htm->string("Kode RS",$data['kode_reseller']);
$content.=$htm->string("Nama RS",$data['nama_reseller']);
$content.=$htm->string("Kode Master",$data['kode_master']);
if(!$data['kode_master'])
{
	$kode=$_SESSION['user'];
}
else
{
		$kode=$data['kode_master'];
}
	$sqlx="SELECT * from $db.reseller where kode_reseller='".$kode."'";
//	echo $sqlx;
	$res=$con->sql($sqlx);
	$datax=mysql_fetch_array($res);
$content.=$htm->string("Nama Master",$datax['nama_reseller']);
$content.="</TABLE>";		
//echo "<BR><BR>";
//echo $sql;
  $content.=$con->table("$sql",$class='test',"$querytipe",   $xx,"",$total='0',$test='',2,array("detail"),0,$skiping=array('0','1','2','3','4'));

}

}
else if($_GET['aksi']=="tr06")
{
	//mysql_select_db($db);
	if(array_search($_SESSION['level'],$cabang)>0)
	{

		$sql="SELECT id,datetime_transaksi as datetime,kode_produk as produk,tujuan,hp_reseller as hp,deposit_awal,deposit_akhir,harga_jual,status from  ( SELECT * FROM (SELECT * FROM $db.transaksibcu union  SELECT * FROM $db.transaksi where kode_reseller='".$master."' and  status=1 and DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2') as a) as b";
		
//		echo $sql;
	}
else
	{

	$sql="SELECT id,datetime_transaksi as datetime,kode_produk as produk,tujuan,hp_reseller as hp,deposit_awal,deposit_akhir,harga_jual,status from ( SELECT * FROM $db.transaksibcu union SELECT * FROM $db.transaksi) as x where kode_reseller='".$_SESSION['user']."'  and  status=1 and DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2'";
	}
	
$querytipe=3;
//echo $sql;
if($_GET['detail'])
{
//echo "a";	
$sql="SELECT id,kode_transaksi,datetime_sms,datetime_transaksi ,	 kode_produk ,	 produkid, 	 modul ,	 nominal ,	 stok, 	 tujuan, 	 kode_reseller, 	 hth, 	 label, 	 kode_master, 	 hp_reseller, 	 deposit_awal, 	 deposit_akhir ,	 harga_beli ,	 harga_jual, 	 biaya ,	 terminal, 	 status ,	  arstatus 	, jumlah ,	 operator 	, remark ,	  nochip 	 ,stokawal, 	 stokakhir 	, jh ,	 distributor ,	 pesan 	, outbox 	,    debet ,	 kredit from (SELECT * FROM (SELECT * FROM $db.transaksibcu  union SELECT *  FROM $db.transaksi) as x where id='".$_GET['detail']."') as b";

//echo "<BR>";
//echo $sql;
$query=$con->sql($sql);
$content.="<A HREF=javascript:history.go(-1)>back</A>";
while($data=mysql_fetch_array($query))
{
	
$content.="<TABLE border=1>";
for($i=0;$i<mysql_num_fields($query);$i++)
{
$content.=$htm->p(mysql_field_name($query,$i),$data[$i],'class=test');
}
$content.="</TABLE>";
}



}
else
{
//	echo "<BR><BR>";
//	echo "xxxx";
	$xx="tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2;
	if(array_search($_SESSION['level'],$cabang)>0)
	{
		$sqlx="SELECT * from $db.reseller where kode_reseller='".$master."' ";
	}
	else
		$sqlx="SELECT * from $db.reseller where kode_reseller='".$_SESSION['user']."' ";
	
		$res=$con->sql($sqlx);
	
	$data=mysql_fetch_array($res);
//	echo "$sqlx";
//	echo "zzzzzzzzzzzzzzz";
$htm = new html();
$content.="<TABLE>";
$content.=$htm->string("Kode RS",$data['kode_reseller']);
$content.=$htm->string("Nama RS",$data['nama_reseller']);
$content.=$htm->string("Kode Master",$data['kode_master']);
if(!$data['kode_master'])
{
	$kode=$_SESSION['user'];
}
else
{
		$kode=$data['kode_master'];
}
	$sqlx="SELECT * from $db.reseller where kode_reseller='".$kode."'";
//	echo $sqlx."xxxxxxxxxxxxxxx";
	$res=$con->sql($sqlx);
	$datax=mysql_fetch_array($res);
$content.=$htm->string("Nama Master",$datax['nama_reseller']);
$content.="</TABLE>";		
//echo "<BR><BR>";
//echo $sql."1111111111111111111111";
  $content.=$con->table("$sql",$class='test',"$querytipe",   $xx,"",$total='0',$test='',2,array("detail"),0,$skiping=array('0','1','2','3','4'));

}
//echo "xxxxxxxxxxxxxxxxxAAAAAAAAAAA";
}
else if($_GET['aksi']=="tr02")
{
//error_reporting(6143);
	$querytipe=2;
$sql="SELECT nama_reseller,transaksi from (SELECT count(*) as transaksi,kode_reseller FROM $db.transaksibcu r where DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2' and status=1 group by kode_reseller  order by transaksi DESC  ) a inner join $db.reseller b on a.kode_reseller=b.kode_reseller order by transaksi DESC limit 10";	
//echo $sql;
//$sql="SELECT id,kode_transaksi,datetime_transaksi,kode_produk,tujuan,deposit_awal,deposit_akhir,harga_jual,status from  $db.transaksi where kode_reseller='".$_SESSION['user']."' and hp_reseller='".$_SESSION['password']."'";
//$content.=$con->table("$sql",$class='test',"$querytipe","tr01","",$total='0',$test='',0,0,$skiping=0);	
$content.=$con->table("$sql",$class='test',"$querytipe","tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2,$combo="$divre",$total='0',$judul=$jadul);
//$sql="SELECT nama_reseller,transaksi from (SELECT count(*) as transaksi,kode_reseller FROM mchip.transaksibcu r where DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2'  group by kode_reseller  order by transaksi DESC  limit 10) a inner join mchip.reseller b on a.kode_reseller=b.kode_reseller order by transaksi DESC ";	
$tipe="pie";
$reserved=",0";
$title="TOP TEN BEST RESELLER";
$xtitle="GRAFIK";
$ytitle="MAMA";
//echo $sql;
if(mysql_num_rows($con->sql($sql))>1)
{
	$_SESSION["sql"]=$sql;
	$_SESSION["tipe"]=$tipe;
	$_SESSION["reserved"]=$reserved;
	$_SESSION["title"]=$title;
include 'grafik2.php';
}
}
else if($_GET['aksi']=="tr03")
{
$querytipe=2;
if(array_search($_SESSION['level'],$cabang)>0)
	$sqlx="SELECT * from $db.reseller where kode_reseller='".$master."' ";
	else
	$sqlx="SELECT * from $db.reseller where kode_reseller='".$_SESSION['user']."' ";
	$res=$con->sql($sqlx);
	$data=mysql_fetch_array($res);
//echo $sqlx;


$htm = new html();
$content.="<TABLE>";
$content.=$htm->string("Kode RS",$data['kode_reseller']);
$content.=$htm->string("Nama RS",$data['nama_reseller']);
$content.="</TABLE>";
$xx="tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2;

if(array_search($_SESSION['level'],$cabang)>0)
$sql="SELECT a.kode_reseller, nama_reseller,transaksi FROM (SELECT kode_reseller,count(*) as transaksi FROM $db.transaksibcu t  where  DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2' and kode_master='".$master."' and status=1 group by kode_reseller) a inner join  (SELECT * from $db.reseller  where mstatus=1) b on a.kode_reseller=b.kode_reseller";	
else
$sql="SELECT a.kode_reseller, nama_reseller,transaksi FROM (SELECT kode_reseller,count(*) as transaksi FROM $db.transaksibcu t  where DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2' and kode_master='".$_SESSION['user']."' and status=1 group by kode_reseller) a inner join (SELECT * from $db.reseller  where mstatus=1) b on a.kode_reseller=b.kode_reseller";	
//echo $sql;
if($_GET['detail'])
{
	$url="view.php?detail=".$_GET['detail'];
	//echo $url;
	?>
	<script language=javascript>
	window.open('<? echo $url?>','_blank','');
	</script>
	<?
}

$content.=$con->table("$sql",$class='test',"$querytipe",   $xx,"",$total='0',$test='',2,array("detail"),0,$skiping=0);
//$content.=$con->table("$sql",$class='test',"$querytipe","tr01","",$total='0',$test='',2,array("detail"),$skiping=0);	
//$content.=$con->table("$sql",$class='test',"$querytipe","tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2,$combo="$divre",$total='0',$judul=$jadul);
}
else if($_GET['aksi']=="tr04")
{
$sql="select a.kode_produk,banyak,nama_produk from (SELECT kode_produk,count(kode_produk) as banyak FROM $db.transaksibcu t group by kode_produk )as a inner join $db.produk b on a.kode_produk=b.kode_produk order by banyak desc limit 10";	
$querytipe=2;
$xx="tgl_awal".",".$tanggal.",tgl_akhir".",".$tanggal2;
//echo $sql;

$content.=$con->table("$sql",$class='test',"$querytipe",   $xx,"",$total='0',$test='',2,array("detail"),0,$skiping=array('','1'));
$sql="select a.kode_produk,banyak from (SELECT kode_produk,count(kode_produk) as banyak FROM $db.transaksibcu t where DATE(datetime_transaksi)>='$tanggalproses' and DATE(datetime_transaksi)<='$tanggalproses2' group by kode_produk )as a inner join $db.produk b on a.kode_produk=b.kode_produk order by banyak desc limit 10";	
$tipe="pie";
$reserved=",0";
$title="TOP TEN BEST RESELLER";
$xtitle="GRAFIK";
$ytitle="MAMA";

if(mysql_num_rows($con->sql($sql))>1)
{
	$_SESSION["sql"]=$sql;
	$_SESSION["tipe"]=$tipe;
	$_SESSION["reserved"]=$reserved;
	$_SESSION["title"]=$title;
include 'grafik2.php';
//echo $sql;
}

}
$content.="<div id=\"chart\"></div>";

//include_once 'gengrafik.php';
$title="$export";
$smarty->assign("judul_modul",$jadulutama);
$smarty->assign("menu",$menu);
$smarty->assign("title",$title);
$smarty->assign("content",$content);
$smarty->display("index.tpl");
$html->footer();
 
?>
