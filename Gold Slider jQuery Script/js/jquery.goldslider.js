/*
 * jQuery Gold Slider 1.0.2
 *
 * Copyright (c) 2012, 2013, 2014 Ciprian Popescu
 *
 * http://getbutterfly.com/
 */
(function($, undefined) {
	$.widget('gs_void.gs_voidSlider', {
		version: '1.0.2',

		options: {
//			innerItemDelay: 100,
//			animateDuration: 1200,
//			easing: 'easeInOutQuint'
		},
		_initVars: function() {
			this.wrapper   = $(this.element); 
			this.slidesWrapper = this.wrapper.find(".gs_slideshow");        
			this.arrowNext = this.wrapper.find(".gs_next"); 
			this.arrowPrev = this.wrapper.find(".gs_prev");                   

			this.viewSize = {
				width:  this.wrapper.width(),
				height: this.wrapper.height(),
			};

			this.currentIndex = 0;
			this.count = 0;
			this.items = [];
			this.autoScrolling = this.options.interval != 0;
			this.timer = null;
		},

        _init: function() {
            this._initVars();
            this._initItems();
            this.resizeItems();            
            this._render(); 
            this._addEvents();
            this.autoScrollingEnable();                    
        },   

        _initItems: function() {
            var self = this;
            
            this.slidesWrapper.find(".gs_item").each(function() {  
                self.count++;  
                
                var i = self.count-1;   
                var innerCount = 0;                 
                var innerItems = [];                       
                
                self.items[i] = {                    
                    container: $(this),   
                    transition: 'ride'
                };
                
                $(this).find(".gs_top, .gs_slave").each(function() {
                    innerCount++;
                    
                    innerItems[innerCount-1] = self._renderInnerItem(this);                     
                });
                
                self.items[i].items = innerItems;
                self.items[i].count = innerCount;
            });
        },
        
        _render: function() {
            this.items[0].container
                         .show().css({ top: 0, left: 0 });
                         
            this.items[0].container.find('.gs_movingInnerItem').each(function() {
                var parent = $(this).parent();
                $(this).css({width : parent.width(), 
                             height: parent.height()});
            });             
        },
        _renderInnerItem: function(el) {
            $el = $(el);
            var $movingEl = $el.clone();
            $el.html($movingEl);
            
            $el.css({'background': 'none', 
                     'padding'   : 0});
            $movingEl.addClass('gs_movingInnerItem').css({'padding': 0}); 
            
            return { item: $el, movingItem: $movingEl };
        },
        
        _addEvents: function() {
            var self = this;
            
            this.arrowNext.bind("click.gs_void", function() {
                self.autoScrollingDisable();
                self.moveNext("next");
                
            }); 
            this.arrowPrev.bind("click.gs_void", function() {
                self.autoScrollingDisable();
                self.moveNext("prev");
            });    
            
            // resize
            $(window).resize(function() {
                self.resizeItems();
            });
        },
        
        resizeItems: function() {
            this.viewSize = {
              width:  this.wrapper.width(),
              height: this.wrapper.height(),
            };  
            
            this.slidesWrapper.find(".gs_item").css({ width:  this.viewSize.width, height: this.viewSize.height });  
            // resize inner items                                                               
        },
        
        moveNext: function(direction) {
            if (direction == "next") {
                var nextIndex   = (this.currentIndex+1 >= this.count) ? 0 : this.currentIndex+1;
            }
            else {
                var nextIndex = (this.currentIndex-1 < 0) ? this.count-1 : this.currentIndex-1;
            }
            var currentItem = this.items[this.currentIndex];
            var nextItem    = this.items[nextIndex];
            
            this.hideArrows();
            this["__transition_"+ nextItem.transition](currentItem, nextItem, direction);
            this.currentIndex = nextIndex;
        },  
        
        autoScrollingEnable: function() {          
            var self = this;
            
            if ( this.autoScrolling ) {
                this.timer = window.setTimeout(function() { self.moveNext("next"); }, this.options.interval*1000); 
            }           
        },
        autoScrollingDisable: function() {
            this.autoScrolling = false;
            window.clearTimeout(this.timer);    
        },
        
        hideArrows: function() {
            this.arrowNext.hide();
            this.arrowPrev.hide();
        },
        showArrows: function() {
            this.arrowNext.show();
            this.arrowPrev.show();
        },
        
        
        __transition_ride: function(currentItem, nextItem, direction) {  
            var self = this;            
            var animation = function(movingInnerItem, currentItem, nextItem, innerItemDelay, direction, self, isLast) {
                
                window.setTimeout(function() { 
                    movingInnerItem.animate({left: (direction == "next" ? '-' : '') +self.viewSize.width}, self.options.animateDuration, self.options.easing, function() {
                        if (isLast == true) {
                            nextItem.container.find('.gs_movingInnerItem').css('left', 0);
                            currentItem.container.find('.gs_movingInnerItem').css('left', 0);
                            nextItem.container.css({top: 0, left: 0});
                            currentItem.container.hide();

                            self.autoScrollingEnable();
                            self.showArrows();
                        }
                    }); 
                }, 
                innerItemDelay);
                
            };            
            
            nextItem.container.show().css({top: 0, left: (direction == "next" ? '' : '-') +this.viewSize.width+'px'});
            
            currentItem.container.find('.gs_movingInnerItem').each(function() {
                var parent = $(this).parent();
                $(this).css({width : parent.width(), 
                             height: parent.height()});
            }); 
            nextItem.container.find('.gs_movingInnerItem').each(function() {
                var parent = $(this).parent();
                $(this).css({width : parent.width(), 
                             height: parent.height()});
            }); 
                        
            for (var i=0; i<currentItem.count; i++) {
                var movingInnerItem = currentItem.items[i].movingItem;                 
                var delay = self.options.innerItemDelay* ((direction == "next") ? i : currentItem.count-i-1);

                animation(movingInnerItem, currentItem, nextItem, delay, direction, self);                
            }
            
            window.setTimeout(function() { 
                for (var i=0; i<nextItem.count; i++) {
                    var movingInnerItem = nextItem.items[i].movingItem; 
                    var delay  = self.options.innerItemDelay* ((direction == "next") ? i : nextItem.count-i-1);
                    var isLast = (direction == "next" && nextItem.count-1 == i) || (direction != "next" && 0 == i);
                    
                    animation(movingInnerItem, currentItem, nextItem, delay, direction, self, isLast); 
                }
            }, 
            300);            
        },

        destroy: function() {
            $.Widget.prototype.destroy.apply(this, arguments);                     
            this._trigger('onDestroy.gs_void');            
        }
    });
        
})(jQuery);
