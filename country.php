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

//Add country
if(isset($_POST['submitcountry'])){
$sql = "insert into country(country) values('" .$_POST['country'] ."')";
$db->query($sql);
}

//Edit country
if(isset($_POST['editcountry'])){
	$sql = "update country set country='" .$_POST['country'] ."' where id=" .$_POST['country_id'];
	$db->query($sql);
}

//Delete country
if(isset($_GET['delete'])){
$sql = "delete from country where id=" .$_GET['delete'];
$db->query($sql);
}
?>
<div class="admin_content">
	<script language="JavaScript">
  function validate_form(frm){
    if(frm.country.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
  function validate_edit_form(frm){
    if(frm.country.value==""){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
</script>
<?php
if(isset($_GET['edit'])){
	$sql = "select country from country where id=" .$_GET['edit'];
	$result = $db->query($sql);
	$country = mysql_fetch_row($result);
?>
<form action="admin.php?action=country" onsubmit="return validate_form(this)" method="POST">
<input type="hidden" name="country_id" value="<?php echo $_GET['edit']; ?>">
<?php echo HDR_COUNTRY; ?>: <input type="text" size="30" name="country" value="<?php echo htmlspecialchars($country[0]); ?>"> 
<input type="submit" name="editcountry" value="<?php echo TXT_SAVE; ?>">
</form>
<?php
}
else{
?>
<form action="admin.php?action=country" onsubmit="return validate_edit_form(this)" method="POST">
<?php echo ADD_NEW_COUNTRY; ?>:<br>
<input type="text" size="30" name="country"> <input type="submit" name="submitcountry" value="<?php echo COUNTRY_SUBMIT; ?>">
</form>
<br>
<script language="JavaScript">
  function delete_cur(i){
    op = confirm("<?php echo CONFIRM_DELETE; ?>");
    if(op)document.location.href="admin.php?action=country&delete="+i;
  }
</script>
<table cellspacing="0">
<TR><TH width="300"><?php echo HDR_COUNTRY; ?></TH><TH><?php echo TXT_EDIT; ?></TH><TH><?php echo TXT_DELETE; ?></TH></TR>
<?php
$sql = "select * from country order by country ASC";
$result = $db->query($sql);
while($row = mysql_fetch_row($result)){
	?><TR><TD class="btvalue"><?php echo htmlspecialchars($row[1]); ?></a></TD><TD class="tvalue" align="center"><a href="admin.php?action=country&edit=<?php echo $row[0]; ?>"><img src="images/edit.gif"></a></TD><TD class="tvalue" align="center"><a href="javascript:delete_cur(<?php echo $row[0]; ?>)"><img src="images/delete.gif"></a></TD></TR><?php
}
?>
<TR><TD></TD></TR>
</table>
<?php
}
?>
</div>
