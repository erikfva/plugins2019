<?php
/** CONFIG YOUR MAIN PROJECT NAMESPACE HERE!!! **/
use PHPMaker2019\gsadmin as phpfn;
/* **************************************** */

define("EW_PROJECT_NAME", phpfn\PROJECT_NAME, TRUE); // Project name
define("EW_TABLE_MASTER_TABLE", phpfn\TABLE_MASTER_TABLE, TRUE); // Master table
define("EW_CHARSET", phpfn\PROJECT_CHARSET, TRUE); 
define("EW_TOKEN_NAME", phpfn\TOKEN_NAME, TRUE); 


class Language extends phpfn\Language{}
class UserProfile extends phpfn\UserProfile{}
class AdvancedSecurity extends phpfn\AdvancedSecurity{}
class PrevNextPager extends phpfn\PrevNextPager{}
class ExportJson extends phpfn\ExportJson{
    public function &GetItems() { return $this->Items; }
}   

function CurrentPage(){
    return phpfn\CurrentPage();
}
function isLoggedIn(){
    return phpfn\isLoggedIn();
}
function AddClientScript($src, $attrs = NULL) {
    return phpfn\AddClientScript($src, $attrs);
}
function AddStylesheet($href, $attrs = NULL) {
    return phpfn\AddStylesheet($href, $attrs);
}
function CurrentPageName() {
    return phpfn\CurrentPageName();
}
// Get breadcrumb object
function &Breadcrumb() {
	return phpfn\Breadcrumb();
}
// Check if mobile device
function IsMobile() {
    return phpfn\IsMobile(); 
}
// Check if tablet device
function IsTablet() {
    global $MobileDetect, $IsTablet;
    if (isset($IsTablet))
		return $IsTablet;

	if (!isset($MobileDetect)) {
		$MobileDetect = new \Mobile_Detect();
		$IsTablet = $MobileDetect->isTablet();
	}
	return $IsTablet;
}

function CurrentPageID(){
    return phpfn\CurrentPageID();
}

function CurrentProjectID() {
    return phpfn\CurrentProjectID();
} 
// Permission denied message
function DeniedMessage() {
    return phpfn\DeniedMessage();
} 
function UploadTempPath($fld = NULL, $idx = -1, $tableLevel = FALSE) {
    return phpfn\UploadTempPath($fld, $idx, $tableLevel);
}  
function &GetExportDocument(&$tbl, $style) {
    $type = strtolower($tbl->Export);
    $inst = NULL;
    if($type == "json"){
        $inst = new ExportJson($tbl, $style);
        return $inst;
    }
    return phpfn\GetExportDocument($tbl, $style);
}
// Get current page heading
function CurrentPageHeading() {
    return "<span class='ew-page-heading'>".phpfn\CurrentPageHeading()."</span>";   
}
// Get domain URL
function DomainUrl() {
    return phpfn\DomainUrl();
}
// Get current URL
function CurrentUrl() {
    return phpfn\CurrentUrl();    
}
// Remove CrLf from text
function RemoveCrLf($str){
    return str_replace(["\r", "\n", "\t"], ["", "", ""], $str);
}
?>