<?php

// Purchase_Number
// Purchase_Date
// Supplier_ID
// Total_Amount
// Total_Payment
// Total_Balance

?>
<?php if ($a_purchases->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $a_purchases->TableCaption() ?></h4> -->
<div id="t_a_purchases" class="ewGrid <?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>">
<table id="tbl_a_purchasesmaster" class="table ewTable">
	<thead>
		<tr>
<?php if ($a_purchases->Purchase_Number->Visible) { // Purchase_Number ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Purchase_Number->FldCaption() ?></th>
<?php } ?>
<?php if ($a_purchases->Purchase_Date->Visible) { // Purchase_Date ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Purchase_Date->FldCaption() ?></th>
<?php } ?>
<?php if ($a_purchases->Supplier_ID->Visible) { // Supplier_ID ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Supplier_ID->FldCaption() ?></th>
<?php } ?>
<?php if ($a_purchases->Total_Amount->Visible) { // Total_Amount ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Total_Amount->FldCaption() ?></th>
<?php } ?>
<?php if ($a_purchases->Total_Payment->Visible) { // Total_Payment ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Total_Payment->FldCaption() ?></th>
<?php } ?>
<?php if ($a_purchases->Total_Balance->Visible) { // Total_Balance ?>
			<th class="ewTableHeader"><?php echo $a_purchases->Total_Balance->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($a_purchases->Purchase_Number->Visible) { // Purchase_Number ?>
			<td<?php echo $a_purchases->Purchase_Number->CellAttributes() ?>>
<span id="el_a_purchases_Purchase_Number" class="form-group">
<span<?php echo $a_purchases->Purchase_Number->ViewAttributes() ?>>
<?php echo $a_purchases->Purchase_Number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_purchases->Purchase_Date->Visible) { // Purchase_Date ?>
			<td<?php echo $a_purchases->Purchase_Date->CellAttributes() ?>>
<span id="el_a_purchases_Purchase_Date" class="form-group">
<span<?php echo $a_purchases->Purchase_Date->ViewAttributes() ?>>
<?php echo $a_purchases->Purchase_Date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_purchases->Supplier_ID->Visible) { // Supplier_ID ?>
			<td<?php echo $a_purchases->Supplier_ID->CellAttributes() ?>>
<span id="el_a_purchases_Supplier_ID" class="form-group">
<span<?php echo $a_purchases->Supplier_ID->ViewAttributes() ?>>
<?php echo $a_purchases->Supplier_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_purchases->Total_Amount->Visible) { // Total_Amount ?>
			<td<?php echo $a_purchases->Total_Amount->CellAttributes() ?>>
<span id="el_a_purchases_Total_Amount" class="form-group">
<span<?php echo $a_purchases->Total_Amount->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_purchases->Total_Payment->Visible) { // Total_Payment ?>
			<td<?php echo $a_purchases->Total_Payment->CellAttributes() ?>>
<span id="el_a_purchases_Total_Payment" class="form-group">
<span<?php echo $a_purchases->Total_Payment->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Payment->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($a_purchases->Total_Balance->Visible) { // Total_Balance ?>
			<td<?php echo $a_purchases->Total_Balance->CellAttributes() ?>>
<span id="el_a_purchases_Total_Balance" class="form-group">
<span<?php echo $a_purchases->Total_Balance->ViewAttributes() ?>>
<?php echo $a_purchases->Total_Balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
