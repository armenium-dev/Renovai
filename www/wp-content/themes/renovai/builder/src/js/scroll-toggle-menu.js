(function (factory, jQuery, Zepto) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports === 'object' && typeof Meteor === 'undefined') {
		module.exports = factory(require('jquery'));
	} else {
		factory(jQuery || Zepto);
	}
}(function ($) {
	$.fn.exists = function () {
		return this.length !== 0;
	};

	var classNames = {
		smToggleMenu: 'sm-toggle-menu',
		smTogglePosition: 'sm-toggle-position',

		positionStatic: 'position-static',
		positionFixed: 'position-fixed'
	};

	var ids = {};

	var buildSelectors = function (selectors, source, characterToPrependWith) {
		$.each(source, function (propertyName, value) {
			selectors[propertyName] = characterToPrependWith + value;
		});
	};

	$.buildSelectors = function (classNames, ids) {
		var selectors = {};
		if (classNames) {
			buildSelectors(selectors, classNames, ".");
		}
		if (ids) {
			buildSelectors(selectors, ids, "#");
		}
		return selectors;
	};

	var selectors = $.buildSelectors(classNames, ids);

	var $smToggleMenu,
		$smTogglePosition,
		smTogglePositionOffset,
		menuHeight = 84;

	var render = function() {
		if ($smToggleMenu.exists()) {
			var $this = $(this),
				thisScrollTop = $this.scrollTop();

			smTogglePositionOffset = $smTogglePosition.offset();

			if(smTogglePositionOffset != undefined){

				if(thisScrollTop >= (smTogglePositionOffset.top - menuHeight) && $smToggleMenu.hasClass(classNames.positionStatic)){
					$smToggleMenu.fadeIn('fast', function(){
						$(this).removeClass(classNames.positionStatic).addClass(classNames.positionFixed).fadeIn('fast');
					});
				}
				if(thisScrollTop <= (smTogglePositionOffset.top - menuHeight) && $smToggleMenu.hasClass(classNames.positionFixed)){
					$smToggleMenu.fadeIn('fast', function(){
						$(this).removeClass(classNames.positionFixed).addClass(classNames.positionStatic).fadeIn('fast');
					});
				}
			}
		}
	};

	$(function(){
		$smToggleMenu = $(selectors.smToggleMenu);
		$smTogglePosition = $(selectors.smTogglePosition);
		smTogglePositionOffset = $smTogglePosition.offset();
		render();
	});

	$(document).on('resize', function(){
		smTogglePositionOffset = $smTogglePosition.offset();
	});

	$(document).on('scroll', render);
}, window.jQuery, window.Zepto));
