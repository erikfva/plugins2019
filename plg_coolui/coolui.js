$(function () {
    "use strict";   

    //show preloader when click on html elements
     $('.ew-table-header-cell>.dropdown-item, .nav-link:not(.active):not([data-widget]), .ew-row-link, .btn:not(.dropdown-toggle,.ew-search-toggle,.datepickerbutton) , .ew-breadcrumbs a').on('click',function(){ 
        //$(".preloader").show();
        showSpinner();
    }); 

    var navbar = document.querySelector('.main-header.navbar');
    mobileDetect();
   
    /****************************************************/
    //* Personaliza el estilo de tus componentes aqui *//
    /****************************************************/
    applyCoolForm();
    $('input[type=text]:not([readonly]):not(.cool-ui)').addClass('cool-ui').parent().addClass('md-form');

    //** TABLES */  
    
    var table =  $('.ew-table').not('.hidden, .ew-master-table');
    table.each(function(){
        this.dataset.theadw = $(this).find('thead').width();
        if(typeof $.fn.tableHeadFixer === 'function' ){ //If table-fixed-header load?
            $(this).tableHeadFixer({
                "z-index" : 4,
                stickyClass : 'indigo text-white',
                beforeTransform: function(top){
                    //console.log(top)
                    return top > 0? top + parseInt( $('.main-header').height() ) : top;
                }
            })
        }
    })

    responsiveTable();
        
    //*--------------------------------------------------- */

    showCoolComponents();

    onResizeWindow(function () {
        mobileDetect();
        responsiveTable();        
    });

   
    //** PAGER CONTROL */
    if($('.ew-prev-next').length){
        window.pagerWidth = $(navbar).width();
        if($(navbar).width() > 414) $('.ew-grid-lower-panel').removeClass('collapse-pager');
        onResizeWindow(function () {
            if( window.pagerWidth > 414 && $(navbar).width() <= 414 )
                $('.ew-grid-lower-panel').toggleClass('collapse-pager', $(navbar).width() <= 414);
            window.pagerWidth = $(navbar).width();
        })
    }

    //** MODALS DIALOGS */
    var hideVScroll = function (event) {
        /* Haz algo aquí */
        $('html').css('overflow-y','hidden');
    };

    $('#ew-modal-dialog').on('shown.bs.modal', function () {
        hideSpinner();
        applyCoolForm({container:this});
        setTimeout(() => {
            hideVScroll();
            window.addEventListener('resize',hideVScroll,false);
            $('#ew-modal-dialog').scrollTop(0);
        }, 200);
        
    }).on('hidden.bs.modal', function(){
        $('html').css('overflow-y','auto');
        window.removeEventListener('resize', hideVScroll, false);
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

    function mobileDetect(){
        ew.MOBILE_DETECT.constructor(window.navigator.userAgent);
        ew.IS_MOBILE = !!ew.MOBILE_DETECT.mobile();
        $('body').toggleClass('mobile', ew.IS_MOBILE && !ew.IS_TABLET());     
    }

    function responsiveTable(){
        mobileDetect();
        if(ew.IS_MOBILE && !ew.IS_TABLET()) return;
        let grid = $('.ew-grid:not(.ew-master-div');

        grid.each(function(){
            //$(this).css('width','100%');
            let table = $(this).find('.ew-table');
            let theadw = parseInt(table[0].dataset.theadw || table.find('thead').width());
            $('html').css('width', 'inherit');

            let navbarw = parseInt($(navbar).width());
            if(theadw <= navbarw ){             
                table.removeClass('vertical-table');
            }else{
                table.toggleClass('vertical-table', $(navbar).width() <= 815 );               
            } 
        //    $(this).css('width', table.hasClass('vertical-table')?'inherit': ( thead.width() + 20 + 'px' ) );     
            //fix: x-scroollbars in large tablelist
            if (table.hasClass('vertical-table')){
                $('html').css('width',  $(navbar).width() );
            } else {
                theadw > $('html').width() && $('html').width( theadw + 70);
            }                     
        })
    }

    function applyCoolForm(op){
        
        $( (op && op.container) || window.document).find('.form-group.row').each(function(){
            let input = $(this).find('input:text:not([readonly])');
            let isCoolUI = input.hasClass('cool-ui');
            if(!isCoolUI && input.length){
                input.wrap('<div class="md-form"></div>').attr('placeholder', '').addClass('cool-ui');
                $(input[0].labels[0])
                    .removeClass('col-form-label')
                    .insertAfter(input);
                input.val() != '' && input.siblings('label, i').addClass('active');
            }
            //.wrap('<div class="md-form"></div>')
            input.blur(function() {
                //console.log(this);
                if(this.value == '') $(this).siblings('label, i').removeClass('active');
            })

        })
        
        //Reestableciendo los componentes personalizables
        if(op && op.container) showCoolComponents(op.container);
    }
    function hideSpinner(){
        $("#mdb-preloader, .mdb-preloader").hide().removeClass('pending');
    }
    function showSpinner(){
        $("#mdb-preloader").addClass('pending');
        setTimeout(() => {
            $("#mdb-preloader.pending").show().removeClass('pending');
        }, 500);
        
    }
    function showCoolComponents(op){
        //Reestableciendo los componentes personalizables
        let container =  $( (op && op.container) || window.document);
        container.find('.lazy-render').css({'visibility':'inherit','opacity':'inherit'});
    }
})
