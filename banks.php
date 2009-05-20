<?php
/*
  PHPWPos, Open Source Point-Of-Sale System
  http://phpwpos.ptwebserve.com

  Copyright (c) 2006 Moisés Sequeira
  Copyright (c) 2009 Dwi Sasongko S

  Released under the GNU General Public License
*/

session_start();
if(!isset($_SESSION['admin'])){
header("Location:admin.php");
}

//Add bank
if(isset($_POST['submitbank'])){
$sql = "insert into banks(name) values('" .$_POST['bank'] ."')";
$db->query($sql);
}

//Edit bank
if(isset($_POST['editbank'])){
	$sql = "update banks set bank='" .$_POST['bank'] ."' where id=" .$_POST['bank_id'];
	$db->query($sql);
}

//Delete bank
if(isset($_GET['delete'])){
$sql = "delete from banks where id=" .$_GET['delete'];
$db->query($sql);
}
?>
<div class="admin_content">
<script language="JavaScript">
  function validate_form(frm){
    if(frm.bank.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
  function validate_edit_form(frm){
    if(frm.bank.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
</script>
<?php
if(isset($_GET['edit'])){
	$sql = "select name from banks where id=" .$_GET['edit'];
	$result = $db->query($sql);
	$bank = mysql_fetch_row($result);
?>
<form action="admin.php?action=banks" onsubmit="return validate_form(this)" method="POST">
<input type="hidden" name="bank_id" value="<?php echo $_GET['edit']; ?>">
<?php echo HDR_BANK; ?>: <input type="text" size="30" name="bank" value="<?php echo htmlspecialchars($bank[0]); ?>"> 
<input type="submit" name="editbank" value="<?php echo TXT_SAVE; ?>">
</form>
<?php
}
else{
?>
<form action="admin.php?action=banks" onsubmit="return validate_edit_form(this)" method="POST">
<?php echo ADD_NEW_BANK; ?>:<br>
<input type="text" size="30" name="bank"> <input type="submit" name="submitbank" value="<?php echo BANK_SUBMIT; ?>">
</form>
<br>
<script language="JavaScript">
  function delete_cur(i){
    op = confirm("<?php echo CONFIRM_DELETE; ?>");
    if(op)document.location.href="admin.php?action=banks&delete="+i;
  }
</script>
<table cellspacing="0">
<TR><TH width="300"><?php echo HDR_BANK; ?></TH><TH><?php echo TXT_EDIT; ?></TH><TH><?php echo TXT_DELETE; ?></TH></TR>
<?php
$sql = "select * from banks order by name ASC";
$result = $db->query($sql);
while($row = mysql_fetch_row($result)){
?><TR><TD class="btvalue"><?php echo htmlspecialchars($row[1]); ?></a></TD><TD class="tvalue" align="center"><a href="admin.php?action=banks&edit=<?php echo $row[0]; ?>"><img src="images/edit.gif"></a></TD><TD class="tvalue" align="center"><a href="javascript:delete_cur(<?php echo $row[0]; ?>)"><img src="images/delete.gif"></a></TD></TR><?php
}
?>
<TR><TD></TD></TR>
</table>
<?php
}
?>
</div>
