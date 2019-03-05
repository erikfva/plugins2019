/*
 * TableHeadFixer
 * https://github.com/90arther/jquery.tableheadfixer
 *
 * Copyright (c) 2015 90arther@gmail.com OR caiweiguo@youmi.net
 * Licensed under the MIT license.
 */

// UMD (Universal Module Definition) patterns for JavaScript modules that work everywhere.
// https://github.com/umdjs/umd/blob/master/templates/jqueryPlugin.js
(function (factory, jQuery, Zepto) {

    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery || Zepto);
    }

}(function($) {

    'use strict';

    $.fn.extend({

        tableHeadFixer : function(options) {
            var th          =  this.find('thead'), 
                delayTimer  =  null,                // 事件节流
                defaults    =  {
                'bgColor'   : '#eee',               // 表头的背景颜色
                'z-index'   : '1'                   // 表头的z-index数
              },
              table = this;

            options = $.extend({}, defaults, options);


            // 判断是否存在th标签，如果存在，则进去下一步，否则，输出‘请按照规范写html结构’
            if(th.length === 0) {

                if(!!window.console) {
                    console.log('No se ha encontrado el elemento thead.');
                }

            } else {
            		if(window.self !== window.top){
                        try { //fix: cross domain error
                            $(window.top).on('scroll', function() {
                                fixHead();
                            })
                        } catch(e) {
                            //alert(e); // Security Error (another origin)
                        }
            		}

                $(options.container || window).on('scroll', function() {
                    fixHead();
                });

                $(options.container || document.body).on('touchmove', function(){
                    fixHead();
                }); // for mobile

                $(window).resize(function() {
                  clearTimeout(window.resizedFinished);
                  window.resizedFinished = setTimeout(function(){
                    fixHead();
                  }, 250);
                });

				fixHead();
            }


            function fixHead() {
              var offset      =  table.offset();

                var wtop = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
                try{ //fix: cross domain
                    if(window.self !== window.top){
                        wtop = Math.max(window.top.document.body.scrollTop, window.top.document.documentElement.scrollTop) - 1;
                    }
                } catch(e) {
                }

                var left = Math.max(document.body.scrollLeft, document.documentElement.scrollLeft),
                topValue = (wtop > offset.top) ? (wtop - offset.top) : 0;
                if(window.parent){
                    var iframeY = window.frameElement? $(window.frameElement).offset().top : 0;
                    
                    if(window.parent.frameElement){
                        iframeY = iframeY + $(window.parent.frameElement).offset().top;
                        try{ //Fix : cross domain
                            if( window.top.document.body.scrollTop >= (iframeY +offset.top ) ){
                                topValue = topValue - iframeY;
                                 
                            }                      
                            else
                                topValue =  0;
                        } catch(e) {
                        }
                    }
                }   
                if(typeof options.beforeTransform == 'function' ){
                    topValue = options.beforeTransform(topValue);
                }
                th.css({
                    //'position'          : 'absolute',
                    //'top'               : topValue,
                    'transform-style': 'flat',
                    'transform'         : 'translate(0, '+ (topValue) +'px) translateZ( 5px )',
                    'box-shadow' : topValue > 0? '0 12px 15px 0 rgba(0,0,0,.24), 0 17px 50px 0 rgba(0,0,0,.19)' : 'none',
                    /*'background-color'  : options.bgColor,*/
                    'z-index'           : options['z-index']
                });

            }


        }

    });

}, window.jQuery, window.Zepto));
