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

/* Get last customer ID */
$sql = "SELECT id FROM customers order by id desc limit 1";
$res = $db->query($sql);
while ($row = mysql_fetch_row($res)) {
	$cust_postfix = $row[0];
}
$cust_postfix = $cust_postfix+1;
$cust_acc = CUST_PREFIX.$cust_postfix;

//Add new item
if(isset($_POST['submit_item'])){
//Upload image file
$item_image="images/items/" .(isset($_FILES['item_image']['name']) && $_FILES['item_image']['name']!="" ? $_FILES['item_image']['name'] : "item.png");
move_uploaded_file ($_FILES['item_image']['tmp_name'],"images/items/".$_FILES['item_image']['name']);
//insert item in the database
$sql = "insert into items(item_name, item_number, description, brand_id, category_id, supplier_id, buy_price, unit_price, supplier_item_number, tax_percent, total_cost, quantity, reorder_level, image) values(
'" .$_POST['item_name'] ."',
'" .$_POST['item_number'] ."',
'" .$_POST['description'] ."',
" .$_POST['brand_id'] .",
" .$_POST['category_id'] .",
" .$_POST['supplier_id'] .",
'" .$_POST['buy_price'] ."',
'" .$_POST['unit_price'] ."',
'" .$_POST['supplier_item_number'] ."',
'" .$_POST['tax_percent'] ."',
'" .$_POST['total_cost'] ."',
" .$_POST['quantity'] .",
" .$_POST['reorder_level'] .",
'" .$item_image ."')";
$db->query($sql);
}

//Edit an item
if(isset($_POST['edit_item'])){
//Upload a new image file if the user has selected one
$item_image="images/items/" .(isset($_FILES['item_image']['name']) && $_FILES['item_image']['name']!="" ? $_FILES['item_image']['name'] : "");
move_uploaded_file ($_FILES['item_image']['tmp_name'],"images/items/".$_FILES['item_image']['name']);
//Save values
$sql = "update items set 
item_name = '" .$_POST['item_name'] ."',
item_number = '" .$_POST['item_number'] ."',
description = '" .$_POST['description'] ."',
brand_id = " .$_POST['brand_id'] .",
category_id = " .$_POST['category_id'] .",
supplier_id = " .$_POST['supplier_id'] .",
buy_price = '" .$_POST['buy_price'] ."',
unit_price = '" .$_POST['unit_price'] ."',
supplier_item_number = '" .$_POST['supplier_item_number'] ."',
tax_percent = '" .$_POST['tax_percent'] ."',
total_cost = '" .$_POST['total_cost'] ."',
quantity = " .$_POST['quantity'] .",
reorder_level = " .$_POST['reorder_level'] .(isset($_FILES['item_image']['name']) && $_FILES['item_image']['name']!="" ? ",image = '" .$item_image ."'" : "") ." 
where id=" .$_POST['item_id'];
$db->query($sql);
}


//Delete item
if(isset($_GET['delete'])){
$sql = "delete from items where id=" .$_GET['delete'];
$db->query($sql);
}

?>
<div class="admin_content">
<?php
//Add a new item
/*if(isset($_GET['add_item']) || isset($_GET['edit_item'])){
  //Get the items values that we want to edit
  if(isset($_GET['edit_item'])){
    $result = $db->query("select * from items where id=" .$_GET['edit_item']);
    $row = mysql_fetch_row($result);
  } */
?>
<script language="JavaScript">
  function setPrice(t){
    var uprice = parseFloat(document.forms['frm_new_item'].elements['unit_price'].value);
    var taxperc = parseFloat(document.forms['frm_new_item'].elements['tax_percent'].value);
    var total = parseFloat(document.forms['frm_new_item'].elements['total_cost'].value);
    //When we change the unit price or tax percent fields
    if(t==1){
      total = toCurrency(uprice*(1+taxperc/100));
      document.forms['frm_new_item'].elements['total_cost'].value = total;
    }
    //When we change the total price field
    if(t==2){
      uprice = toCurrency(total/(1+taxperc/100));
      document.forms['frm_new_item'].elements['unit_price'].value = uprice;
    }
  } 
</script>
<form name="frm_new_item" action="admin.php?action=products" enctype="multipart/form-data" method="POST">
<?php if(isset($_GET['edit_item']))echo '<input type="hidden" name="item_id" value="' .htmlspecialchars($row[0]) .'">'; ?>
<table>
 <!-- CUSTOMER INFO -->
		  <TR>
	            <TD>
	              <div id="customerDiv0">&nbsp;</div>
	              <div id="customerDiv1">
	                <div id="customer_menu"><a href="javascript:showCustomerDiv(2)"><?php echo ADD_NEW_CUSTOMER; ?></a> | <a href="javascript:showCustomerDiv(0)"><?php echo TXT_CLOSE; ?></a>
	                </div>
	  	        <table><tr><td><input type="text" id="findcustomertext"></td><td><input type="button" value="<?php echo TXT_FIND; ?>" onClick="javascript:loadXMLDoc('','getCustomers')"></td></tr></table>
			<table id="findcustomerstable"><tr><td></td></tr></table>
			<div id="findCustomersDiv"></div>
		      </div>
		      <div id="customerDiv2"> 
			<div id="customer_menu"><a href="javascript:showCustomerDiv(0)"><?php echo TXT_CLOSE; ?></a>
	                </div>
			<!-- Add Customer -->
			<form name="fe_addcustomer_form">
