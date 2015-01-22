/*
* gbPlayer5 v1.1 - HTML5 Video Player
* Author: getButterfly (Ciprian Popescu)
* Web: http://getbutterfly.com/
*/

/* onclick="this.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);this.mozRequestFullScreen();this.requestFullScreen();"> */

$(function () {
	$.fn.gbPlayer5 = function (gbPlayer) {
		// set default gbPlayer options
		var gbOptions = {
			width: 640,
			height: 360,
			volume: 50,
			skin: 'dark'
		};
		if(gbPlayer)
			$.extend(gbOptions, gbPlayer);

		return this.each(function () {
			// set full width and height for mobile devices
			var gbBrowserDetect = navigator.userAgent.toLowerCase();
			var gbBrowserMatch = gbBrowserDetect.match(/(iphone|ipod|ipad)/);
			if(gbBrowserMatch) {
				$('video').css({
					width: 'auto',
					height: 'auto'
				});
				return;
			}

			// made my own browser detection function
			// it's webkit's fault, not mine!
			$.browser = {};
			$.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit    /.test(navigator.userAgent.toLowerCase());
			$.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
			$.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
			$.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

			/*
			video.addEventListener('loadedmetadata', function() {
				console.log(video.duration);
			});
			*/

			var gbPlayerWrap = $(this).get(0);
			var gbInterval = null;
			var gbPlayerWidth = gbOptions.width;
			var gbPlayerHeight = gbOptions.height;
			var gbIsFS = false;

			$(gbPlayerWrap).wrap('<div class="gbPlayer5 ' + gbOptions.skin + '"></div>');
			var gbPlayerNav = '<div class="gb_nav"><span class="gb_control gb_play"></span><span class="gb_control gb_progressbar_holder"><span class="gb_current_time"></span><span class="gb_progressbar_left"></span><span class="gb_progressbar"><span class="gb_progress"></span><span class="gb_bufferbar"><span class="gb_buffer_progress"></span></span></span><span class="gb_progressbar_right"></span></span><span class="gb_control gb_time"><span class="gb_start_time"></span><span class="gb_end_time"></span></span><span class="gb_control enterFullscreen"></span><span class="gb_control gb_volume"><span class="gb_volume_bg"><span class="gb_sound_control"></span></span></span><span class="gb_control gb_muteOn"></span></div>';

			$(gbPlayerWrap).parent().append('<div class="gb_big_control"><div class="gb_big_play" /></div>' + gbPlayerNav);
			var gbPlayerContainer = $(gbPlayerWrap).parent('.gbPlayer5');
			var gbNavElement = $('.gb_nav', gbPlayerContainer);
			var gbControlElement = $('.gb_control', gbPlayerContainer);
			var gbBigControlElement = $('.gb_big_control', gbPlayerContainer);
			var gbPlayElement = $('.gb_play', gbPlayerContainer);
			var gbPauseElement = $('.gb_pause', gbPlayerContainer);
			var gbProgressElement = $('.gb_progressbar_holder', gbPlayerContainer);
			var gbTimeElement = $('.gb_time', gbPlayerContainer);
			var gbEnterFullscreenElement = $('.enterFullscreen', gbPlayerContainer);
			var gbExitFullscreenElement = $('.exitFullscreen', gbPlayerContainer);
			var gbVolumeElement = $('.gb_volume', gbPlayerContainer);
			var gbMuteOnElement = $('.gb_muteOn', gbPlayerContainer);
			var gbMuteOffElement = $('.gb_muteOff', gbPlayerContainer);
			var gbBigPlayWidth = gbBigControlElement.find('.gb_big_play').outerWidth(true);
			var gbBigPlayHeight = gbBigControlElement.find('.gb_big_play').outerHeight(true);

			gbPlayerContainer.css({
				width: gbPlayerWidth,
				height: gbPlayerHeight
			});
			gbPlayerContainer.find('video').css({
				width: gbPlayerWidth,
				height: gbPlayerHeight
			});
			gbNavElement.css({
				width: gbPlayerWidth
			});

			gbPlayerVolumeEvent();
			gbPlayerResize();
			gbElementsRedraw();
			thread = null;
			$(document).mousemove(gbNavShow);

			function gbNavHide() {
				$('.gbPlayer5.gb_active').find('.gb_nav').fadeOut('fast');
				return thread;
			}
			function gbNavShow() {
				$('.gbPlayer5.gb_active').find('.gb_nav').fadeIn('fast');
				clearTimeout(thread);
				thread = setTimeout(gbNavHide, 3000); // hide gbPlayer controls after 3 seconds of inactivity
			}

			function gbPlayerRun(gbPlayerBuffer) {
				var 	gbPlayerBufferLength = gbPlayerBuffer.originalEvent.length,
						gbPlayerBufferLoad = gbPlayerBuffer.originalEvent.loaded,
						gbPlayerBufferTotal = gbPlayerBuffer.originalEvent.total;
				if(gbPlayerBufferLength)
					$('.gb_buffer_progress').width(Math.round(gbPlayerBufferLoad / gbPlayerBufferTotal * 100) + '%');
			}

			$(gbPlayerWrap).dblclick(function () {
				if(gbPlayerContainer.hasClass('enterFullscreen'))
					gbExitFullscreenElement.click();
				else
					gbEnterFullscreenElement.click();
			});

			gbBigControlElement.bind('click', function () {
				gbPlayElement.click();
				if(!$(this).data('clicked')) {
					$(this).data('processing', true);
					$(this).removeData('processing');
				}
			});
			gbControlElement.bind('click', function () {
				var gbNavClassEvent = $(this).prop('class').split(' ').slice(1); // this only works with jQuery 1.7.1 due to 'prop' argument
				if(gbNavClassEvent == 'gb_play') {
					gbPlayerWrap.play();
					$(this).removeClass('gb_play').addClass('gb_pause');
					gbBigControlElement.fadeOut();
					$('.gbPlayer5').each(function () {
						$(this).removeClass('gb_active');
					});
					$(this).closest('.gbPlayer5').addClass('gb_active');
				}
				if(gbNavClassEvent == 'gb_pause') {
					gbPlayerWrap.pause();
					gbPlayerResize();
					$(this).removeClass('gb_pause').addClass('gb_play');
					gbBigControlElement.fadeIn();
				}
				if(gbNavClassEvent == 'enterFullscreen') {
					gbIsFS = true;
					gbPlayerResize();
					$(this).removeClass('enterFullscreen').addClass('exitFullscreen');
					// true fullscreen // bugged // on mouse move controls make the screen black
					//this.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
					//this.mozRequestFullScreen();
					//this.requestFullScreen();
				}
				if(gbNavClassEvent == 'exitFullscreen') {
					gbIsFS = false;
					gbPlayerResize();
					$(this).removeClass('exitFullscreen').addClass('enterFullscreen');
				}
				if(gbNavClassEvent == 'gb_muteOn') {
					gbPlayerWrap.volume = 0;
					gbVolumeElement.find('.gb_sound_control').css('width', 0);
					$(this).removeClass('gb_muteOn').addClass('gb_muteOff');
				}
				if(gbNavClassEvent == 'gb_muteOff') {
					gbPlayerVolumeEvent();
					$(this).removeClass('gb_muteOff').addClass('gb_muteOn');
				}
			});

			function gbPlayerVolumeEvent() {
				if($(gbPlayerWrap).data('volume'))
					var gbPlayerVolumeEvent = $(gbPlayerWrap).data('volume');
				else
					var gbPlayerVolumeEvent = gbOptions.volume / 100;

				soundWidth = Math.round(gbPlayerVolumeEvent * gbVolumeElement.width());
				gbVolumeElement.find('.gb_sound_control').css('width', soundWidth + 'px');
				gbPlayerWrap.volume = gbPlayerVolumeEvent;

				if(soundWidth == 0) gbPlayerWrap.volume = 0;
				if(soundWidth > 0) gbPlayerWrap.volume = gbPlayerVolumeEvent;
			}

			gbVolumeElement.bind('click', function (gbPlayerBuffer) {
				$('.gb_muteOff').removeClass('gb_muteOff').addClass('gb_muteOn');
				var gbOffset = gbVolumeElement.offset();
				var gbVBind = Math.round(gbPlayerBuffer.pageX - gbOffset.left);
				var gbVBindTotal = gbVBind / gbVolumeElement.width();
				$(gbPlayerWrap).data('volume', gbVBindTotal);
				gbPlayerVolumeEvent();
			});

			var gbProgressAction = false;
			gbProgressElement.find('.gb_progressbar').mousedown(function () {
				gbProgressAction = true;
			});
			gbProgressElement.find('.gb_progressbar').bind('mouseup', function () {
				gbProgressAction = false;
			});
			gbProgressElement.find('.gb_progressbar').bind('mousemove', function (gbPlayerBuffer) {
				var gbOffset = $(this).offset();
				progressbarWidth = Math.round(gbPlayerBuffer.pageX - gbOffset.left);
				percent = progressbarWidth / gbProgressElement.find(".gb_progressbar").width() * 100;
				playTime = gbPlayerWrap.duration * percent / 100;
				var gbProgressTimeWidth = gbProgressElement.parent().find(".gb_current_time").width();
				var gbProgressTimeWidthH = gbProgressTimeWidth / 2 - 4;
				gbProgressElement.find('.gb_current_time').css('left', progressbarWidth - gbProgressTimeWidthH).stop().animate({
					top: -21,
					opacity: 0.9
				}, 100).html(gbGetWrapDuration(playTime));
			}).mouseout(function () {
				$(this).find('.gb_current_time').stop().animate({
					opacity: 0
				}, 100);
			});
			gbProgressElement.bind('mousedown mouseover mousemove', function (gbPlayerBuffer) {
				if(gbProgressAction == false)
					return;

				var gbOffset = $(this).find('.gb_progressbar').offset();
				progressbarWidth = Math.round(gbPlayerBuffer.pageX - gbOffset.left);
				$(this).find('.gb_progress').css({
					width: progressbarWidth
				});
				percent = progressbarWidth / $(this).find('.gb_progressbar').width() * 100;
				playTime = gbPlayerWrap.duration * percent / 100;
				gbPlayerWrap.currentTime = playTime;
			}).mouseout(function () {
				$(this).find('.gb_current_time').stop().animate({
					opacity: 0
				}, 100);
			});
			$(gbPlayerWrap).bind({
				timeupdate: function () {
					gbPlayerInit();
				},
				ended: function () {
					gbVideoEndEvent();
				},
				progress: function (gbPlayerBuffer) {
					gbPlayerRun(gbPlayerBuffer);
				}
			});

			function gbPlayerInit() {
				var gbTimeWidth = 0;
				if(typeof gbPlayerWrap.duration != 'undefined' && gbPlayerWrap.duration > 0)
					gbTimeWidth = 100 * gbPlayerWrap.currentTime / gbPlayerWrap.duration;

				// check for 'undefined' error
				if(video.readyState > 0) {
					gbProgressElement.find('.gb_progress').css('width', gbTimeWidth + '%');
					gbTimeElement.find('.gb_start_time').html(gbGetWrapDuration(gbPlayerWrap.currentTime));
					gbTimeElement.find('.gb_end_time').html(gbGetWrapDuration(gbPlayerWrap.duration));
				}

				// check for 'undefined' error
				if(video.readyState > 0) {
					setTimeout(function () {
						gbTimeElement.animate({
							opacity: 1
						}, 500);
					}, 3000); // show video duration after 3 seconds, to avoid 'undefined' values
				}

				if($.browser.webkit) {
					var gbTimeWidthAdvance = Math.round(gbPlayerWrap.duration / 2) * 1000;
					if(gbPlayerWrap.buffered.length >= 1) {
						$('.gb_buffer_progress').animate({
							width: '100%'
						}, gbTimeWidthAdvance).delay(200);
					}
				}
			}

			function gbVideoEndEvent() {
				if(gbPlayerWrap.ended == true) {
					gbPlayerContainer.find('.gb_pause').removeClass('gb_pause').addClass('gb_play');
					gbBigControlElement.fadeIn();
					clearInterval(gbInterval);
				}
			}

			function gbPlayerResize() {
				if(gbIsFS == true) {
					$('body').css({
						overflow: 'hidden'
					});
					gbPlayerContainer.css({
						width: $(window).width(),
						height: $(window).height(),
						position: 'fixed',
						top: 0,
						left: 0,
						'z-index': 9999
					});
					$(gbPlayerWrap).css({
						width: $(window).width(),
						height: $(window).height()
					});
					gbNavElement.css({
						position: 'absolute',
						bottom: 0,
						left: 0,
						width: gbPlayerContainer.width()
					});
					gbBigControlElement.css({
						width: $(window).width(),
						height: $(window).height()
					});
					gbBigControlElement.find('.gb_big_play').css({
						top: $(window).height() / 2 - gbBigPlayHeight / 2,
						left: $(window).width() / 2 - gbBigPlayWidth / 2
					});
					gbElementsRedraw();
				} else {
					$('body').css({
						overflow: 'visible'
					});
					gbPlayerContainer.css({
						width: gbPlayerWidth,
						height: gbPlayerHeight,
						position: 'relative',
						'z-index': 1
					});
					$(gbPlayerWrap).css({
						width: gbPlayerWidth,
						height: gbPlayerHeight
					});
					gbNavElement.css({
						position: 'absolute',
						bottom: 0,
						left: 0,
						width: gbPlayerWidth
					});
					gbBigControlElement.css({
						width: gbPlayerWidth,
						height: gbPlayerHeight
					});
                     gbBigControlElement.find(".gb_big_play").css({
                         position: "absolute",
                         top: gbPlayerHeight / 2 - gbBigPlayHeight / 2,
                         left: gbPlayerWidth / 2 - gbBigPlayWidth / 2
                     });
                     gbElementsRedraw();
                 }
             }


             function gbElementsRedraw() {
                 var gbPlayerOuterWidth = 0;
                 gbControlElement.each(function () {
                     gbPlayerOuterWidth += $(this).outerWidth(true);
                 });
                 progress_width = gbProgressElement.outerWidth(true);
                 var gbPlayerMainWidth = gbPlayerContainer.outerWidth() - gbPlayerOuterWidth + progress_width;
                 gbProgressElement.css({
                     width: gbPlayerMainWidth
                 });
                 gbProgressElement.find(".gb_progressbar").css({
                     width: gbPlayerMainWidth - 4
                 });
                 gbProgressElement.find(".gb_bufferbar").css({
                     width: gbPlayerMainWidth - 4
                 });
             }

             $(document).keydown(function (gbPlayerBuffer) {
                 if (gbPlayerBuffer.which === 32) {
                     if (gbIsFS == true && gbPlayerContainer.hasClass("gb_active")) {
                         gbPlayElement.click();
                     }
                 }
                 if (gbPlayerBuffer.keyCode == 27) {
                     gbPlayerContainer.find(".exitFullscreen").click();
                 }
             });

             function gbGetTimeFormat() {
                 var gbGetVideoDuration = gbGetWrapDuration(gbPlayerWrap.duration);
                 var gbGetDurationStringLength = gbGetVideoDuration.length;
                 if (gbGetDurationStringLength == 4) {
                     return "0:00";
                 }
                 if (gbGetDurationStringLength == 5) {
                     return "00:00";
                 }
                 if (gbGetDurationStringLength == 7) {
                     return "0:00:00";
                 }
             }


             function gbGetWrapDuration(gbArg) {
                 var gbTimeTotal = gbPlayerWrap.duration;
                 sec = gbArg;
                 var gbTimeH = Math.floor(sec / 3600);
                 var gbTimeM = Math.floor(sec % 3600 / 60);
                 var gbTimeS = Math.floor(sec % 3600 % 60);
                 if (sec == 0) {
                     results = gbGetTimeFormat();
                 } else {
                     if (gbTimeTotal > 3600) {
                         var gbTimeTotalH = gbTimeH + ":";
                         gbTimeElement.find(".gb_current_time").addClass("long");
                     } else {
                         if (gbTimeTotal < 3600) {
                             var gbTimeTotalH = "";
                             if (gbTimeElement.find(".gb_current_time").hasClass("long")) {
                                 gbTimeElement.find(".gb_current_time").removeClass("long");
                             }
                         }
                     }
                     if (gbTimeTotal < 600) {
                         var gbTimeTotalM = "" + gbTimeM + ":";
                     } else {
                         if (gbTimeH == 0 && gbTimeM < 10) {
                             var gbTimeTotalM = "0" + gbTimeM + ":";
                         } else {
                             if (gbTimeH == 0 && gbTimeM > 10) {
                                 var gbTimeTotalM = "" + gbTimeM + ":";
                             } else {
                                 if (gbTimeH > 0 && gbTimeM < 10) {
                                     var gbTimeTotalM = "0" + gbTimeM + ":";
                                 } else {
                                     var gbTimeTotalM = gbTimeM + ":";
                                 }
                             }
                         }
                     }
                     if (gbTimeS < 10) {
                         var gbTimeTotalS = "0" + gbTimeS;
                     } else {
                         var gbTimeTotalS = gbTimeS;
                     }
                     results = gbTimeTotalH + gbTimeTotalM + gbTimeTotalS;
                 }
                 return results;
             }

             $(window).load(function () {
                 gbPlayerInit();
             });
             $(window).resize(function () {
                 gbPlayerResize();
             });
             if ($.browser.mozilla) {
                 gbNavElement.css("MozUserSelect", "none");
             } else {
                 if ($.browser.msie) {
                     gbNavElement.bind("selectstart", function () {
                         return false;
                     });
                 } else {
                     gbNavElement.mousedown(function () {
                         return false;
                     });
                 }
             }
         });
     };
 });
 