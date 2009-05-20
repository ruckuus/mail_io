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

//Add a bank account
if(isset($_POST['submitbankacc'])){
$sql = "insert into bank_accounts(bank_id, name, account_number, account_holder, remarks) values ('" .$_POST['bank_id'] ."','" .$_POST['name'] ."','" .$_POST['account_number'] ."','" .$_POST['account_holder'] ."','".$_POST['remarks'] ."')";
$db->query($sql);
}

//Edit bank account
if(isset($_POST['editbankacc'])){
$sql = "update bank_accounts set bank_id='" .$_POST['bank_id'] ."', name='" .$_POST['name'] ."', account_number='" .$_POST['account_number'] ."', account_holder='" .$_POST['account_holder']."', remarks='".$_POST['remarks']."' where id=" .$_POST['acc_id'];
$db->query($sql);
}

//Delete bank account
if(isset($_GET['delete'])){
$sql = "delete from bank_accounts where id=" .$_GET['delete'];
$db->query($sql);
}

?>

<div class="admin_content">

<script language="JavaScript">
  function validate_form(frm){
    if(frm.name.value=="" || frm.account_number.value=="" || frm.account_holder.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
  function validate_edit_form(frm){
    if(frm.name.value=="" || frm.account_number.value=="" || frm.account_holder.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
</script>

<?php
if(isset($_GET['edit'])){
$sql = "select * from bank_accounts where id=" .$_GET['edit'];
$result = $db->query($sql);
$row = mysql_fetch_row($result);
?>
<form action="admin.php?action=bank_accounts" onsubmit="return validate_edit_form(this);" method="POST">
<input type="hidden" name="acc_id" value="<?php echo htmlspecialchars($row[0]); ?>">
<table>
<TR><TD><?php echo TXT_BANK_ID; ?></TD><TD><select name="bank_id"><OPTION value="0">---</OPTION>
<?php
$resultx = $db->query("select id,name from banks");
while($bank = mysql_fetch_row($resultx)){
?><option value="<?php echo $bank[0]; ?>" <?php if(isset($_GET['edit']) && $row[1]==$bank[0]) echo "SELECTED"; ?>><?php echo $bank[1]; ?></option><?php
}
?>
</select></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_NAME; ?></TD><TD><input type="text" name="name" size="40" value="<?php echo htmlspecialchars($row[2]); ?>"></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_NO; ?></TD><TD><input type="text" name="account_number" value="<?php echo htmlspecialchars($row[3]); ?>"></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_HOLDER; ?></TD><TD><input type="text" name="account_holder" value="<?php echo htmlspecialchars($row[4]); ?>"></TD></TR>
<TR><TD colspan="2"><input type="submit" name="editbankacc" value="<?php echo TXT_SAVE ?>"></TD></TR>
</table>
</form>
<?php
}
else{
?>
<form action="admin.php?action=bank_accounts" onsubmit="return validate_form(this);" method="POST">
<?php echo ADD_NEW_BANK_ACCOUNT; ?>:<br>
<table>

<TR><TD><?php echo TXT_BANK_ID; ?></TD><TD><select name="bank_id"><OPTION value="0">---</OPTION>
<?php
$result = $db->query("select id,name from banks");
while($bank = mysql_fetch_row($result)){
?><option value="<?php echo $bank[0]; ?>" <?php if(isset($_GET['edit']) && $row[1]==$bank[0]) echo "SELECTED"; ?>><?php echo $bank[1]; ?></option><?php
}
?>
</select></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_NAME; ?></TD><TD><input type="text" name="name" size="40"></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_NO; ?></TD><TD><input type="text" name="account_number"></TD></TR>
<TR><TD><?php echo TXT_BANK_ACC_HOLDER; ?></TD><TD><input type="text" name="account_holder"></TD></TR>
<TR><TD colspan="2"><input type="submit" name="submitbankacc" value="<?php echo BANK_ACC_SUBMIT ?>"></TD></TR>
</table>
</form>
<br>
<script language="JavaScript">
  function delete_bank_account(acc){
    op = confirm("<?php echo CONFIRM_DELETE_BANK_ACC; ?>");
    if(op)document.location.href="admin.php?action=bank_accounts&delete="+acc;
  }
</script>
<table cellspacing="0">
<TR><TH width="150"><?php echo TXT_BANK_ACC_NAME; ?></TH><TH width="200"><?php echo TXT_BANK_ACC_NO; ?></TH><TH><?php echo TXT_EDIT; ?></TH><TH><?php echo TXT_DELETE; ?></TH></TR>
<?php
$sql = "select * from bank_accounts order by name ASC";
$result = $db->query($sql);
while($row = mysql_fetch_row($result)){
?><TR><TD class="tvalue"><?php echo htmlspecialchars($row[2]); ?></TD><TD class="tvalue"><?php echo htmlspecialchars($row[3]); ?></TD><TD class="tvalue" align="center"><a href="admin.php?action=bank_accounts&edit=<?php echo $row[0]; ?>"><img src="images/edit.gif"></a></TD><TD class="tvalue" align="center"><a href="javascript:delete_bank_account(<?php echo $row[0]; ?>)"><img src="images/delete.gif"></a></TD></TR><?php
}
?>
<TR><TD></TD></TR>
</table>
<?php
}
?>
</div>
