/* jQuery Countdown plugin v1.0 Copyright 2010, Vassilis Dourdounis */
!function(a){a.fn.countDown=function(t){return config={},a.extend(config,t),diffSecs=this.setCountDown(config),config.onComplete&&a.data(a(this)[0],"callback",config.onComplete),config.omitWeeks&&a.data(a(this)[0],"omitWeeks",config.omitWeeks),a("#"+a(this).attr("id")+" .digit").html('<div class="top"></div><div class="bottom"></div>'),a(this).doCountDown(a(this).attr("id"),diffSecs,500),this},a.fn.stopCountDown=function(){clearTimeout(a.data(this[0],"timer"))},a.fn.startCountDown=function(){this.doCountDown(a(this).attr("id"),a.data(this[0],"diffSecs"),500)},a.fn.setCountDown=function(t){var e=new Date;t.targetDate?e=new Date(t.targetDate.month+"/"+t.targetDate.day+"/"+t.targetDate.year+" "+t.targetDate.hour+":"+t.targetDate.min+":"+t.targetDate.sec+(t.targetDate.utc?" UTC":"")):t.targetOffset&&(e.setFullYear(t.targetOffset.year+e.getFullYear()),e.setMonth(t.targetOffset.month+e.getMonth()),e.setDate(t.targetOffset.day+e.getDate()),e.setHours(t.targetOffset.hour+e.getHours()),e.setMinutes(t.targetOffset.min+e.getMinutes()),e.setSeconds(t.targetOffset.sec+e.getSeconds()));var s=new Date;return diffSecs=Math.floor((e.valueOf()-s.valueOf())/1e3),a.data(this[0],"diffSecs",diffSecs),diffSecs},a.fn.doCountDown=function(s,i,o){$this=a("#"+s),i<=0&&(i=0,a.data($this[0],"timer")&&clearTimeout(a.data($this[0],"timer"))),secs=i%60,mins=Math.floor(i/60)%60,hours=Math.floor(i/60/60)%24,1==a.data($this[0],"omitWeeks")?(days=Math.floor(i/60/60/24),weeks=Math.floor(i/60/60/24/7)):(days=Math.floor(i/60/60/24)%7,weeks=Math.floor(i/60/60/24/7)),$this.dashChangeTo(s,"seconds_dash",secs,o||800),$this.dashChangeTo(s,"minutes_dash",mins,o||1200),$this.dashChangeTo(s,"hours_dash",hours,o||1200),$this.dashChangeTo(s,"days_dash",days,o||1200),$this.dashChangeTo(s,"weeks_dash",weeks,o||1200),a.data($this[0],"diffSecs",i),i>0?(e=$this,t=setTimeout(function(){e.doCountDown(s,i-1)},1e3),a.data(e[0],"timer",t)):(cb=a.data($this[0],"callback"))&&a.data($this[0],"callback")()},a.fn.dashChangeTo=function(t,e,s,i){$this=a("#"+t);for(var o=$this.find("."+e+" .digit").length-1;o>=0;o--){var n=s%10;s=(s-n)/10,$this.digitChangeTo("#"+$this.attr("id")+" ."+e+" .digit:eq("+o+")",n,i)}},a.fn.digitChangeTo=function(t,e,s){s||(s=800),a(t+" div.top").html()!=e+""&&(a(t+" div.top").css({display:"none"}),a(t+" div.top").html(e||"0").slideDown(s),a(t+" div.bottom").animate({height:""},s,function(){a(t+" div.bottom").html(a(t+" div.top").html()),a(t+" div.bottom").css({display:"block",height:""}),a(t+" div.top").hide().slideUp(10)}))}}(jQuery);

