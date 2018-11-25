<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "a_suppliersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "a_purchasesgridcls.php" ?>
<?php include_once "a_stock_itemsgridcls.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$a_suppliers_update = NULL; // Initialize page object first

class ca_suppliers_update extends ca_suppliers {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{B36B93AF-B58F-461B-B767-5F08C12493E9}";

	// Table name
	var $TableName = 'a_suppliers';

	// Page object name
	var $PageObjName = 'a_suppliers_update';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {

		// $hidden = TRUE;
		$hidden = MS_USE_JAVASCRIPT_MESSAGE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display

			// if (!$hidden)
			//	 $sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			// $html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			// Begin of modification Auto Hide Message, by Masino Sinaga, January 24, 2013

			if (@MS_AUTO_HIDE_SUCCESS_MESSAGE) {

				//$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
				$html .= "<p class=\"alert alert-success msSuccessMessage\" id=\"ewSuccessMessage\">" . $sSuccessMessage . "</p>";
			} else {
				if (!$hidden)
					$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
				$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			}

			// End of modification Auto Hide Message, by Masino Sinaga, January 24, 2013
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}

		// echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
		if (@MS_AUTO_HIDE_SUCCESS_MESSAGE || MS_USE_JAVASCRIPT_MESSAGE==0) {
			echo $html;
		} else {
			if (MS_USE_ALERTIFY_FOR_MESSAGE_DIALOG) {
				if ($html <> "") {
					$html = str_replace("'", "\'", $html);
					echo "<script type='text/javascript'>alertify.alert('".$html."', function (ok) { }, ewLanguage.Phrase('AlertifyAlert'));</script>";
				}
			} else {
				echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
			}
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (a_suppliers)
		if (!isset($GLOBALS["a_suppliers"]) || get_class($GLOBALS["a_suppliers"]) == "ca_suppliers") {
			$GLOBALS["a_suppliers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["a_suppliers"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// User table object (users)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'a_suppliers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		if (!isset($_SESSION['table_a_suppliers_views'])) { 
			$_SESSION['table_a_suppliers_views'] = 0;
		}
		$_SESSION['table_a_suppliers_views'] = $_SESSION['table_a_suppliers_views']+1;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("a_supplierslist.php"));
		}

		// Begin of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		if (IsLoggedIn() && !IsSysAdmin()) {

			// Begin of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.           
			$UserProfile->LoadProfileFromDatabase(CurrentUserName());

			// End of modification by Masino Sinaga, May 25, 2012 in order to not autologout after clear another user's session ID whenever back to another page.
			// Begin of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012

			$lastpage = ew_CurrentPage();
			if ($lastpage!='logout.php' && $lastpage!='index.php') {
				$lasturl = ew_CurrentUrl();
				$sFilterUserID = str_replace("%u", ew_AdjustSql(CurrentUserName()), EW_USER_NAME_FILTER);
				ew_Execute("UPDATE ".EW_USER_TABLE." SET Current_URL = '".$lasturl."' WHERE ".$sFilterUserID."");
			}

