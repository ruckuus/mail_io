<?php
/*
  PHPWPos, Open Source Point-Of-Sale System
  http://phpwpos.ptwebserve.com

  Copyright (c) 2006 Moisés Sequeira

  Released under the GNU General Public License
*/

session_start();
if(!isset($_SESSION['admin'])){
header("Location:index.php");
}

if(isset($_GET['rand'])){

	$query = "SELECT id,
		kode_transaksi,
		datetime_sms,
		datetime_transaksi,
		kode_produk,
		produkid,
		modul,
		nominal,
		stok,
		tujuan,
		kode_reseller,
		hth,
		label,
		kode_master,
		hp_reseller,
		deposit_awal,
		deposit_akhir,
		harga_beli,
		harga_jual,
		biaya,
		terminal,
		status,
		arstatus, 
		jumlah,
		operator, 
		remark,	  
		nochip,
		stokawal,
		stokakhir, 
		jh,	 
		distributor,	 
		pesan, 
		outbox,    
		debet,	 
		kredit from transaksibcu where id='".$_GET['rand']."'";

//	echo $query;

	$result = $db->query($query);
?>
	<table>
<?
	$row = mysql_fetch_row($result);
?>
<BR>
<TR>
<TR><TD class="tvalue">ID</TD><TD class="tvalue"><?php echo htmlspecialchars($row[0]); ?></TD></TR>
<TR><TD class="tvalue">Kode Transaksi</TD><TD class="tvalue"><?php echo htmlspecialchars($row[1]); ?></TD></TR>
<TR><TD class="tvalue">Waktu SMS</TD><TD class="tvalue"><?php echo htmlspecialchars($row[2]); ?></TD></TR>
<TR><TD class="tvalue">Waktu Transaksi</TD><TD class="tvalue"><?php echo htmlspecialchars($row[3]); ?></TD></TR>
<TR><TD class="tvalue">Kode Produk</TD><TD class="tvalue"><?php echo htmlspecialchars($row[4]); ?></TD></TR>
<TR><TD class="tvalue">Produk ID</TD><TD class="tvalue"><?php echo htmlspecialchars($row[5]); ?></TD></TR>
<TR><TD class="tvalue">Modul</TD><TD class="tvalue"><?php echo htmlspecialchars($row[6]); ?></TD></TR>
<TR><TD class="tvalue">Nominal</TD><TD class="tvalue"><?php echo htmlspecialchars($row[7]); ?></TD></TR>
<TR><TD class="tvalue">Stok</TD><TD class="tvalue"><?php echo htmlspecialchars($row[8]); ?></TD></TR>
<TR><TD class="tvalue">Tujuan</TD><TD class="tvalue"><?php echo htmlspecialchars($row[9]); ?></TD></TR>
<TR><TD class="tvalue">Kode Reseller</TD><TD class="tvalue"><?php echo htmlspecialchars($row[10]); ?></TD></TR>
<TR><TD class="tvalue">HTH</TD><TD class="tvalue"><?php echo htmlspecialchars($row[11]); ?></TD></TR>
<TR><TD class="tvalue">Label</TD><TD class="tvalue"><?php echo htmlspecialchars($row[12]); ?></TD></TR>
<TR><TD class="tvalue">Kode Master</TD><TD class="tvalue"><?php echo htmlspecialchars($row[13]); ?></TD></TR>
<TR><TD class="tvalue">HP Reseller</TD><TD class="tvalue"><?php echo htmlspecialchars($row[14]); ?></TD></TR>
<TR><TD class="tvalue">Deposit awal</TD><TD class="tvalue"><?php echo htmlspecialchars($row[15]); ?></TD></TR>
<TR><TD class="tvalue">Deposit Akhir</TD><TD class="tvalue"><?php echo htmlspecialchars($row[16]); ?></TD></TR>
<TR><TD class="tvalue">Harga Beli</TD><TD class="tvalue"><?php echo htmlspecialchars($row[17]); ?></TD></TR>
<TR><TD class="tvalue">Harga Jual</TD><TD class="tvalue"><?php echo htmlspecialchars($row[18]); ?></TD></TR>
<TR><TD class="tvalue">Biaya</TD><TD class="tvalue"><?php echo htmlspecialchars($row[19]); ?></TD></TR>
<TR><TD class="tvalue">Terminal</TD><TD class="tvalue"><?php echo htmlspecialchars($row[20]); ?></TD></TR>
<TR><TD class="tvalue">Status</TD><TD class="tvalue"><?php echo htmlspecialchars($row[21]); ?></TD></TR>
<TR><TD class="tvalue">Arstatus</TD><TD class="tvalue"><?php echo htmlspecialchars($row[22]); ?></TD></TR>
<TR><TD class="tvalue">Operator</TD><TD class="tvalue"><?php echo htmlspecialchars($row[23]); ?></TD></TR>
<TR><TD class="tvalue">Remark</TD><TD class="tvalue"><?php echo htmlspecialchars($row[24]); ?></TD></TR>
<TR><TD class="tvalue">No Chip</TD><TD class="tvalue"><?php echo htmlspecialchars($row[25]); ?></TD></TR>
<TR><TD class="tvalue">Stok Awal</TD><TD class="tvalue"><?php echo htmlspecialchars($row[26]); ?></TD></TR>
<TR><TD class="tvalue">Stok Akhir</TD><TD class="tvalue"><?php echo htmlspecialchars($row[27]); ?></TD></TR>
<TR><TD class="tvalue">jh</TD><TD class="tvalue"><?php echo htmlspecialchars($row[28]); ?></TD></TR>
<TR><TD class="tvalue">Distributor</TD><TD class="tvalue"><?php echo htmlspecialchars($row[29]); ?></TD></TR>
<TR><TD class="tvalue">Pesan</TD><TD class="tvalue"><?php echo htmlspecialchars($row[30]); ?></TD></TR>
<TR><TD class="tvalue">Outbox</TD><TD class="tvalue"><?php echo htmlspecialchars($row[31]); ?></TD></TR>
<TR><TD class="tvalue">Debet</TD><TD class="tvalue"><?php echo htmlspecialchars($row[32]); ?></TD></TR>
<TR><TD class="tvalue">Kredit</TD><TD class="tvalue"><?php echo htmlspecialchars($row[33]); ?></TD></TR>
<?	
?>
	</table>
<?
} else {
?>

<div class="admin_content">
<div id="hdr_report">
<script type="text/javascript">
	var dp_cal;
	window.onload = function () {
	dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('pop_corn'));
	dx_cal  = new Epoch('epoch_popup','popup',document.getElementById('pop_porn'));
};
</script>

  <form action="index.php?action=<?=md5('transaction')?>" method="POST" name="form_report1">
  Tanggal <input id="pop_corn" type="text" size="15" name="date1" <?php if(isset($_POST['submit_report1']))echo 'value="' .$_POST['date1'] .'"'; ?>> 
  sampai
	<input id="pop_porn" type="text" size="15" name="date2" <?php if(isset($_POST['submit_report1']))echo 'value="' .$_POST['date2'] .'"'; ?>>&nbsp;&nbsp;&nbsp;
  Reseller <select name="user"><option value="-1">---</option><option value="0">Administrator</option>
  <?php
