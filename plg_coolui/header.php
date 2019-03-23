<?php
include_once "plugins2019/phpfn.php";
echo "<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1, user-scalable=no' name='viewport' />";
?>
<link rel="stylesheet" href="plugins2019/plg_coolui/coolui.css">
<script>

jQuery.extend(ew, {
	IS_TABLET: function(){ return !!ew.MOBILE_DETECT.tablet(); }
});
</script>

<?php
    global $Language;
	CurrentPage()->Heading = CurrentPageHeading();
	
	global $Breadcrumb;
	if(isset($Breadcrumb->Links)){

		//Quitando el link de "inicio" del path
		if($Breadcrumb->Links[0][0]=="home"){array_splice($Breadcrumb->Links, 0, 1);}
	
		//Agregando los botones de accion en la misma fila del path
		if(isset(CurrentPage()->PageID) && (CurrentPage()->PageID == "edit" || CurrentPage()->PageID == "add" ) ){
			global $customstyle;
			//$PageCaption = $Language->Phrase("EditBtn");
			array_splice( $Breadcrumb->Links, count($Breadcrumb->Links)-1, 0, array(array("editbtn","SaveBtn" , "javascript:$('#btn-action').trigger('click');\" class=\"btn btn-sm btn-primary", "", CurrentPage()->TableVar, false) ) );
			echo "<style>.breadcrumb .active{display:none !important}</style>";
		}
		if(isset(CurrentPage()->PageID) && CurrentPage()->PageID == "search" ){
			global $customstyle;
			//$PageCaption = $Language->Phrase("SearchBtn");
			array_splice( $Breadcrumb->Links, count($Breadcrumb->Links)-1, 0, array(array("searchbtn","SearchBtn" , "javascript:$('#btnAction').trigger('click');\" class=\"btn btn-sm btn-primary", "", CurrentPage()->TableVar, false) ) );
			css(".breadcrumb .active{display:none !important}");
		}
		//En algunos casos es necesario adicionar el link para volver atras
		if( (empty($opciones) || !strpos($opciones,"hidebkmainpage")) && isset(CurrentPage()->TableVar) && !empty($_SESSION[EW_PROJECT_NAME . "_" . CurrentPage()->TableVar . "_" . EW_TABLE_MASTER_TABLE]) && count($Breadcrumb->Links) == 1 ) {
			$masterTbl = $_SESSION[EW_PROJECT_NAME . "_" . CurrentPage()->TableVar . "_" . EW_TABLE_MASTER_TABLE];
			$PageLnk = @$_SESSION[EW_PROJECT_NAME ."_".$_SESSION[EW_PROJECT_NAME . "_" . CurrentPage()->TableVar . "_" . EW_TABLE_MASTER_TABLE]."_exportreturn"];
			array_splice( $Breadcrumb->Links, count($Breadcrumb->Links)-1, 0, array(array(
			$masterTbl,
			$masterTbl ,
			DomainUrl().$PageLnk,
			"",
			$masterTbl,
			false) ) );
		}
	
	}
?>
<?php 
/***********************************************************************/
/* CoolUI : Include special css styles
/***********************************************************************/
//AddStylesheet($plgConf["plugins_path"]."plg_coolui/coolui.css");
$MobileDetect = new \Mobile_Detect();

$BODY_CLASS = "fixed-sn sidebar-collapse".($MobileDetect->isMobile()?" mobile":"");
$NAVBAR_CLASS = str_replace(array('navbar-light','bg-gray-light','border-bottom'),'',$NAVBAR_CLASS) . " fixed-top navbar-expand-lg scrolling-navbar primary-color double-nav";
$SIDEBAR_CLASS .= " sn-bg-4 fixed";

if(CurrentPageID() == "list"){ //Generate field labels class for vertical tables.
	$orderField = "";     
	$orderBy = CurrentPage()->getSessionOrderBy();
	$orderType = strpos($orderBy, "ASC")!==false?"ASC":"DESC";

	echo "<style>\n";
	foreach(CurrentPage()->fields as $FldVar => $field) {
		$FldCaption = 	$field->caption();
		$ClassName = CurrentPage()->TableVar."_".$FldVar;
		echo <<<END
		body.mobile .ew-grid:not(.ew-master-div) table td .$ClassName::before,
		.vertical-table td .$ClassName:before{
			content:"$FldCaption:    ";
			white-space: pre;
			color: navy;
			font-weight: bold;
		}\n
END;
		if(strpos($orderBy, '`'.$FldVar.'`')!==false){
			$SortImage = $orderType == 'ASC'?'asc_sort.svg':'des_sort.svg';
			echo <<<END
			body.mobile .ew-grid:not(.ew-master-div) table td .$ClassName::before,
			.vertical-table td .$ClassName::before{
				content:"$FldCaption     ";
				background: url("plugins2019/plg_coolui/img/svg/$SortImage") no-repeat;
				background-position-x: right;
			}\n
END;
		}
	}
	echo "</style>";
}
?>