<?php
/*
  PHPWPos, Open Source Point-Of-Sale System
  http://phpwpos.ptwebserve.com

  Copyright (c) 2006 Moisés Sequeira

  Released under the GNU General Public License
*/

session_start();
if(!isset($_SESSION['admin'])){
header("Location:admin.php");
}

//Add a new user
if(isset($_POST['submituser'])){
$sql = "insert into users(uaccess,first_name, last_name, username, password, type) values ('".$_POST['uaccess']."','" .$_POST['firstname'] ."','" .$_POST['lastname'] ."','" .$_POST['username'] ."','" .md5($_POST['password']) ."','')";
$db->query($sql);

if (P_DEBUG) {
	echo $sql;
}
}

//Edit user data
if(isset($_POST['edituser'])){
$sql = "update users set uaccess='" .$_POST['uaccess'] ."', first_name='" .$_POST['firstname'] ."', last_name='" .$_POST['lastname'] ."', username='" .$_POST['username'] ."' " .($_POST['password']=="" ? "" : ",password='" .md5($_POST['password']) ."' ") ."where id=" .$_POST['user_id'];
$db->query($sql);
}

//Delete an user
if(isset($_GET['delete'])){
$sql = "delete from users where id=" .$_GET['delete'];
$db->query($sql);
}

?>

<div class="admin_content">

<script language="JavaScript">
  function validate_form(frm){
    if(frm.uaccess.value=="" || frm.firstname.value=="" || frm.lastname.value=="" || frm.username.value=="" || frm.password.value=="" || frm.password.value != frm.confirm_password.value){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
  function validate_edit_form(frm){
    if(frm.uaccess.value=="" || frm.firstname.value=="" || frm.lastname.value=="" || frm.username.value=="" || frm.password.value != frm.confirm_password.value){
      alert("Error, verify fields!");
      return false;
    }
    else return true;
  }
</script>

<?php
if(isset($_GET['edit'])){
$sql = "select * from users where id=" .$_GET['edit'];
$result = $db->query($sql);
$row = mysql_fetch_row($result);
if (P_DEBUG) {
	echo $sql."<BR>";
}
?>
<form action="admin.php?action=users" onsubmit="return validate_edit_form(this);" method="POST">
<input type="hidden" name="user_id" value="<?php echo $_GET['edit']; ?>">
<table>
<TR><TD><?php echo TXT_UACCESS; ?></TD><TD>
<select name="uaccess"><OPTION value="0">---</OPTION>
<?php
$resultx = $db->query("select id,access,title from uaccess");
while($uaccess = mysql_fetch_row($resultx)){
?><option value="<?php echo $uaccess[0]; ?>" <?php if(isset($_GET['edit']) && $row[1]==$uaccess[0]) echo "SELECTED"; ?>><?php echo $uaccess[2]; ?></option><?php
}
?>
</select>
</TD></TR>
<TR><TD><?php echo TXT_FIRSTNAME; ?></TD><TD><input type="text" name="firstname" size="40" value="<?php echo htmlspecialchars($row[2]); ?>"></TD></TR>
<TR><TD><?php echo TXT_LASTNAME; ?></TD><TD><input type="text" name="lastname" size="40" value="<?php echo htmlspecialchars($row[3]); ?>"></TD></TR>
<TR><TD><?php echo TXT_USERNAME; ?></TD><TD><input type="text" name="username" value="<?php echo htmlspecialchars($row[4]); ?>"></TD></TR>
<TR><TD><?php echo LOGIN_PASSWORD; ?></TD><TD><input type="password" name="password" value="">(*)</TD></TR>
<TR><TD><?php echo LOGIN_CONFIRM_PASSWORD; ?></TD><TD><input type="password" name="confirm_password"></TD></TR>
<TR><TD colspan="2"><small>(*)<?php echo EDIT_PASSWORD_INFO; ?></small></TD></TR>
<TR><TD colspan="2"><input type="submit" name="edituser" value="<?php echo TXT_SAVE ?>"></TD></TR>
</table>
</form>
<?php
}
else{
?>
<form action="admin.php?action=users" onsubmit="return validate_form(this);" method="POST">
<?php echo ADD_NEW_USER; ?>:<br>
<table>
<TR><TD><?php echo TXT_UACCESS; ?></TD><TD>
<select name="uaccess"><OPTION value="0">---</OPTION>
<?php
$result = $db->query("select id,access,title from uaccess");
while($uaccess = mysql_fetch_row($result)){
?><option value="<?php echo $uaccess[0]; ?>"><?php echo $uaccess[2]; ?></option><?php
}
?>
</select>
</TD></TR>
<TR><TD><?php echo TXT_FIRSTNAME; ?></TD><TD><input type="text" name="firstname" size="40"></TD></TR>
<TR><TD><?php echo TXT_LASTNAME; ?></TD><TD><input type="text" name="lastname" size="40"></TD></TR>
<TR><TD><?php echo TXT_USERNAME; ?></TD><TD><input type="text" name="username"></TD></TR>
<TR><TD><?php echo LOGIN_PASSWORD; ?></TD><TD><input type="password" name="password"></TD></TR>
<TR><TD><?php echo LOGIN_CONFIRM_PASSWORD; ?></TD><TD><input type="password" name="confirm_password"></TD></TR>
<TR><TD colspan="2"><input type="submit" name="submituser" value="<?php echo USER_SUBMIT ?>"></TD></TR>
</table>
</form>
<br>
<script language="JavaScript">
  function delete_user(user){
    op = confirm("<?php echo CONFIRM_DELETE_USER; ?>");
    if(op)document.location.href="admin.php?action=users&delete="+user;
  }
</script>
<table cellspacing="0">
<TR><TH width="150"><?php echo TXT_USERNAME; ?></TH><TH width="150"><?php echo TXT_NAME; ?></TH><TH width="150"><?php echo TXT_TITLE_UACCESS; ?></TH><TH><?php echo TXT_EDIT; ?></TH><TH><?php echo TXT_DELETE; ?></TH></TR>
<?php
$sql = "select * from users order by first_name ASC";
$result = $db->query($sql);
while($row = mysql_fetch_row($result)){
	$i = $row[1];
	$sql = "select title from uaccess where id=".$i.";";
	$res = $db->query($sql);
	if (P_DEBUG) {
		echo $sql."<BR>";
	}
	while($r = mysql_fetch_row($res)) {
		$title = $r[0];
	}

?><TR><TD class="tvalue"><?php echo htmlspecialchars($row[2] ." " .$row[3]); ?></TD><TD class="tvalue"><?php echo htmlspecialchars($row[4]); ?></TD><TD class="tvalue"><?php echo htmlspecialchars($title); ?></TD><TD class="tvalue" align="center"><a href="admin.php?action=users&edit=<?php echo $row[0]; ?>"><img src="images/edit.gif"></a></TD><TD class="tvalue" align="center"><a href="javascript:delete_user(<?php echo $row[0]; ?>)"><img src="images/delete.gif"></a></TD></TR><?php
}
?>
<TR><TD></TD></TR>
</table>
<?php
}
?>
</div>
