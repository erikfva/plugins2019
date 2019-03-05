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

?>
