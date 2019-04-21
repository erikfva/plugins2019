<?php
//tableheadfixer
if(isset(CurrentPage()->PageID) && CurrentPage()->PageID == "list"){
	if(file_exists(__DIR__."/tableheadfixer/jquery.tableheadfixer.js"))
		AddClientScript( "plugins2019/plg_coolui/tableheadfixer/jquery.tableheadfixer.js" );	
}
?>
 <!-- MDB core JavaScript -->
<?php AddClientScript("plugins2019/plg_coolui/js/mdb.min.js");	?>
  <!-- <script type="text/javascript" src="plugins2019/plg_coolui/js/mdb.min.js"></script> -->
  <!--Initializations-->
  <script>
	// SideNav Initialization
	$(".button-collapse").sideNav();


	// Data Picker Initialization
	$('.datepicker').pickadate();

	// Material Select Initialization
	$(document).ready(function () {
	  $('.mdb-select').material_select();
	});

	// Tooltips Initialization
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

  </script>

<?php
//	include_once $plgConf["plugins_path"]."phpfn.php";	

	AddClientScript("plugins2019/plg_coolui/coolui.js");

    /****************************************************/
		//* Personaliza el estilo de tus componentes aqui *//
		//Dom slectors -> https://devhints.io/xpath
    /****************************************************/

	include __DIR__."/vendor/autoload.php";
	use DiDom\Document;
	use DiDom\Query;
	use DiDom\Element;

	$document = new Document(ob_get_contents());
	$body = $document->find('body')[0];

	//show brand if not empty text
	$element = @$document->find('a.brand-link')[0];
	if( $element){
		$element->style = @$element->style . (RemoveCrLf($element->text()) != ''? ';display:block' : ';display:none' );
	} 

	//*****************/
	//input text styles
	//*****************/

	
	$elements = $document->find('.form-group.row');
	foreach($elements as $element) {
		$input = @$element->findInDocument('input[type="text"]')[0];
		$label = @$element->findInDocument('label')[0];
		//$input = $element;
		$input && $input->class = @$input->class. ' cool-ui';
		if($input && empty($input->readonly)){
			!empty($input->placeholder) && ($input->placeholder = "");
			$div = new Element('div', '', ['class'=>'md-form']);
			$div->appendChild($input);
			if($label){
				$label->class = str_replace('col-form-label','',@$label->class);
				$div->appendChild($label);
				$label->remove();
			}
			$input->replace($div);
			//echo $input->html(), "\n";
		}		
	}

	$elements = $document->find("//input[contains(@type,'text') and not(contains(@class, 'cool-ui'))]", Query::TYPE_XPATH);
	foreach($elements as $input) {
		$input->parent()->class = @$input->parent()->class . " md-form";
		$input->class = @$input->class. ' cool-ui';
	}


	/*-------------------------------------------------*/

	//***********************************/
	// button style
	//***********************************/
	$elements = $document->find('.ew-search-panel button');
	foreach($elements as $btn) {
		$btn->class = @$btn->class. ' btn-tb cool-ui';	//$('.ew-search-panel button').addClass('btn-tb');
	}
    
	//Botones de edicion de registros en tablas de listas.
	if(CurrentPageID() == "list"){
		
		$listbtngroup = $document->find('.ew-list-option-body .ew-btn-group');
		foreach($listbtngroup as $btngroup) {
			$btngroup->class = 'pull-left';
		}
		/*
		$btngroup = $listoptionbody->find('.ew-btn-group');
		foreach($btngroup as $group) {
			$group->class = '';
		}*/
		
		$elements = $document->find('.ew-row-link');
		foreach($elements as $btn) {
			$btn->class = @$btn->class. ' btn-floating btn-xs cool-ui mr-1';	//$('.ew-row-link').addClass('btn-floating btn-xs').find('i').addClass('fa-1x');
			foreach($btn->findInDocument('i') as $i) {
				$i->class = @$i->class. ' fa-1x';
			}
			strpos(@$btn->class, 'ew-delete') && ($btn->class = @$btn->class. ' btn-danger'); //$('.ew-row-link.ew-delete').addClass('btn-danger');
			strpos(@$btn->class, 'ew-edit') && ($btn->class = @$btn->class. ' btn-cyan'); //$('.ew-row-link.ew-edit').addClass('btn-cyan');
			strpos(@$btn->class, 'ew-add') && ($btn->class = @$btn->class. ' btn-success'); //$('.ew-row-link.ew-add').addClass('btn-success');
			strpos(@$btn->class, 'ew-view') && ($btn->class = @$btn->class. ' btn-info'); //$('.ew-row-link.ew-view').addClass('btn-info');
			strpos(@$btn->class, 'ew-copy') && ($btn->class = @$btn->class. ' btn-light-green'); //$('.ew-row-link.ew-copy').addClass('btn-light-green');
		}
	}	
	
	/*-------------------------------------------------*/

	//***********************************/
	// table style
	//***********************************/
	
	if(CurrentPageID() == "list"){
		$orderHTML = '';
		$elements = $document->find("//div[contains(concat(' ',normalize-space(@class),' '),' ew-grid ') 
		and not(contains(@class, 'ew-master-div'))]", Query::TYPE_XPATH);
		foreach($elements as $grid) {
			$tables = $grid->findInDocument("//table[contains(concat(' ',normalize-space(@class),' '),' ew-table ') 
			and not(contains(@class, 'hidden')) 
			and not(contains(@class, 'ew-master-table'))]", Query::TYPE_XPATH);
			foreach($tables as $table) {
				$MobileDetect->isMobile() && !$MobileDetect->isTablet() && ($table->class = @$table->class. ' vertical-table');
				//!$MobileDetect->isMobile() && ($grid->class = @$grid->class. ' lazy-render');
				//if($MobileDetect->isMobile()){
					$orderHTML = (string) $table->find('thead')[0];
					$orderHTML = str_replace(
						['thead', 'tr', 'th', 'ew-list-option-header', 'ew-pointer'], 
						['span', 'div', 'span', 'hide', 'dropdown-item'],  
						$orderHTML
					);	

					$orderBtn = new Element('a', '', 
						['class' => 'btn-sort btn-xs position-fixed btn-floating btn-secondary',
						'data-toggle' => 'modal',
						'href' => '#',
						'role' => 'button',
						'aria-expanded' => 'false',
						'data-target' => '#sortFields'
						]
					);
					$orderBtn->setInnerHtml('<i class="fa fa-sort-alpha-asc"></i>');

					$orderPanel = new Element('div', '', 
					['class' => 'modal fade',
					'tabindex'=>'-1', 'role'=>'dialog', 'aria-labelledby'=>'sortFieldsLabel', 'aria-hidden'=>'true',
					'id' => 'sortFields']);
					$orderHTML = '
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="sortFieldsLabel">Seleccione el orden</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
							'.$orderHTML.'
							</div>
						</div>
					</div>
					';

					$orderPanel->setInnerHtml($orderHTML);
					$td = $table->findInDocument('tbody tr td')[0];
					$body->appendChild($orderPanel);
					$td->prependChild($orderBtn);
			}
		}	
	}
	/*-------------------------------------------------*/

	//***********************************/
	// PAGER CONTROL 
	//***********************************/
	if(CurrentPageID() == "list"){
		//Fixed records navigator on bottom
		$elements = $document->find('.ew-grid-lower-panel');
		foreach($elements as $element) {
			$element->class = @$element->class. ' border-top navbar fixed-bottom navbar-light bg-white p-0 pl-3 pt-2 collapse-pager';	
			
			if($element->has('.ew-prev-next')){
				$btnTogglePager = new Element('span', '');
				$btnTogglePager->setInnerHtml('<a class="pl-1 btn-floating btn-primary btn-toggle-pager" onclick="$(\'.ew-grid-lower-panel\').removeClass(\'collapse-pager\');"><i class="fa fa-forward"></i></a>');
				$element->appendChild($btnTogglePager);
				
				$btnClosePager = new Element('span', '');
				$btnClosePager->setInnerHtml('<a class="btn-floating btn-info btn-xs close-pager" onclick="$(\'.ew-grid-lower-panel\').addClass(\'collapse-pager\');"><i class="fa fa-close fa-1x"></i></a>');
				$element->appendChild($btnClosePager);
			}
		}
	}
	
	/*-------------------------------------------------*/

	$lazyRenderSelector = [];
	foreach($lazyRenderSelector as $selector) {
		foreach($document->find($selector) as $element) {
			$element->class = @$element->class . " lazy-render"; 
		}
	}

	//var_dump( RemoveHtml($element[0]->text()) ) ;
	//exit;