$result = $db->query('select reseller.kode_reseller, reseller.nama_reseller from reseller, hp_reseller where reseller.kode_reseller = hp_reseller.kode_reseller AND reseller.mstatus=\'1\'');
  while ($row = mysql_fetch_row($result)){
    if(isset($_POST['user']) && $_POST['user']==$row[0]){
  ?><option value="<?php echo $row[0]; ?>" SELECTED><?php echo htmlspecialchars($row[0] ." " .$row[1]); ?></option><?php
    }
    else{
  ?><option value="<?php echo $row[0]; ?>"><?php echo htmlspecialchars($row[0] ." " .$row[1]); ?></option><?php
    }
  }
  ?>
  </select>&nbsp;&nbsp;&nbsp;<input type="submit" value="Submit" name="submit_report1">
  Jumlah Record <input id="pg_lmt" type="text" size="3" value=<? if (isset($_POST['page_limit'])) {print $_POST['page_limit'];} else {print "30";}?> name="page_limit">

 <input type="hidden" value=<?=$_POST['limiter']?> name="limiter">
  <input type="submit" value=">" name="next_page">
  <input type="submit" value=">>" name="last_page">
  </form>
</div>

<?php
if (isset($_POST['date1'])) {
	$datefrom = $_POST['date1'];
	$d = explode("/", $datefrom);
	$fromdate = $d[2].$d[0].$d[1];

		$sql1 = "SELECT id,
			datetime_transaksi,
			kode_produk,
			tujuan,
			hp_reseller,
			deposit_awal,
			deposit_akhir,
			harga_jual,
			status 
			from transaksibcu";

	$sql1 .= " where status=1 ";

	$nq = 0;
	if($_POST['date1']!="" && $_POST['date2']==""){
          $sql1 .= " and DATE(datetime_transaksi)='" .$fromdate."'";
	  $nq++;
	}
	if($_POST['date1']!="" && $_POST['date2']!=""){
		$tod = $_POST['date2'];
		$t = explode("/", $tod);
		$todate = $t[2].$t[0].$t[1];

	    $sql1 .= " and DATE(datetime_transaksi) between '" .$fromdate."' and '" .$todate."'";
	    $nq++;
	}

	/* Take user ID and priviledge */
	if($_POST['user']>-1){
          if($nq==0){
	    $sql1 .= " and kode_reseller=" .$_POST['user'];
	  }
	  
	  $nq++;
	}   
	    if (isset($_POST['page_limit'])) {
		$lim = $_POST['page_limit'];
		$limn = htmlspecialchars($_POST['limiter']);

		if (isset($_POST['next_page'])) {
			echo "NEXT PAGE";
			$sql1 .= " limit ".$limn.", ".$lim;
			$limn = $limn + $lim;
			echo $lim;
			echo $limn;
		}

		if (isset($_POST['last_page'])) {
			echo "LAST PAGE";
			$sql1 .= " limit ".$limn.", ".$lim;
		}

		if (isset($_POST['submit_report1'])) {
			echo "S PAGE";
			$sql1 .= " limit 0, ".$lim;
			$limn += $lim;
		}

	}
	  ?>
	<table>
	<tr>
	<th width="20" align="right">ID</th>
	<th width="150">Waktu Transaksi</th>
	<th width="100">Kode Produk</th>
	<th width="120">Nomor Tujuan</th>
	<th width="120">Nomor HP Reseller</th>
	<th width="120">Deposit Awal</th>
	<th width="120">Deposit Akhir</th>
	<th width="120">Harga Jual</th>
	<th width="80">Status</th>
	<th width="80">Detail</th>
	
	</tr>
	<?php
    }
	echo $sql1;
	$result = $db->query($sql1);
	if($result){
	  while($row = mysql_fetch_row($result)){
        
		  ?>
			  <TR>
			  <TD align="right"><?php echo $row[0]; ?></TD>
			  <TD align="right"><?php echo $row[1]; ?></TD>
			  <TD align="right"><?php echo $row[2]; ?></TD>
			  <TD align="right"><?php echo $row[3]; ?></TD>
			  <TD align="right"><?php echo $row[4]; ?></TD>
			  <TD align="right"><?php echo $row[5]; ?></TD>
			  <TD align="right"><?php echo $row[6]; ?></TD>
			  <TD align="right"><?php echo $row[7]; ?></TD>
			  <TD align="right"><?php echo $row[8]; ?></TD>
			  <TD align="right"><a href="index.php?action=<?=md5('transaction')."&rand=".$row[0];?>">detail</a></TD>
			  </TR><?php
	  }
	}
  ?>
  	</table>
</div>
<?php
  }
?>