(function($) {
    "use strict";

    function multiParallax() {
        if($('.rh-parallaxel-true').length > 0){
            var $winHeight  = $( window ).height();
            $('.elementor-section').each(function() {
                var $position   = $(this).offset().top - $(document).scrollTop();

                if ( $winHeight >= $position ) {
                    var $layers     = $(this).find('.rh-parallaxel-true');

                    $($layers).each(function() {
                        var $parent     = $(this).parent();
                        var $curPos     = $($parent).offset().top - $(document).scrollTop();
                        var $depth = $(this).prop('class').match(/rh-parallaxel-speed-([0-9]+)/)[1];
                        var $depth = parseInt($depth)/100;
                        if($(this).hasClass('rh-parallaxel-dir-rev')){
                            var $movement   = - $curPos * $depth;
                        }else{
                            var $movement   = $curPos * $depth;
                        }
                        var $translate  = 'translate3d(0, ' + $movement + 'px, 0)';

                        $(this).css({
                            "-webkit-transform" : $translate,   
                            "-moz-transform"    : $translate,
                            "-ms-transform"     : $translate,
                            "-o-transform"      : $translate,
                            "transform"         : $translate
                        });
                        $(this).addClass('parallaxloaded');
                    });
                }
            });
        }
        //BG parallax
        if($('.rh-parallax-bg-true').length > 0){
            var scrollTop = $(window).scrollTop();
            $('.rh-parallax-bg-true').each(function() {
                var paralasicValue = $(this).prop('class').match(/rh-parallax-bg-speed-([0-9]+)/)[1];
                var paralasicValue = parseInt(paralasicValue)/100;
                var backgroundPos = $(this).css('backgroundPosition').split(" ");
                if (backgroundPos[0] == '100%'){
                    var bgx = 'right';
                }
                else if (backgroundPos[0] == '50%'){
                    var bgx = 'center';
                }
                else if (backgroundPos[0] == '0%'){
                    var bgx = 'left';
                }else{
                    var bgx = backgroundPos[0];
                } 
                if (backgroundPos[1] == '0%'){
                    var bgy = 'top';
                }
                else if (backgroundPos[1] == '50%'){
                    var bgy = 'center';
                }
                else if (backgroundPos[1] == '100%'){
                    var bgy = 'bottom';
                } 
                else{
                    var bgy = backgroundPos[1];
                }                                                              
                $(this).css('background-position', ''+bgx+' '+bgy+' -' + scrollTop * paralasicValue + 'px');
            }); 
        }        
    }    

    var RehubWidgetsScripts = function( $scope, $ ) {

        /*Fitvid http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/ */
        (function(e){"use strict";e.fn.fitVids=function(t){var n={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var r=document.head||document.getElementsByTagName("head")[0];var i=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}";var s=document.createElement("div");s.innerHTML='<p>x</p><style id="fit-vids-style">'+i+"</style>";r.appendChild(s.childNodes[1])}if(t){e.extend(n,t)}return this.each(function(){var t=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","object","embed"];if(n.customSelector){t.push(n.customSelector)}var r=".fitvidsignore";if(n.ignore){r=r+", "+n.ignore}var i=e(this).find(t.join(","));i=i.not("object object");i=i.not(r);i.each(function(){var t=e(this);if(t.parents(r).length>0){return}if(this.tagName.toLowerCase()==="embed"&&t.parent("object").length||t.parent(".fluid-width-video-wrapper").length){return}if(!t.css("height")&&!t.css("width")&&(isNaN(t.attr("height"))||isNaN(t.attr("width")))){t.attr("height",9);t.attr("width",16)}var n=this.tagName.toLowerCase()==="object"||t.attr("height")&&!isNaN(parseInt(t.attr("height"),10))?parseInt(t.attr("height"),10):t.height(),i=!isNaN(parseInt(t.attr("width"),10))?parseInt(t.attr("width"),10):t.width(),s=n/i;if(!t.attr("id")){var o="fitvid"+Math.floor(Math.random()*999999);t.attr("id",o)}t.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",s*100+"%");t.removeAttr("height").removeAttr("width")})})}})(window.jQuery||window.Zepto)

        var canSlide = true;

        // Setup a callback for the YouTube api to attach video event handlers
        window.onYouTubeIframeAPIReady = function(){
          // Iterate through all videos
          jQuery('.gallery_top_slider iframe').each(function(){
             var slider = jQuery('.gallery_top_slider');
             // Create a new player pointer; "this" is a DOMElement of the player's iframe
             var player = new YT.Player(this, {
                playerVars: {
                   autoplay: 0
                }
             });

             // Watch for changes on the player
             player.addEventListener("onStateChange", function(state){
                switch(state.data)
                {
                   // If the user is playing a video, stop the slider
                   case YT.PlayerState.PLAYING:
                      slider.flexslider("stop");
                      canSlide = false;
                      break;
                   // The video is no longer player, give the go-ahead to start the slider back up
                   case YT.PlayerState.ENDED:
                   case YT.PlayerState.PAUSED:
                      slider.flexslider("play");
                      canSlide = true;
                      break;
                }
             });

             jQuery(this).data('player', player);
          });
        }

        //SLIDER
        jQuery('.gallery_top_slider').each(function() {
            var tag = document.createElement('script');
                tag.src = "//www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var slider = jQuery(this);
            slider.flexslider({
                animation: "fade",
                controlNav: "thumbnails",
                slideshow: false,
                video: true,
                //useCSS: false,
                before: function(){
                   if(!canSlide)
                      slider.flexslider("stop");
                },
                start: function(slider) {
                   slider.find('img.lazyimages').trigger("unveil");
                   slider.removeClass('loading');
                   jQuery('.flex-control-thumbs img').each(function() {
                      var widththumb = jQuery(this).width();
                      jQuery(this).height(widththumb);
                   });
                }
            });
            slider.on("click", ".flex-prev, .flex-next, .flex-control-nav", function(){
                canSlide = true;
                jQuery('.gallery_top_slider iframe').each(function(){
                   jQuery(this).data('player').pauseVideo();
                });
                if (jQuery('.gallery_top_slider .flex-active-slide iframe').length > 0) {
                   jQuery('.gallery_top_slider .flex-active-slide iframe').data('player').playVideo();
                }
            });
            jQuery(".play3").fitVids();
        });

        jQuery(".re_carousel").each(function(){
          var owl = jQuery(this);
          owl.on('initialized.owl.carousel', function(e) {
            owl.parent().removeClass('loading');
            owl.find('img.lazyimages').trigger("unveil");
          });
          var carouselplay = (owl.data('auto')==1) ? true : false;
          var showrow = (owl.data('showrow') !='') ? owl.data('showrow') : 4;
          var laizy = (owl.data('laizy') == 1) ? true : false;
          var navdisable = (owl.data('navdisable') == 1) ? false : true;
          var loopdisable = (owl.data('loopdisable') == 1) ? false : true;
          var rtltrue = (jQuery('body').hasClass('rtl')) ? true : false;
          if (owl.data('fullrow') == 1) {
             var breakpoint = {
                0:{
                   items:1,
                   nav:true,
                },
                530:{
                   items:2,
                },
                730:{
                   items:3,
                },
                1024:{
                   items:4,
                },                        
                1224:{
                   items:showrow,
                }
             }
          }
          else if (owl.data('fullrow') == 2) {
             var breakpoint = {
                0:{
                   items:1,
                   nav:true,
                },
                768:{
                   items:2,
                },
                1120:{
                   items:3,
                },                        
                1224:{
                   items:showrow,
                }
             }
          } 
          else if (owl.data('fullrow') == 3) {
             var breakpoint = {
                0:{
                   items:1,
                   nav:true,
                },
                768:{
                   items:1,
                },
                1120:{
                   items:1,
                },                        
                1224:{
                   items:showrow,
                }
             }
          }            
          else {
             var breakpoint = {
                0:{
                   items:1,
                   nav:true,
                },
                510:{
                   items:2,
                },
                600:{
                   items:3,
                },            
                1024:{
                   items:showrow,
                }
             }
          }         

          owl.owlCarousel({
            rtl:rtltrue,
             loop:loopdisable,
             dots:false,
             nav: navdisable,
             lazyLoad: laizy,
             autoplay: carouselplay,
             responsiveClass:true,
             navText :["", ""],
             navClass: ["controls prev","controls next"],
             responsive: breakpoint,
             autoplayTimeout : 8000,
             autoplayHoverPause : true,
             autoplaySpeed : 1000,
             navSpeed : 800
          }); 

          var customnext = owl.closest('.custom-nav-car').find('.cus-car-next');
          if(customnext){
            customnext.click(function(){
            owl.trigger('next.owl.carousel', [800]);
          });
          }
          var customprev = owl.closest('.custom-nav-car').find('.cus-car-prev');
          if(customprev){
            customprev.click(function(){
            owl.trigger('prev.owl.carousel', [800]);
          });
          }      

        });

        $('.main_slider').each(function() {
         var slider = $(this);
         slider.flexslider({
            animation: "slide",
            start: function(slider) {
               slider.removeClass('loading');
            }
         });
        });

        $('.wpsm-bar').each(function(){
            $(this).find('.wpsm-bar-bar').animate({ width: $(this).attr('data-percent') }, 1500 );
        }); 

        $('.rate-bar').each(function(){
            $(this).find('.rate-bar-bar').css("width", $(this).attr('data-percent'));
        });                

        $('.rtl .main_slider').each(function() {
           var slider = $(this);
           slider.flexslider({
              animation: "slide",
              rtl: true,
              start: function(slider) {
                 slider.removeClass('loading');
              }
           });
        });

        if ( jQuery( '.rh_wrapper_playlist_player_youtube' ).length > 0) {
            if ( '1' == jQuery( '.rh_wrapper_playlist_player_youtube').data( 'autoplay' ) ) {
                rhYoutubePlayer.rhPlaylistVideoAutoplayYoutube = 1;
            }
            var firstVideo = jQuery( '.rh_wrapper_playlist_player_youtube' ).data( 'first-video' );
            if ( '' !== firstVideo ) {
                rhYoutubePlayer.rhPlaylistIdYoutubeVideoRunning = firstVideo;
                rhYoutubePlayer.playVideo( firstVideo );
            }
        } 

        if ( jQuery( '.rh_wrapper_playlist_player_vimeo' ).length > 0 ) {
          rhPlaylistGeneralFunctions.rhPlaylistAddPlayControl( '.rh_vimeo_control' );
          rhVimeoPlaylistObj.createPlayer( jQuery( '.rh_wrapper_playlist_player_vimeo' ).data('first-video' ) );
        }   

        $(".countdown_dashboard").each(function(){
            $(this).show();
            var id = $(this).attr("id");
            var day = $(this).attr("data-day");
            var month = $(this).attr("data-month");
            var year = $(this).attr("data-year");
            var hour = $(this).attr("data-hour");
            var min = $(this).attr("data-min");
            $(this).countDown({
                targetDate: {
                    "day":      day,
                    "month":    month,
                    "year":     year,
                    "hour":     hour,
                    "min":      min,
                    "sec":      0
                },
                omitWeeks: true,
                onComplete: function() { $("#"+ id).hide() }
            });            
        });

        if ($('.wpsm-tooltip').length > 0) {
            $(".wpsm-tooltip").tipsy({gravity: "s", fade: true, html: true });
        }        

        $('.tabs-menu').on('click', 'li:not(.current)', function() {
            var tabcontainer = $(this).closest('.tabs');
            if(tabcontainer.length == 0) {
                var tabcontainer = $(this).closest('.elementor-widget-wrap');
            }
            $(this).addClass('current').siblings().removeClass('current');
            tabcontainer.find('.tabs-item').hide().removeClass('stuckMoveDownOpacity').eq($(this).index()).show().addClass('stuckMoveDownOpacity');
            tabcontainer.find('img.lazyimages').each(function(){
                var source = $(this).attr("data-src");
                $(this).attr("src", source).css({'opacity': '1'});
            });    
        });        

        $('.radial-progress').each(function(){
          $(this).find('.circle .mask.full, .circle .fill:not(.fix)').animate({  borderSpacing: $(this).attr('data-rating')*18 }, {
              step: function(now,fx) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
              },
              duration:'slow'
          },'linear');

          $(this).find('.circle .fill.fix').animate({  borderSpacing: $(this).attr('data-rating')*36 }, {
              step: function(now,fx) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
              },
              duration:'slow'
          },'linear');                     
        });

        $('img.lazyimages').unveil(40, function() {
            $(this).on('load', function(){
                this.style.opacity = 1;
            });
        }); 

        if($('.rh-particle-canvas-true').length > 0){
            $('.rh-particle-canvas-true').each(function() {
                var particleid = $(this).attr("id");
                var particlejson = $(this).data('particlejson');
                particlesJS(particleid, particlejson, function() {console.log("callback - particles.js config loaded");});
            });
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', RehubWidgetsScripts);
        if ( typeof elementor != "undefined" && typeof elementor.settings.page != "undefined") {
            elementor.settings.page.addChangeCallback( 'content_type', function( newValue ) {
                elementor.saver.update( {
                    onSuccess: function() {
                        //console.log('SAVE');
                        elementor.reloadPreview();
                        elementor.once( 'preview:loaded', function() {
                            elementor.getPanelView().setPage( 'page_settings' );
                        } );
                    }
                } );
            } ); 
            elementor.settings.page.addChangeCallback( '_footer_disable', function( newValue ) {
                elementor.saver.update( {
                    onSuccess: function() {
                        //console.log('SAVE');
                        elementor.reloadPreview();
                        elementor.once( 'preview:loaded', function() {
                            elementor.getPanelView().setPage( 'page_settings' );
                        } );
                    }
                } );
            } );
            elementor.settings.page.addChangeCallback( '_header_disable', function( newValue ) {
                elementor.saver.update( {
                    onSuccess: function() {
                        //console.log('SAVE');
                        elementor.reloadPreview();
                        elementor.once( 'preview:loaded', function() {
                            elementor.getPanelView().setPage( 'page_settings' );
                        } );
                    }
                } );
            } );                             
        }        
    });

    $(window).on('resize scroll', function() {
        multiParallax();
    });     

})(jQuery);