<input type="hidden" name="account_number" value="<?php echo $cust_acc;?>">
			<table>
			<TR><TD><?php echo TXT_ACCOUNT_NUMBER; ?></TD><TD><?php echo $cust_acc; ?></TD></TR>
			<TR><TD><?php echo TXT_FIRSTNAME; ?></TD><TD><input type="text" name="firstname" size="40"></TD></TR>
			<TR><TD><?php echo TXT_LASTNAME; ?></TD><TD><input type="text" name="lastname" size="40"></TD></TR>
			<TR><TD><?php echo TXT_ADDRESS; ?></TD><TD><input type="text" size="60" name="address"></TD></TR>
			<TR><TD><?php echo TXT_CITY; ?></TD><TD><input type="text" size="40" name="city"></TD></TR>
			<TR><TD><?php echo TXT_PCODE; ?></TD><TD><input type="text" size="20" name="pcode"></TD></TR>
			<TR><TD><?php echo TXT_STATE; ?></TD><TD><input type="text" size="40" name="state"></TD></TR>
			<TR><TD><?php echo TXT_COUNTRY; ?></TD>
<TD>
<select name="country"><OPTION value="0">---</OPTION>
<?php
$result = $db->query("select id,country from country");
while($country = mysql_fetch_row($result)){
?><option value="<?php echo $country[0]; ?>" <?php if(isset($_GET['edit_item']) && $row[4]==$country[0]) echo "SELECTED"; ?>><?php echo $country[1]; ?></option><?php
}
?>
</select>
</TD></TR>
			<TR><TD><?php echo TXT_PHONE; ?></TD><TD><input type="text" size="20" name="phone_number"></TD></TR>
			<TR><TD><?php echo TXT_EMAIL; ?></TD><TD><input type="text" size="60" name="email"></TD></TR>
			<TR><TD valign="top"><?php echo TXT_COMMENTS; ?></TD><TD><textarea rows="5" cols="50" name="comments"></textarea></TD></TR>
			<TR><TD colspan="2"><input type="button" value="<?php echo CUSTOMER_SUBMIT; ?>" onClick="javascript:loadXMLDoc('','addCustomer')"></TD></TR>
			</table>
			</form>
		      </div>
		    </TD>
		    <TD valign="top"><INPUT id="customerButton" TYPE="button" onClick="showCustomerDiv(1)" value="<?php echo TXT_CUSTOMER; ?>">
		    </TD>
		  </TR>
	      <!-- END CUSTOMER INFO -->
<TR><TD><?php echo TXT_CURRENCY; ?></TD>
<TD>
<select name="category_id"><OPTION value="0">---</OPTION>
<?php
$result = $db->query("select id,category from categories order by category ASC");
while($categories = mysql_fetch_row($result)){
?><option value="<?php echo $categories[0]; ?>" <?php if(isset($_GET['edit_item']) && $row[5]==$categories[0]) echo "SELECTED"; ?>><?php echo $categories[1]; ?></option><?php
}
?>
</select>
</TD></TR>
<TR></TR>
<TR><TD><?php echo TXT_X_PRICE; ?></TD><TD></TD></TR>
<TR><TD><?php echo TXT_UNIT_PRICE; ?></TD><TD><input type="text" name="unit_price" <?php if(isset($_GET['edit_item']))echo 'value="' .htmlspecialchars($row[8]) .'"'; ?> onchange="setPrice(1)"></TD></TR>
<TR><TD><?php echo TXT_AMOUNT; ?></TD><TD><input type="text" name="quantity" <?php if(isset($_GET['edit_item']))echo 'value="' .htmlspecialchars($row[12]) .'"'; ?>></TD></TR>
<TR><TD><?php echo TXT_TOTAL; ?></TD><TD><input type="text" name="total" <?php if(isset($_GET['edit_item']))echo 'value="' .htmlspecialchars($row[12]) .'"'; ?>></TD></TR>
<TR><TD><?php echo TXT_PAID_WITH; ?></TD><TD><input type="text" name="paid_with" <?php if(isset($_GET['edit_item']))echo 'value="' .htmlspecialchars($row[12]) .'"'; ?>></TD></TR>
<TR><TD valign="top"><?php echo TXT_REMARKS; ?></TD>
<TD>
<textarea rows="4" cols="40" name="description"><?php if(isset($_GET['edit_item']))echo htmlspecialchars($row[3]); ?></textarea>
</TD></TR> 
<TR><TD><input type="submit" <?php if(isset($_GET['edit_item'])) echo 'name="edit_item" value="' .TXT_SAVE .'"'; else echo 'name="submit_item" value="' .ADD_ITEM .'"'; ?>></TD></TR>
</table>
</form>
</div>