/* 	$body = $document->find('body')[0];
	$body->class = "bg-red";
 */	
	$strHtml = (string) $document;
	//Adding loading spinner at beginen of <body>
	$spinner = '
	<div id="mdb-preloader" class="mdb-preloader clockpicker-canvas-out flex-center">
		<div class="preloader-wrapper big active crazy">
			<div class=" spinner-layer spinner-blue-only">
				<div class="circle-clipper left">
					<div class="circle"></div>
				</div>
				<div class="gap-patch">
					<div class="circle"></div>
				</div>
				<div class="circle-clipper right">
					<div class="circle"></div>
				</div>
			</div>
		</div>
	</div>
	</head>
	';
	$strHtml = str_replace("</head>", $spinner ,  $strHtml);	

	//Hide spinner when load page
	$script = '
		<script>
			$("#mdb-preloader, .mdb-preloader").hide();
		</script>
	</section>
	';
	$strHtml = str_replace("</section>", $script ,  $strHtml);	


	if(CurrentPageID() == "list"){
		//** Get Fields Info */
/* 		$FieldList = Array();
		$orderField = "";     
		$orderBy = CurrentPage()->getSessionOrderBy();
		$orderType = strpos($orderBy, "ASC")!==false?"ASC":"DESC";
		foreach (CurrentPage()->fields as $FldVar => $field) {
			$FieldList[] = array('id'=>$field->FieldVar,'name' => $FldVar,
				'caption' => $field->Caption() ,
				'sortable' => (CurrentPage()->SortUrl($field) == ""?false:true),
				'visible' => $field->Visible);
			$orderField = strpos($orderBy, $FldVar)!==false? $FldVar: $orderField;
		} */
	}


	//Remove close tag elements created by parser, because PHPMaker include that elements at end of footer.php file.
	$strHtml = str_replace("\n</div>\n</body>\n</html>", '',  $strHtml);	
	
	ob_clean();
	echo $strHtml;
	
/* 	echo "<pre>";
	echo $strHtml; // $body[0]->class;
	echo "</pre>"; */


/*	
	include __DIR__."/simplehtmldom/simple_html_dom.php";
	$html = str_get_html(ob_get_contents());
	$body = $html->find('body',0);
	$body->class = 'bg-red cool';
	echo "<pre>";
	echo $html;
	echo "</pre>";
	*/

/* 	libxml_use_internal_errors(true);
	$doc = new DOMDocument();
	if(!$doc->loadHTML(ob_get_contents())){
		libxml_clear_errors();
	}
	echo "<pre>";
	echo $doc->saveHTML();
	echo "</pre>"; */

?>
