$(function () {
    "use strict";
    var navbar = document.querySelector('.main-header.navbar');
    
    //hide preload spinner
    $(".preloader").fadeOut(50);
    //show preloader when click on html elements
    $('.ew-row-link, .btn:not(.dropdown-toggle,.ew-search-toggle,.datepickerbutton) , .ew-breadcrumbs a,.nav-sidebar .nav-item').on('click',function(){ 
        $(".preloader").show();
    });

    //hide left menu 
    //$('[data-widget="pushmenu"]').PushMenu('collapse');
   
    //show brand if not empty text
    if($('.brand-link.bg-write').text() != ''){ 
        $('.brand-link.bg-write').css({'display':'inline'});
    }
    /****************************************************/
    //* Personaliza el estilo de tus componentes aqui *//
    /****************************************************/

    applyCoolForm();

    $('input[type=text]:not([readonly])').parent().addClass('md-form');
    $('.ew-search-panel button').addClass('btn-tb');
    
    //Botones de edicion de registros en tablas de listas.
    $('.ew-row-link').addClass('btn-floating btn-xs').find('i').addClass('fa-1x');
    $('.ew-row-link.ew-delete').addClass('btn-danger');
    $('.ew-row-link.ew-edit').addClass('btn-cyan');
    $('.ew-row-link.ew-add').addClass('btn-success');
    $('.ew-row-link.ew-view').addClass('btn-info');
    $('.ew-row-link.ew-copy').addClass('btn-light-green');

    showCoolComponents();

    //** TABLES */
    if(typeof $.fn.tableHeadFixer === 'function' ){ //If table-fixed-header load?
        $('.ew-table').not('.hidden, .ew-master-table').find('thead').addClass('bg-white').end().tableHeadFixer({
            "z-index" : 4,
            beforeTransform: function(top){
                //console.log(top)
                return top > 0? top + parseInt( $('.main-header').height() ) : top;
            }
        })
    }

    //Make tables responsive for mobile.
    responsiveTable();
    //fix: x-scroollbars in large tablelist
    $('.ew-grid').length &&  $('.ew-grid').width()> $('html').width() && $('html').width( $('.ew-grid').width() );
    
    onResizeWindow(function () {
        //Make tables responsive for mobile.
        responsiveTable();
        //console.log($('.ew-grid').width(), window.innerWidth, $(navbar).width() );
        $('.ew-grid').length &&  $('html').width( $('.ew-grid').width()> $(navbar).width()? $('.ew-grid').width() : $(navbar).width() );
    });

    //** PAGER CONTROL */
    
    //Fixed records navigator on bottom
    $('.ew-grid-lower-panel').addClass('navbar fixed-bottom navbar-light bg-white p-0 pl-3 pt-2');
    //Create button toggle for toggle prev-next
    if($('.ew-prev-next').length){
        let btnTogglePager =  $('<a class="pl-1 btn-floating btn-primary btn-toggle-pager"><i class="fa fa-forward"></i></a>');
        btnTogglePager.click(function(){
            $('.ew-grid-lower-panel').removeClass('collapse-pager');
        }).appendTo('.ew-grid-lower-panel');
        let btnClosePager = $('<a class="btn-floating btn-info btn-xs close-pager"><i class="fa fa-close fa-1x"></i></a>');
        btnClosePager.appendTo('.ew-grid-lower-panel')
        .click(function(){
            $('.ew-grid-lower-panel').addClass('collapse-pager');
        });
        window.pagerWidth = $(navbar).width();
        if($(navbar).width() <= 414) $('.ew-grid-lower-panel').addClass('collapse-pager');
        onResizeWindow(function () {
            if( window.pagerWidth > 414 && $(navbar).width() <= 414 )
                $('.ew-grid-lower-panel').toggleClass('collapse-pager', $(navbar).width() <= 414);
            window.pagerWidth = $(navbar).width();
        })
    }


    //** MODALS DIALOGS */
    var hiddeVScroll = function (event) {
        /* Haz algo aquí */
        $('html').css('overflow-y','hidden');
    };

    $('#ew-modal-dialog').on('shown.bs.modal', function () {
        applyCoolForm({container:this});
        setTimeout(() => {
            hiddeVScroll();
            window.addEventListener('resize',hiddeVScroll,false);
            $('#ew-modal-dialog').scrollTop(0);
        }, 200);
        
    }).on('hidden.bs.modal', function(){
        $('html').css('overflow-y','auto');
        window.removeEventListener('resize', hiddeVScroll, false);
    })

    function onResizeWindow(f,t){
        if(typeof f !== 'function') return;
        var _resizeTimer = null;
        var time = (typeof t !== 'undefined')? parseInt(t) : 200;
        window.addEventListener("resize", function(){	
            if(_resizeTimer){
                clearTimeout(_resizeTimer);
            } 
            _resizeTimer = setTimeout(function(){
                f(); 
            }, time);
        });
    }

    function responsiveTable(){
        $('.ew-grid:not(.ew-master-div)').each(function(){
            //$(this).css('width','100%');
            
            if(!this.dataset.initialWidth){
                this.dataset.initialWidth =  $(this).width();
                //console.log(this.dataset.initialWidth);
            }

            if(this.dataset.initialWidth > $(navbar).width() && $(navbar).width() <= 815  ){
                $(this) //.css('width', currentWindowWidth <=812? currentWindowWidth + 'px':'initial')
                .find('.ew-table').addClass('vertical-table');
                $(this).css('width', $(navbar).width() - 10 );
                
            } else {
                $(this).width(this.dataset.initialWidth)
                .find('.ew-table').removeClass('vertical-table'); 
            }                   
            
        });
    }

    function applyCoolForm(op){
        
        $( (op && op.container) || window.document).find('.form-group.row').each(function(){
            let input = $(this).find('input:text:not([readonly])').attr('placeholder', '').wrap('<div class="md-form"></div>')
            .blur(function() {
                //console.log(this);
                if(this.value == '') $(this).siblings('label, i').removeClass('active');
            })
            input.length &&  $(input[0].labels[0]).removeClass('col-form-label').insertAfter(input);
            if(input.val() != '') input.siblings('label, i').addClass('active');
        })
        
        //Reestableciendo los componentes personalizables
        if(op && op.container) showCoolComponents(op.container);
    }

    function showCoolComponents(op){
        //Reestableciendo los componentes personalizables
        let container =  $( (op && op.container) || window.document);
        let costumizable = '.ew-grid, .ew-row-link, .ew-search-panel button, input[type=text],.form-group.row';
        container.find(costumizable).css({'visibility':'inherit','opacity':'inherit'});
    }
})
