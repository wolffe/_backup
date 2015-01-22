(function ($) {
	$.fn.prompter = function (roller, stepDelay) {
		if(stepDelay == undefined || isNaN(parseInt(stepDelay, 10)) || stepDelay <= 0) stepDelay = 40;

		var newPrompter = [],
		last = this.length;

		function getReset(newDir, prompterFlare, prompterState) {
			var behavior = 'scroll', width = prompterState.width, dir = prompterState.dir;
			var r = 0;
			r = newDir == -1 ? prompterFlare[prompterState.widthAxis] : 0;
			return r;
		}

		function animatePrompter() {
			var i = newPrompter.length,
			prompterFlare = null,
			$prompterFlare = null,
			prompterState = {},
			newPrompterList = [],
			hitedge = false;

			while(i--) {
				prompterFlare = newPrompter[i];
				$prompterFlare = $(prompterFlare);
				prompterState = $prompterFlare.data('prompterState');

				if($prompterFlare.data('paused') !== true) {
					prompterFlare[prompterState.axis] += (prompterState.rollsize * prompterState.dir);

					hitedge = prompterState.dir == -1 ? prompterFlare[prompterState.axis] <= getReset(prompterState.dir * -1, prompterFlare, prompterState) : prompterFlare[prompterState.axis] >= getReset(prompterState.dir * -1, prompterFlare, prompterState);
					if(prompterState.behavior == 'scroll' && prompterState.last == prompterFlare[prompterState.axis]) {
						prompterState.last = -1;

						$prompterFlare.trigger('stop');

						prompterState.loops--;
						prompterFlare[prompterState.axis] = getReset(prompterState.dir, prompterFlare, prompterState);
						$prompterFlare.trigger('end');
					}
					else {
						newPrompterList.push(prompterFlare);
					}
					prompterState.last = prompterFlare[prompterState.axis];

					$prompterFlare.data('prompterState', prompterState);
				}
				else {
					newPrompterList.push(prompterFlare);                    
				}
			}
			newPrompter = newPrompterList;

			if(newPrompter.length) {
				setTimeout(animatePrompter, stepDelay);
			}            
		}

		this.each(function (i) {
			var $prompter = $(this),
				width = $prompter.attr('width') || $prompter.width(),
				height = $prompter.attr('height') || $prompter.height(),
				$prompterFlare = $prompter.after('<div ' + (roller ? 'class="' + roller + '" ' : '') + 'style="display: block-inline; width: ' + width + 'px; height: ' + height + 'px; overflow: hidden;"><div style="float: left; white-space: nowrap;">' + $prompter.html() + '</div></div>').next(),
				prompterFlare = $prompterFlare.get(0),
				hitedge = 0,
				direction = 'up',
				prompterState = {dir: 1, axis: 'scrollTop', widthAxis: 'scrollWidth', last: -1, loops: 0, rollsize: 2, behavior: 'scroll', width: width};
			$prompter.remove();

			$prompterFlare.find('> div').css('padding', '128px 0'); // add top padding

			$prompterFlare.bind('stop', function () { // prompter events
				$prompterFlare.data('paused', true);
			}).bind('pause', function () {
				$prompterFlare.data('paused', true);
			}).bind('start', function () {
				$prompterFlare.data('paused', false);
			}).bind('unpause', function () {
				$prompterFlare.data('paused', false);
			}).data('prompterState', prompterState);

			newPrompter.push(prompterFlare);

			prompterFlare[prompterState.axis] = getReset(prompterState.dir, prompterFlare, prompterState);
			$prompterFlare.trigger('start');

			if(i+1 == last) animatePrompter();
		});            
		return $(newPrompter);
	};
}(jQuery));
