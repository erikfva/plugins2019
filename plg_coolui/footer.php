  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="plugins2019/plg_coolui/js/mdb.min.js"></script>
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
	$elements = $document->find('.ew-row-link');
	foreach($elements as $btn) {
		$btn->class = @$btn->class. ' btn-floating btn-xs cool-ui';	//$('.ew-row-link').addClass('btn-floating btn-xs').find('i').addClass('fa-1x');
		foreach($btn->findInDocument('i') as $i) {
			$i->class = @$i->class. ' fa-1x';
		}
		strpos(@$btn->class, 'ew-delete') && ($btn->class = @$btn->class. ' btn-danger'); //$('.ew-row-link.ew-delete').addClass('btn-danger');
		strpos(@$btn->class, 'ew-edit') && ($btn->class = @$btn->class. ' btn-cyan'); //$('.ew-row-link.ew-edit').addClass('btn-cyan');
		strpos(@$btn->class, 'ew-add') && ($btn->class = @$btn->class. ' btn-success'); //$('.ew-row-link.ew-add').addClass('btn-success');
		strpos(@$btn->class, 'ew-view') && ($btn->class = @$btn->class. ' btn-info'); //$('.ew-row-link.ew-view').addClass('btn-info');
		strpos(@$btn->class, 'ew-copy') && ($btn->class = @$btn->class. ' btn-light-green'); //$('.ew-row-link.ew-copy').addClass('btn-light-green');
	}	
	
	/*-------------------------------------------------*/

	//***********************************/
	// table style
	//***********************************/
	$MobileDetect = new \Mobile_Detect();
	$elements = $document->find("//div[contains(@class,'ew-grid') 
	and not(contains(@class, 'ew-master-div'))]", Query::TYPE_XPATH);
	foreach($elements as $grid) {
		$tables = $grid->findInDocument("//table[contains(@class,'ew-table') 
		and not(contains(@class, 'hidden')) 
		and not(contains(@class, 'ew-master-table'))]", Query::TYPE_XPATH);
		foreach($tables as $table) {
			$MobileDetect->isMobile() && !$MobileDetect->isTablet() && ($table->class = @$table->class. ' vertical-table');
			!$MobileDetect->isMobile() && ($grid->class = @$grid->class. ' lazy-render');
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