			// End of modification Save Last Users' Visitted Page, by Masino Sinaga, May 25, 2012
			$LastAccessDateTime = strval(@$UserProfile->Profile[EW_USER_PROFILE_LAST_ACCESSED_DATE_TIME]);
			$nDiff = intval(ew_DateDiff($LastAccessDateTime, ew_StdCurrentDateTime(), "s"));
			$nCons = intval(MS_AUTO_LOGOUT_AFTER_IDLE_IN_MINUTES) * 60;
			if ($nDiff > $nCons) {
				header("Location: logout.php");
			}
		}

		// End of modification Auto Logout After Idle for the Certain Time, by Masino Sinaga, May 5, 2012
		// Update last accessed time

		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {

			// Do nothing since it's a valid user! SaveProfileToDatabase has been handled from IsValidUser method of UserProfile object.
		} else {

			// Begin of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
			// echo $Language->Phrase("UserProfileCorrupted");

			header("Location: logout.php");

			// End of modification How to Overcome "User X already logged in" Issue, by Masino Sinaga, July 22, 2014
		}
		if (@MS_USE_CONSTANTS_IN_CONFIG_FILE == FALSE) {

			// Call this new function from userfn*.php file
			My_Global_Check();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

// Begin of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
// End of modification Disable/Enable Registration Page, by Masino Sinaga, May 14, 2012
		// Page Load event

		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'a_purchases'
			if (@$_POST["grid"] == "fa_purchasesgrid") {
				if (!isset($GLOBALS["a_purchases_grid"])) $GLOBALS["a_purchases_grid"] = new ca_purchases_grid;
				$GLOBALS["a_purchases_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'a_stock_items'
			if (@$_POST["grid"] == "fa_stock_itemsgrid") {
				if (!isset($GLOBALS["a_stock_items_grid"])) $GLOBALS["a_stock_items_grid"] = new ca_stock_items_grid;
				$GLOBALS["a_stock_items_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $a_suppliers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($a_suppliers);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("a_supplierslist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Supplier_Number->setDbValue($this->Recordset->fields('Supplier_Number'));
					$this->Supplier_Name->setDbValue($this->Recordset->fields('Supplier_Name'));
					$this->Address->setDbValue($this->Recordset->fields('Address'));
					$this->City->setDbValue($this->Recordset->fields('City'));
					$this->Country->setDbValue($this->Recordset->fields('Country'));
					$this->Contact_Person->setDbValue($this->Recordset->fields('Contact_Person'));
					$this->Phone_Number->setDbValue($this->Recordset->fields('Phone_Number'));
					$this->_Email->setDbValue($this->Recordset->fields('Email'));
					$this->Mobile_Number->setDbValue($this->Recordset->fields('Mobile_Number'));
					$this->Notes->setDbValue($this->Recordset->fields('Notes'));
					$this->Balance->setDbValue($this->Recordset->fields('Balance'));
					$this->Is_Stock_Available->setDbValue($this->Recordset->fields('Is_Stock_Available'));
					$this->Date_Added->setDbValue($this->Recordset->fields('Date_Added'));
					$this->Added_By->setDbValue($this->Recordset->fields('Added_By'));
					$this->Date_Updated->setDbValue($this->Recordset->fields('Date_Updated'));
					$this->Updated_By->setDbValue($this->Recordset->fields('Updated_By'));
				} else {
					if (!ew_CompareValue($this->Supplier_Number->DbValue, $this->Recordset->fields('Supplier_Number')))
						$this->Supplier_Number->CurrentValue = NULL;
					if (!ew_CompareValue($this->Supplier_Name->DbValue, $this->Recordset->fields('Supplier_Name')))
						$this->Supplier_Name->CurrentValue = NULL;
					if (!ew_CompareValue($this->Address->DbValue, $this->Recordset->fields('Address')))
						$this->Address->CurrentValue = NULL;
					if (!ew_CompareValue($this->City->DbValue, $this->Recordset->fields('City')))
						$this->City->CurrentValue = NULL;
					if (!ew_CompareValue($this->Country->DbValue, $this->Recordset->fields('Country')))
						$this->Country->CurrentValue = NULL;
					if (!ew_CompareValue($this->Contact_Person->DbValue, $this->Recordset->fields('Contact_Person')))
						$this->Contact_Person->CurrentValue = NULL;
					if (!ew_CompareValue($this->Phone_Number->DbValue, $this->Recordset->fields('Phone_Number')))
						$this->Phone_Number->CurrentValue = NULL;
					if (!ew_CompareValue($this->_Email->DbValue, $this->Recordset->fields('Email')))
						$this->_Email->CurrentValue = NULL;
					if (!ew_CompareValue($this->Mobile_Number->DbValue, $this->Recordset->fields('Mobile_Number')))
						$this->Mobile_Number->CurrentValue = NULL;
					if (!ew_CompareValue($this->Notes->DbValue, $this->Recordset->fields('Notes')))
						$this->Notes->CurrentValue = NULL;
					if (!ew_CompareValue($this->Balance->DbValue, $this->Recordset->fields('Balance')))
						$this->Balance->CurrentValue = NULL;
					if (!ew_CompareValue($this->Is_Stock_Available->DbValue, $this->Recordset->fields('Is_Stock_Available')))
						$this->Is_Stock_Available->CurrentValue = NULL;
					if (!ew_CompareValue($this->Date_Added->DbValue, $this->Recordset->fields('Date_Added')))
						$this->Date_Added->CurrentValue = NULL;
					if (!ew_CompareValue($this->Added_By->DbValue, $this->Recordset->fields('Added_By')))
						$this->Added_By->CurrentValue = NULL;
					if (!ew_CompareValue($this->Date_Updated->DbValue, $this->Recordset->fields('Date_Updated')))
						$this->Date_Updated->CurrentValue = NULL;
					if (!ew_CompareValue($this->Updated_By->DbValue, $this->Recordset->fields('Updated_By')))
						$this->Updated_By->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Supplier_ID->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $conn, $Language;
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Supplier_Number->FldIsDetailKey) {
			$this->Supplier_Number->setFormValue($objForm->GetValue("x_Supplier_Number"));
		}
		$this->Supplier_Number->MultiUpdate = $objForm->GetValue("u_Supplier_Number");
		if (!$this->Supplier_Name->FldIsDetailKey) {
			$this->Supplier_Name->setFormValue($objForm->GetValue("x_Supplier_Name"));
		}
		$this->Supplier_Name->MultiUpdate = $objForm->GetValue("u_Supplier_Name");
		if (!$this->Address->FldIsDetailKey) {
			$this->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		$this->Address->MultiUpdate = $objForm->GetValue("u_Address");
		if (!$this->City->FldIsDetailKey) {
			$this->City->setFormValue($objForm->GetValue("x_City"));
		}
		$this->City->MultiUpdate = $objForm->GetValue("u_City");
		if (!$this->Country->FldIsDetailKey) {
			$this->Country->setFormValue($objForm->GetValue("x_Country"));
		}
		$this->Country->MultiUpdate = $objForm->GetValue("u_Country");
		if (!$this->Contact_Person->FldIsDetailKey) {
			$this->Contact_Person->setFormValue($objForm->GetValue("x_Contact_Person"));
		}
		$this->Contact_Person->MultiUpdate = $objForm->GetValue("u_Contact_Person");
		if (!$this->Phone_Number->FldIsDetailKey) {
			$this->Phone_Number->setFormValue($objForm->GetValue("x_Phone_Number"));
		}
		$this->Phone_Number->MultiUpdate = $objForm->GetValue("u_Phone_Number");
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		$this->_Email->MultiUpdate = $objForm->GetValue("u__Email");
		if (!$this->Mobile_Number->FldIsDetailKey) {
			$this->Mobile_Number->setFormValue($objForm->GetValue("x_Mobile_Number"));
		}
		$this->Mobile_Number->MultiUpdate = $objForm->GetValue("u_Mobile_Number");
		if (!$this->Notes->FldIsDetailKey) {
			$this->Notes->setFormValue($objForm->GetValue("x_Notes"));
		}
		$this->Notes->MultiUpdate = $objForm->GetValue("u_Notes");
		if (!$this->Balance->FldIsDetailKey) {
			$this->Balance->setFormValue($objForm->GetValue("x_Balance"));
		}
		$this->Balance->MultiUpdate = $objForm->GetValue("u_Balance");
		if (!$this->Is_Stock_Available->FldIsDetailKey) {
			$this->Is_Stock_Available->setFormValue($objForm->GetValue("x_Is_Stock_Available"));
		}
		$this->Is_Stock_Available->MultiUpdate = $objForm->GetValue("u_Is_Stock_Available");
		if (!$this->Date_Added->FldIsDetailKey) {
			$this->Date_Added->setFormValue($objForm->GetValue("x_Date_Added"));
			$this->Date_Added->CurrentValue = ew_UnFormatDateTime($this->Date_Added->CurrentValue, 0);
		}
		$this->Date_Added->MultiUpdate = $objForm->GetValue("u_Date_Added");
		if (!$this->Added_By->FldIsDetailKey) {
			$this->Added_By->setFormValue($objForm->GetValue("x_Added_By"));
		}
		$this->Added_By->MultiUpdate = $objForm->GetValue("u_Added_By");
		if (!$this->Date_Updated->FldIsDetailKey) {
			$this->Date_Updated->setFormValue($objForm->GetValue("x_Date_Updated"));
			$this->Date_Updated->CurrentValue = ew_UnFormatDateTime($this->Date_Updated->CurrentValue, 0);
		}
		$this->Date_Updated->MultiUpdate = $objForm->GetValue("u_Date_Updated");
		if (!$this->Updated_By->FldIsDetailKey) {
			$this->Updated_By->setFormValue($objForm->GetValue("x_Updated_By"));
		}
		$this->Updated_By->MultiUpdate = $objForm->GetValue("u_Updated_By");
		if (!$this->Supplier_ID->FldIsDetailKey)
			$this->Supplier_ID->setFormValue($objForm->GetValue("x_Supplier_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Supplier_ID->CurrentValue = $this->Supplier_ID->FormValue;
		$this->Supplier_Number->CurrentValue = $this->Supplier_Number->FormValue;
		$this->Supplier_Name->CurrentValue = $this->Supplier_Name->FormValue;
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->City->CurrentValue = $this->City->FormValue;
		$this->Country->CurrentValue = $this->Country->FormValue;
		$this->Contact_Person->CurrentValue = $this->Contact_Person->FormValue;
		$this->Phone_Number->CurrentValue = $this->Phone_Number->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Mobile_Number->CurrentValue = $this->Mobile_Number->FormValue;
		$this->Notes->CurrentValue = $this->Notes->FormValue;
		$this->Balance->CurrentValue = $this->Balance->FormValue;
		$this->Is_Stock_Available->CurrentValue = $this->Is_Stock_Available->FormValue;
		$this->Date_Added->CurrentValue = $this->Date_Added->FormValue;
		$this->Date_Added->CurrentValue = ew_UnFormatDateTime($this->Date_Added->CurrentValue, 0);
		$this->Added_By->CurrentValue = $this->Added_By->FormValue;
		$this->Date_Updated->CurrentValue = $this->Date_Updated->FormValue;
		$this->Date_Updated->CurrentValue = ew_UnFormatDateTime($this->Date_Updated->CurrentValue, 0);
		$this->Updated_By->CurrentValue = $this->Updated_By->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Load List page SQL
		$sSql = $this->SelectSQL();

		// Load recordset
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Supplier_ID->setDbValue($rs->fields('Supplier_ID'));
		$this->Supplier_Number->setDbValue($rs->fields('Supplier_Number'));
		$this->Supplier_Name->setDbValue($rs->fields('Supplier_Name'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->City->setDbValue($rs->fields('City'));
		$this->Country->setDbValue($rs->fields('Country'));
		$this->Contact_Person->setDbValue($rs->fields('Contact_Person'));
		$this->Phone_Number->setDbValue($rs->fields('Phone_Number'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Mobile_Number->setDbValue($rs->fields('Mobile_Number'));
		$this->Notes->setDbValue($rs->fields('Notes'));
		$this->Balance->setDbValue($rs->fields('Balance'));
		$this->Is_Stock_Available->setDbValue($rs->fields('Is_Stock_Available'));
		$this->Date_Added->setDbValue($rs->fields('Date_Added'));
		$this->Added_By->setDbValue($rs->fields('Added_By'));
		$this->Date_Updated->setDbValue($rs->fields('Date_Updated'));
		$this->Updated_By->setDbValue($rs->fields('Updated_By'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Supplier_ID->DbValue = $row['Supplier_ID'];
		$this->Supplier_Number->DbValue = $row['Supplier_Number'];
		$this->Supplier_Name->DbValue = $row['Supplier_Name'];
		$this->Address->DbValue = $row['Address'];
		$this->City->DbValue = $row['City'];
		$this->Country->DbValue = $row['Country'];
		$this->Contact_Person->DbValue = $row['Contact_Person'];
		$this->Phone_Number->DbValue = $row['Phone_Number'];
		$this->_Email->DbValue = $row['Email'];
		$this->Mobile_Number->DbValue = $row['Mobile_Number'];
		$this->Notes->DbValue = $row['Notes'];
		$this->Balance->DbValue = $row['Balance'];
		$this->Is_Stock_Available->DbValue = $row['Is_Stock_Available'];
		$this->Date_Added->DbValue = $row['Date_Added'];
		$this->Added_By->DbValue = $row['Added_By'];
		$this->Date_Updated->DbValue = $row['Date_Updated'];
		$this->Updated_By->DbValue = $row['Updated_By'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Balance->FormValue == $this->Balance->CurrentValue && is_numeric(ew_StrToFloat($this->Balance->CurrentValue)))
			$this->Balance->CurrentValue = ew_StrToFloat($this->Balance->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Supplier_ID
		// Supplier_Number
		// Supplier_Name
		// Address
		// City
		// Country
		// Contact_Person
		// Phone_Number
		// Email
		// Mobile_Number
		// Notes
		// Balance
		// Is_Stock_Available
		// Date_Added
		// Added_By
		// Date_Updated
		// Updated_By

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Supplier_Number
			$this->Supplier_Number->ViewValue = $this->Supplier_Number->CurrentValue;
			$this->Supplier_Number->ViewCustomAttributes = "";

			// Supplier_Name
			$this->Supplier_Name->ViewValue = $this->Supplier_Name->CurrentValue;
			$this->Supplier_Name->ViewCustomAttributes = "";

			// Address
			$this->Address->ViewValue = $this->Address->CurrentValue;
			$this->Address->ViewCustomAttributes = "";

			// City
			$this->City->ViewValue = $this->City->CurrentValue;
			$this->City->ViewCustomAttributes = "";

			// Country
			$this->Country->ViewValue = $this->Country->CurrentValue;
			$this->Country->ViewCustomAttributes = "";

			// Contact_Person
			$this->Contact_Person->ViewValue = $this->Contact_Person->CurrentValue;
			$this->Contact_Person->ViewCustomAttributes = "";

			// Phone_Number
			$this->Phone_Number->ViewValue = $this->Phone_Number->CurrentValue;
			$this->Phone_Number->ViewCustomAttributes = "";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->ViewCustomAttributes = "";

			// Mobile_Number
			$this->Mobile_Number->ViewValue = $this->Mobile_Number->CurrentValue;
			$this->Mobile_Number->ViewCustomAttributes = "";

			// Notes
			$this->Notes->ViewValue = $this->Notes->CurrentValue;
			$this->Notes->ViewCustomAttributes = "";

			// Balance
			$this->Balance->ViewValue = $this->Balance->CurrentValue;
			$this->Balance->ViewValue = ew_FormatCurrency($this->Balance->ViewValue, 2, -2, -2, -2);
			$this->Balance->CellCssStyle .= "text-align: right;";
			$this->Balance->ViewCustomAttributes = "";

			// Is_Stock_Available
			if (ew_ConvertToBool($this->Is_Stock_Available->CurrentValue)) {
				$this->Is_Stock_Available->ViewValue = $this->Is_Stock_Available->FldTagCaption(2) <> "" ? $this->Is_Stock_Available->FldTagCaption(2) : "Y";
			} else {
				$this->Is_Stock_Available->ViewValue = $this->Is_Stock_Available->FldTagCaption(1) <> "" ? $this->Is_Stock_Available->FldTagCaption(1) : "N";
			}
			$this->Is_Stock_Available->ViewCustomAttributes = "";

			// Date_Added
			$this->Date_Added->ViewValue = $this->Date_Added->CurrentValue;
			$this->Date_Added->ViewCustomAttributes = "";

			// Added_By
			$this->Added_By->ViewValue = $this->Added_By->CurrentValue;
			$this->Added_By->ViewCustomAttributes = "";

			// Date_Updated
			$this->Date_Updated->ViewValue = $this->Date_Updated->CurrentValue;
			$this->Date_Updated->ViewCustomAttributes = "";

			// Updated_By
			$this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
			$this->Updated_By->ViewCustomAttributes = "";

			// Supplier_Number
			$this->Supplier_Number->LinkCustomAttributes = "";
			$this->Supplier_Number->HrefValue = "";
			$this->Supplier_Number->TooltipValue = "";

			// Supplier_Name
			$this->Supplier_Name->LinkCustomAttributes = "";
			$this->Supplier_Name->HrefValue = "";
			$this->Supplier_Name->TooltipValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";
			$this->City->TooltipValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";
			$this->Country->TooltipValue = "";

			// Contact_Person
			$this->Contact_Person->LinkCustomAttributes = "";
			$this->Contact_Person->HrefValue = "";
			$this->Contact_Person->TooltipValue = "";

			// Phone_Number
			$this->Phone_Number->LinkCustomAttributes = "";
			$this->Phone_Number->HrefValue = "";
			$this->Phone_Number->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Mobile_Number
			$this->Mobile_Number->LinkCustomAttributes = "";
			$this->Mobile_Number->HrefValue = "";
			$this->Mobile_Number->TooltipValue = "";

			// Notes
			$this->Notes->LinkCustomAttributes = "";
			$this->Notes->HrefValue = "";
			$this->Notes->TooltipValue = "";

			// Balance
			$this->Balance->LinkCustomAttributes = "";
			$this->Balance->HrefValue = "";
			$this->Balance->TooltipValue = "";

			// Is_Stock_Available
			$this->Is_Stock_Available->LinkCustomAttributes = "";
			$this->Is_Stock_Available->HrefValue = "";
			$this->Is_Stock_Available->TooltipValue = "";

			// Date_Added
			$this->Date_Added->LinkCustomAttributes = "";
			$this->Date_Added->HrefValue = "";
			$this->Date_Added->TooltipValue = "";

			// Added_By
			$this->Added_By->LinkCustomAttributes = "";
			$this->Added_By->HrefValue = "";
			$this->Added_By->TooltipValue = "";

			// Date_Updated
			$this->Date_Updated->LinkCustomAttributes = "";
			$this->Date_Updated->HrefValue = "";
			$this->Date_Updated->TooltipValue = "";

			// Updated_By
			$this->Updated_By->LinkCustomAttributes = "";
			$this->Updated_By->HrefValue = "";
			$this->Updated_By->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Supplier_Number
			$this->Supplier_Number->EditAttrs["class"] = "form-control";
			$this->Supplier_Number->EditCustomAttributes = "";
			$this->Supplier_Number->EditValue = ew_HtmlEncode($this->Supplier_Number->CurrentValue);
			$this->Supplier_Number->PlaceHolder = ew_RemoveHtml($this->Supplier_Number->FldCaption());

			// Supplier_Name
			$this->Supplier_Name->EditAttrs["class"] = "form-control";
			$this->Supplier_Name->EditCustomAttributes = "";
			$this->Supplier_Name->EditValue = ew_HtmlEncode($this->Supplier_Name->CurrentValue);
			$this->Supplier_Name->PlaceHolder = ew_RemoveHtml($this->Supplier_Name->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->CurrentValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// City
			$this->City->EditAttrs["class"] = "form-control";
			$this->City->EditCustomAttributes = "";
			$this->City->EditValue = ew_HtmlEncode($this->City->CurrentValue);
			$this->City->PlaceHolder = ew_RemoveHtml($this->City->FldCaption());

			// Country
			$this->Country->EditAttrs["class"] = "form-control";
			$this->Country->EditCustomAttributes = "";
			$this->Country->EditValue = ew_HtmlEncode($this->Country->CurrentValue);
			$this->Country->PlaceHolder = ew_RemoveHtml($this->Country->FldCaption());

			// Contact_Person
			$this->Contact_Person->EditAttrs["class"] = "form-control";
			$this->Contact_Person->EditCustomAttributes = "";
			$this->Contact_Person->EditValue = ew_HtmlEncode($this->Contact_Person->CurrentValue);
			$this->Contact_Person->PlaceHolder = ew_RemoveHtml($this->Contact_Person->FldCaption());

			// Phone_Number
			$this->Phone_Number->EditAttrs["class"] = "form-control";
			$this->Phone_Number->EditCustomAttributes = "";
			$this->Phone_Number->EditValue = ew_HtmlEncode($this->Phone_Number->CurrentValue);
			$this->Phone_Number->PlaceHolder = ew_RemoveHtml($this->Phone_Number->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Mobile_Number
			$this->Mobile_Number->EditAttrs["class"] = "form-control";
			$this->Mobile_Number->EditCustomAttributes = "";
			$this->Mobile_Number->EditValue = ew_HtmlEncode($this->Mobile_Number->CurrentValue);
			$this->Mobile_Number->PlaceHolder = ew_RemoveHtml($this->Mobile_Number->FldCaption());

			// Notes
			$this->Notes->EditAttrs["class"] = "form-control";
			$this->Notes->EditCustomAttributes = "";
			$this->Notes->EditValue = ew_HtmlEncode($this->Notes->CurrentValue);
			$this->Notes->PlaceHolder = ew_RemoveHtml($this->Notes->FldCaption());

			// Balance
			$this->Balance->EditAttrs["class"] = "form-control";
			$this->Balance->EditCustomAttributes = "";
			$this->Balance->EditValue = ew_HtmlEncode($this->Balance->CurrentValue);
			$this->Balance->PlaceHolder = ew_RemoveHtml($this->Balance->FldCaption());
			if (strval($this->Balance->EditValue) <> "" && is_numeric($this->Balance->EditValue)) $this->Balance->EditValue = ew_FormatNumber($this->Balance->EditValue, -2, -2, -2, -2);

			// Is_Stock_Available
			$this->Is_Stock_Available->EditAttrs["class"] = "form-control";
			$this->Is_Stock_Available->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Is_Stock_Available->FldTagValue(1), $this->Is_Stock_Available->FldTagCaption(1) <> "" ? $this->Is_Stock_Available->FldTagCaption(1) : $this->Is_Stock_Available->FldTagValue(1));
			$arwrk[] = array($this->Is_Stock_Available->FldTagValue(2), $this->Is_Stock_Available->FldTagCaption(2) <> "" ? $this->Is_Stock_Available->FldTagCaption(2) : $this->Is_Stock_Available->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->Is_Stock_Available->EditValue = $arwrk;

			// Date_Added
			$this->Date_Added->EditAttrs["class"] = "form-control";
			$this->Date_Added->EditCustomAttributes = "";

			// Added_By
			$this->Added_By->EditAttrs["class"] = "form-control";
			$this->Added_By->EditCustomAttributes = "";

			// Date_Updated
			// Updated_By
			// Edit refer script
			// Supplier_Number

			$this->Supplier_Number->HrefValue = "";

			// Supplier_Name
			$this->Supplier_Name->HrefValue = "";

			// Address
			$this->Address->HrefValue = "";

			// City
			$this->City->HrefValue = "";

			// Country
			$this->Country->HrefValue = "";

			// Contact_Person
			$this->Contact_Person->HrefValue = "";

			// Phone_Number
			$this->Phone_Number->HrefValue = "";

			// Email
			$this->_Email->HrefValue = "";

			// Mobile_Number
			$this->Mobile_Number->HrefValue = "";

			// Notes
			$this->Notes->HrefValue = "";

			// Balance
			$this->Balance->HrefValue = "";

			// Is_Stock_Available
			$this->Is_Stock_Available->HrefValue = "";

			// Date_Added
			$this->Date_Added->HrefValue = "";

			// Added_By
			$this->Added_By->HrefValue = "";

			// Date_Updated
			$this->Date_Updated->HrefValue = "";

			// Updated_By
			$this->Updated_By->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->Supplier_Number->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Supplier_Name->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Address->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->City->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Country->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Contact_Person->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Phone_Number->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->_Email->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Mobile_Number->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Notes->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Balance->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Is_Stock_Available->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Date_Added->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Added_By->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Date_Updated->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Updated_By->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Supplier_Number->MultiUpdate <> "" && !$this->Supplier_Number->FldIsDetailKey && !is_null($this->Supplier_Number->FormValue) && $this->Supplier_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Number->FldCaption(), $this->Supplier_Number->ReqErrMsg));
		}
		if ($this->Supplier_Name->MultiUpdate <> "" && !$this->Supplier_Name->FldIsDetailKey && !is_null($this->Supplier_Name->FormValue) && $this->Supplier_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Supplier_Name->FldCaption(), $this->Supplier_Name->ReqErrMsg));
		}
		if ($this->Address->MultiUpdate <> "" && !$this->Address->FldIsDetailKey && !is_null($this->Address->FormValue) && $this->Address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Address->FldCaption(), $this->Address->ReqErrMsg));
		}
		if ($this->City->MultiUpdate <> "" && !$this->City->FldIsDetailKey && !is_null($this->City->FormValue) && $this->City->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->City->FldCaption(), $this->City->ReqErrMsg));
		}
		if ($this->Country->MultiUpdate <> "" && !$this->Country->FldIsDetailKey && !is_null($this->Country->FormValue) && $this->Country->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Country->FldCaption(), $this->Country->ReqErrMsg));
		}
		if ($this->Contact_Person->MultiUpdate <> "" && !$this->Contact_Person->FldIsDetailKey && !is_null($this->Contact_Person->FormValue) && $this->Contact_Person->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Contact_Person->FldCaption(), $this->Contact_Person->ReqErrMsg));
		}
		if ($this->Phone_Number->MultiUpdate <> "" && !$this->Phone_Number->FldIsDetailKey && !is_null($this->Phone_Number->FormValue) && $this->Phone_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Phone_Number->FldCaption(), $this->Phone_Number->ReqErrMsg));
		}
		if ($this->_Email->MultiUpdate <> "" && !$this->_Email->FldIsDetailKey && !is_null($this->_Email->FormValue) && $this->_Email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Email->FldCaption(), $this->_Email->ReqErrMsg));
		}
		if ($this->Mobile_Number->MultiUpdate <> "" && !$this->Mobile_Number->FldIsDetailKey && !is_null($this->Mobile_Number->FormValue) && $this->Mobile_Number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Mobile_Number->FldCaption(), $this->Mobile_Number->ReqErrMsg));
		}
		if ($this->Notes->MultiUpdate <> "" && !$this->Notes->FldIsDetailKey && !is_null($this->Notes->FormValue) && $this->Notes->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Notes->FldCaption(), $this->Notes->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		if ($this->Supplier_Number->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Supplier_Number` = '" . ew_AdjustSql($this->Supplier_Number->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Supplier_Number->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Supplier_Number->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Supplier_Number
			$this->Supplier_Number->SetDbValueDef($rsnew, $this->Supplier_Number->CurrentValue, "", $this->Supplier_Number->ReadOnly || $this->Supplier_Number->MultiUpdate <> "1");

			// Supplier_Name
			$this->Supplier_Name->SetDbValueDef($rsnew, $this->Supplier_Name->CurrentValue, "", $this->Supplier_Name->ReadOnly || $this->Supplier_Name->MultiUpdate <> "1");

			// Address
			$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, "", $this->Address->ReadOnly || $this->Address->MultiUpdate <> "1");

			// City
			$this->City->SetDbValueDef($rsnew, $this->City->CurrentValue, "", $this->City->ReadOnly || $this->City->MultiUpdate <> "1");

			// Country
			$this->Country->SetDbValueDef($rsnew, $this->Country->CurrentValue, "", $this->Country->ReadOnly || $this->Country->MultiUpdate <> "1");

			// Contact_Person
			$this->Contact_Person->SetDbValueDef($rsnew, $this->Contact_Person->CurrentValue, "", $this->Contact_Person->ReadOnly || $this->Contact_Person->MultiUpdate <> "1");

			// Phone_Number
			$this->Phone_Number->SetDbValueDef($rsnew, $this->Phone_Number->CurrentValue, "", $this->Phone_Number->ReadOnly || $this->Phone_Number->MultiUpdate <> "1");

			// Email
			$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, "", $this->_Email->ReadOnly || $this->_Email->MultiUpdate <> "1");

			// Mobile_Number
			$this->Mobile_Number->SetDbValueDef($rsnew, $this->Mobile_Number->CurrentValue, "", $this->Mobile_Number->ReadOnly || $this->Mobile_Number->MultiUpdate <> "1");

			// Notes
			$this->Notes->SetDbValueDef($rsnew, $this->Notes->CurrentValue, "", $this->Notes->ReadOnly || $this->Notes->MultiUpdate <> "1");

			// Balance
			$this->Balance->SetDbValueDef($rsnew, $this->Balance->CurrentValue, NULL, $this->Balance->ReadOnly || $this->Balance->MultiUpdate <> "1");

			// Is_Stock_Available
			$this->Is_Stock_Available->SetDbValueDef($rsnew, ((strval($this->Is_Stock_Available->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->Is_Stock_Available->ReadOnly || $this->Is_Stock_Available->MultiUpdate <> "1");

			// Date_Added
			$this->Date_Added->SetDbValueDef($rsnew, $this->Date_Added->CurrentValue, NULL, $this->Date_Added->ReadOnly || $this->Date_Added->MultiUpdate <> "1");

			// Added_By
			$this->Added_By->SetDbValueDef($rsnew, $this->Added_By->CurrentValue, NULL, $this->Added_By->ReadOnly || $this->Added_By->MultiUpdate <> "1");

			// Date_Updated
			$this->Date_Updated->SetDbValueDef($rsnew, ew_CurrentDateTime(), NULL);
			$rsnew['Date_Updated'] = &$this->Date_Updated->DbValue;

			// Updated_By
			$this->Updated_By->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Updated_By'] = &$this->Updated_By->DbValue;

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "a_supplierslist.php", "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($a_suppliers_update)) $a_suppliers_update = new ca_suppliers_update();

// Page init
$a_suppliers_update->Page_Init();

// Page main
$a_suppliers_update->Page_Main();

// Begin of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
getCurrentPageTitle(ew_CurrentPage());

// End of modification Displaying Breadcrumb Links in All Pages, by Masino Sinaga, May 4, 2012
// Global Page Rendering event (in userfn*.php)

Page_Rendering();

// Global auto switch table width style (in userfn*.php), by Masino Sinaga, January 7, 2015
AutoSwitchTableWidthStyle();

// Page Rendering event
$a_suppliers_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var a_suppliers_update = new ew_Page("a_suppliers_update");
a_suppliers_update.PageID = "update"; // Page ID
var EW_PAGE_ID = a_suppliers_update.PageID; // For backward compatibility

// Form object
var fa_suppliersupdate = new ew_Form("fa_suppliersupdate");

// Validate form
fa_suppliersupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		alertify.alert(ewLanguage.Phrase("NoFieldSelected"), function (ok) { }, ewLanguage.Phrase('AlertifyAlert')); // Modification Alertify by Masino Sinaga, October 14, 2013
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Supplier_Number");
			uelm = this.GetElements("u" + infix + "_Supplier_Number");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Supplier_Number->FldCaption(), $a_suppliers->Supplier_Number->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Supplier_Name");
			uelm = this.GetElements("u" + infix + "_Supplier_Name");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Supplier_Name->FldCaption(), $a_suppliers->Supplier_Name->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Address");
			uelm = this.GetElements("u" + infix + "_Address");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Address->FldCaption(), $a_suppliers->Address->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_City");
			uelm = this.GetElements("u" + infix + "_City");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->City->FldCaption(), $a_suppliers->City->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Country");
			uelm = this.GetElements("u" + infix + "_Country");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Country->FldCaption(), $a_suppliers->Country->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Contact_Person");
			uelm = this.GetElements("u" + infix + "_Contact_Person");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Contact_Person->FldCaption(), $a_suppliers->Contact_Person->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Phone_Number");
			uelm = this.GetElements("u" + infix + "_Phone_Number");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Phone_Number->FldCaption(), $a_suppliers->Phone_Number->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "__Email");
			uelm = this.GetElements("u" + infix + "__Email");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->_Email->FldCaption(), $a_suppliers->_Email->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Mobile_Number");
			uelm = this.GetElements("u" + infix + "_Mobile_Number");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Mobile_Number->FldCaption(), $a_suppliers->Mobile_Number->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Notes");
			uelm = this.GetElements("u" + infix + "_Notes");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $a_suppliers->Notes->FldCaption(), $a_suppliers->Notes->ReqErrMsg)) ?>");
			}

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fa_suppliersupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fa_suppliersupdate.ValidateRequired = true;
<?php } else { ?>
fa_suppliersupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (MS_SHOW_PHPMAKER_BREADCRUMBLINKS) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if (MS_SHOW_MASINO_BREADCRUMBLINKS) { ?>
<?php echo MasinoBreadcrumbLinks(); ?>
<?php } ?>
<?php if (MS_LANGUAGE_SELECTOR_VISIBILITY=="belowheader") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $a_suppliers_update->ShowPageHeader(); ?>
<?php
$a_suppliers_update->ShowMessage();
?>
<form name="fa_suppliersupdate" id="fa_suppliersupdate" class="form-horizontal ewForm ewUpdateForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($a_suppliers_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $a_suppliers_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="a_suppliers">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php foreach ($a_suppliers_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_a_suppliersupdate">
	<div class="form-group">
		<label class="col-sm-2"><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($a_suppliers->Supplier_Number->Visible) { // Supplier_Number ?>
	<div id="r_Supplier_Number" class="form-group">
		<label for="x_Supplier_Number" class="col-sm-2 control-label">
<input type="checkbox" name="u_Supplier_Number" id="u_Supplier_Number" value="1"<?php echo ($a_suppliers->Supplier_Number->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Supplier_Number->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Supplier_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Number">
<input type="text" data-field="x_Supplier_Number" name="x_Supplier_Number" id="x_Supplier_Number" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Number->PlaceHolder) ?>" value="<?php echo $a_suppliers->Supplier_Number->EditValue ?>"<?php echo $a_suppliers->Supplier_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Supplier_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Supplier_Name->Visible) { // Supplier_Name ?>
	<div id="r_Supplier_Name" class="form-group">
		<label for="x_Supplier_Name" class="col-sm-2 control-label">
<input type="checkbox" name="u_Supplier_Name" id="u_Supplier_Name" value="1"<?php echo ($a_suppliers->Supplier_Name->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Supplier_Name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Supplier_Name->CellAttributes() ?>>
<span id="el_a_suppliers_Supplier_Name">
<input type="text" data-field="x_Supplier_Name" name="x_Supplier_Name" id="x_Supplier_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Supplier_Name->PlaceHolder) ?>" value="<?php echo $a_suppliers->Supplier_Name->EditValue ?>"<?php echo $a_suppliers->Supplier_Name->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Supplier_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label for="x_Address" class="col-sm-2 control-label">
<input type="checkbox" name="u_Address" id="u_Address" value="1"<?php echo ($a_suppliers->Address->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Address->CellAttributes() ?>>
<span id="el_a_suppliers_Address">
<textarea data-field="x_Address" name="x_Address" id="x_Address" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Address->PlaceHolder) ?>"<?php echo $a_suppliers->Address->EditAttributes() ?>><?php echo $a_suppliers->Address->EditValue ?></textarea>
</span>
<?php echo $a_suppliers->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->City->Visible) { // City ?>
	<div id="r_City" class="form-group">
		<label for="x_City" class="col-sm-2 control-label">
<input type="checkbox" name="u_City" id="u_City" value="1"<?php echo ($a_suppliers->City->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->City->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->City->CellAttributes() ?>>
<span id="el_a_suppliers_City">
<input type="text" data-field="x_City" name="x_City" id="x_City" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($a_suppliers->City->PlaceHolder) ?>" value="<?php echo $a_suppliers->City->EditValue ?>"<?php echo $a_suppliers->City->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->City->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Country->Visible) { // Country ?>
	<div id="r_Country" class="form-group">
		<label for="x_Country" class="col-sm-2 control-label">
<input type="checkbox" name="u_Country" id="u_Country" value="1"<?php echo ($a_suppliers->Country->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Country->CellAttributes() ?>>
<span id="el_a_suppliers_Country">
<input type="text" data-field="x_Country" name="x_Country" id="x_Country" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Country->PlaceHolder) ?>" value="<?php echo $a_suppliers->Country->EditValue ?>"<?php echo $a_suppliers->Country->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Contact_Person->Visible) { // Contact_Person ?>
	<div id="r_Contact_Person" class="form-group">
		<label for="x_Contact_Person" class="col-sm-2 control-label">
<input type="checkbox" name="u_Contact_Person" id="u_Contact_Person" value="1"<?php echo ($a_suppliers->Contact_Person->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Contact_Person->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Contact_Person->CellAttributes() ?>>
<span id="el_a_suppliers_Contact_Person">
<input type="text" data-field="x_Contact_Person" name="x_Contact_Person" id="x_Contact_Person" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Contact_Person->PlaceHolder) ?>" value="<?php echo $a_suppliers->Contact_Person->EditValue ?>"<?php echo $a_suppliers->Contact_Person->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Contact_Person->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Phone_Number->Visible) { // Phone_Number ?>
	<div id="r_Phone_Number" class="form-group">
		<label for="x_Phone_Number" class="col-sm-2 control-label">
<input type="checkbox" name="u_Phone_Number" id="u_Phone_Number" value="1"<?php echo ($a_suppliers->Phone_Number->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Phone_Number->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Phone_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Phone_Number">
<input type="text" data-field="x_Phone_Number" name="x_Phone_Number" id="x_Phone_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Phone_Number->PlaceHolder) ?>" value="<?php echo $a_suppliers->Phone_Number->EditValue ?>"<?php echo $a_suppliers->Phone_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Phone_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group">
		<label for="x__Email" class="col-sm-2 control-label">
<input type="checkbox" name="u__Email" id="u__Email" value="1"<?php echo ($a_suppliers->_Email->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->_Email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->_Email->CellAttributes() ?>>
<span id="el_a_suppliers__Email">
<input type="text" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($a_suppliers->_Email->PlaceHolder) ?>" value="<?php echo $a_suppliers->_Email->EditValue ?>"<?php echo $a_suppliers->_Email->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Mobile_Number->Visible) { // Mobile_Number ?>
	<div id="r_Mobile_Number" class="form-group">
		<label for="x_Mobile_Number" class="col-sm-2 control-label">
<input type="checkbox" name="u_Mobile_Number" id="u_Mobile_Number" value="1"<?php echo ($a_suppliers->Mobile_Number->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Mobile_Number->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Mobile_Number->CellAttributes() ?>>
<span id="el_a_suppliers_Mobile_Number">
<input type="text" data-field="x_Mobile_Number" name="x_Mobile_Number" id="x_Mobile_Number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Mobile_Number->PlaceHolder) ?>" value="<?php echo $a_suppliers->Mobile_Number->EditValue ?>"<?php echo $a_suppliers->Mobile_Number->EditAttributes() ?>>
</span>
<?php echo $a_suppliers->Mobile_Number->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Notes->Visible) { // Notes ?>
	<div id="r_Notes" class="form-group">
		<label for="x_Notes" class="col-sm-2 control-label">
<input type="checkbox" name="u_Notes" id="u_Notes" value="1"<?php echo ($a_suppliers->Notes->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Notes->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Notes->CellAttributes() ?>>
<span id="el_a_suppliers_Notes">
<textarea data-field="x_Notes" name="x_Notes" id="x_Notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Notes->PlaceHolder) ?>"<?php echo $a_suppliers->Notes->EditAttributes() ?>><?php echo $a_suppliers->Notes->EditValue ?></textarea>
</span>
<?php echo $a_suppliers->Notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Balance->Visible) { // Balance ?>
	<div id="r_Balance" class="form-group">
		<label for="x_Balance" class="col-sm-2 control-label">
<input type="checkbox" name="u_Balance" id="u_Balance" value="1"<?php echo ($a_suppliers->Balance->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Balance->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Balance->CellAttributes() ?>>
<span id="el_a_suppliers_Balance">
<input type="text" data-field="x_Balance" name="x_Balance" id="x_Balance" size="30" placeholder="<?php echo ew_HtmlEncode($a_suppliers->Balance->PlaceHolder) ?>" value="<?php echo $a_suppliers->Balance->EditValue ?>"<?php echo $a_suppliers->Balance->EditAttributes() ?>>
<?php if (!$a_suppliers->Balance->ReadOnly && !$a_suppliers->Balance->Disabled && @$a_suppliers->Balance->EditAttrs["readonly"] == "" && @$a_suppliers->Balance->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
$('#x_Balance').autoNumeric('init', {aSep: ',', aDec: '.', mDec: '2', aForm: false});
</script>
<?php } ?>
</span>
<?php echo $a_suppliers->Balance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($a_suppliers->Is_Stock_Available->Visible) { // Is_Stock_Available ?>
	<div id="r_Is_Stock_Available" class="form-group">
		<label for="x_Is_Stock_Available" class="col-sm-2 control-label">
<input type="checkbox" name="u_Is_Stock_Available" id="u_Is_Stock_Available" value="1"<?php echo ($a_suppliers->Is_Stock_Available->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
 <?php echo $a_suppliers->Is_Stock_Available->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $a_suppliers->Is_Stock_Available->CellAttributes() ?>>
<span id="el_a_suppliers_Is_Stock_Available">
<select data-field="x_Is_Stock_Available" id="x_Is_Stock_Available" name="x_Is_Stock_Available"<?php echo $a_suppliers->Is_Stock_Available->EditAttributes() ?>>
<?php
if (is_array($a_suppliers->Is_Stock_Available->EditValue)) {
	$arwrk = $a_suppliers->Is_Stock_Available->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($a_suppliers->Is_Stock_Available->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $a_suppliers->Is_Stock_Available->CustomMsg ?></div></div>
	</div>
<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
fa_suppliersupdate.Init();
</script>
<?php
$a_suppliers_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php // Begin of modification Add Cancel Button next to Action Button, by Masino Sinaga, August 4, 2014 ?>
<?php if (MS_ADD_CANCEL_BUTTON_NEXT_TO_ACTION_BUTTON == TRUE) { ?>
<script type="text/javascript">
$("#btnAction").after('&nbsp;&nbsp;<button class="btn btn-danger ewButton" name="btnCancel" id="btnCancel" type="Button" onclick="window.history.back()"><?php echo Language()->Phrase("CancelBtn"); ?></button>');
</script>
<?php } ?>
<?php // End of modification Add Cancel Button next to Action Button, by Masino Sinaga, August 4, 2014 ?>
<?php if (MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD) { ?>
<script type="text/javascript">
$(document).ready(function(){$("#fa_suppliersupdate:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btnAction").click()})});
</script>
<?php } ?>
<?php if ($a_suppliers->Export == "") { ?>
<script type="text/javascript">
$('#btnAction').attr('onclick', 'return alertifyUpdate(this)'); function alertifyUpdate(obj) { <?php global $Language; ?> if (fa_suppliersupdate.Validate() == true ) { alertify.set({buttonFocus: 'cancel'});alertify.confirm("<?php echo  $Language->Phrase('AlertifyEditConfirm'); ?>", function (e) { if (e) { $(window).unbind('beforeunload'); alertify.success("<?php echo $Language->Phrase('AlertifyEdit'); ?>"); $("#fa_suppliersupdate").submit(); } else { alertify.error("<?php echo $Language->Phrase('AlertifyCancel'); ?>"); } }, "<?php echo $Language->Phrase('AlertifyConfirm'); ?>"); } return false; }
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$a_suppliers_update->Page_Terminate();
?>
