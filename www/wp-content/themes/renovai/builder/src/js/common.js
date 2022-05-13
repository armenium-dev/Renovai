(function (factory, jQuery, Zepto) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports === 'object' && typeof Meteor === 'undefined') {
		module.exports = factory(require('jquery'));
	} else {
		factory(jQuery || Zepto);
	}
}(function ($) {
	'use strict';

	$.extend($.expr[':'], {
		inview: function (elem) {
			var t = $(elem);
			var offset = t.offset();
			var win = $(window);
			var winST = win.scrollTop();
			var elHeight = t.outerHeight(true);

			return offset.top > winST - elHeight && offset.top < winST + elHeight + win.height();
		}
	});

	$.fn.exists = function () {
		return this.length !== 0;
	};

	var $animationScene;
	var $carouselNavy;
	var counterSectionRcsarTop;
	var windowHeight;
	var show = true;
	var isTbcfywCarouselSlick = false;
	var isSolutionCarouselSlick = false;

	var startVideo = function() {
		if ($carouselNavy.exists()) {
			var $carouselItem = $carouselNavy.find('.slick-slide.slick-active');
			var $videoCarousel = $carouselItem.find('.video-carousel');
			var $video = $videoCarousel.find('video');

			if ($videoCarousel.hasClass('play') || $('body').hasClass('mobile')) {
				return;
			}

			var videoPromise = $video[0].play();

			$videoCarousel.closest('.video-carousel').addClass('play');

			// console.log($videoCarousel);

			if (videoPromise !== undefined) {
				videoPromise.then( e => {
					console.log(e);
				}).catch( e => {
					console.log(e);
				})
			}

			$video[0].onended = function () {
				$video[0].pause();
				$videoCarousel.removeClass('play');
				$carouselNavy.slick('slickNext');
				startVideo();
			};
		}
	};

	var initSolutionCarousel = function() {
		var $solutionCarousel = $('.solution-carousel');
		if ($solutionCarousel.exists()) {
			if (window.outerWidth <= 425) {
				$solutionCarousel.slick({
					autoplay: true,
					autoplaySpeed: 1000,
					arrows: false
				});
				isSolutionCarouselSlick = true;
			} else if (isSolutionCarouselSlick === true) {
				$solutionCarousel.slick('unslick');
				isSolutionCarouselSlick = false;
			}
		}
	};

	var initTbcfywCarousel = function() {
		var $tbcfywCarousel = $('.tbcfyw-carousel');
		if ($tbcfywCarousel.exists()) {
			if (window.outerWidth <= 425) {
				$tbcfywCarousel.slick({
					autoplay: true,
					autoplaySpeed: 1000,
					arrows: false
				});
				isTbcfywCarouselSlick = true;
			} else if (isTbcfywCarouselSlick === true) {
				$tbcfywCarousel.slick('unslick');
				isTbcfywCarouselSlick = false;
			}
		}
	};

	var intervalGrandmother;

	var initGrandmother = function() {
		var $careersGrandmotherContainer = $('.careers-grandmother-container');
		if (!$careersGrandmotherContainer.exists()) {
			return;
		}
		if (window.outerWidth > 425) {
			clearInterval(intervalGrandmother);
			return;
		}

		if (!intervalGrandmother) {
			intervalGrandmother = setInterval(function () {
				$careersGrandmotherContainer.click();
			}, 1200);
		}

	};

	var initAnimation = function() {
		var $animation = $('.animation-scene.animation');
		if ($animation.exists()) {
			$animation.find('.properties-container').one('animationend', function(){
				initNextAnimation();
			})
		}
	};

	var initNextAnimation = function() {
		var $animationScene = $('.animation-scene.animation');
		var $animationSceneNext = $animationScene.next();
		if (!$animationSceneNext.exists()) {
			$animationSceneNext = $('.animation-scene').first();
		}
		$animationScene.removeClass('animation');
		$animationSceneNext.addClass('animation');
		initAnimation();
	};

	$(function () {
		var $bookADemoCarousel = $('.book-a-demo-carousel');
		var $slickLogos = $('.slick-logos');
		var $carouselReviews = $('#carouselReviews');
		var $counters = $('.counters');
		var $renCarouselSlickFirst = $('.ren-carousel-slick-first');
		var $renCarouselSlickSecond = $('.ren-carousel-slick-second');

		$animationScene = $('.animation-scene');
		$carouselNavy = $renCarouselSlickFirst;

		initGrandmother();
		initTbcfywCarousel();
		initSolutionCarousel();

		initAnimation();

		if ($renCarouselSlickFirst.exists() && $renCarouselSlickSecond.exists()) {
			$renCarouselSlickFirst.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				prevArrow: '<div class="ren-carousel-control-prev d-none d-md-flex"><span class="ren-carousel-control-prev-icon"></span></div>',
				nextArrow: '<div class="ren-carousel-control-next d-none d-md-flex"><span class="ren-carousel-control-next-icon"></span></div>',
				fade: true,
				asNavFor: '.ren-carousel-slick-second'
			});
			$renCarouselSlickSecond.slick({
				asNavFor: '.ren-carousel-slick-first',
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: true,
				appendDots: '.ren-carousel-indicators',
				arrows: false,
				fade: true
			})
		}

		if ($bookADemoCarousel.exists()) {
			$bookADemoCarousel.slick({
				arrows: false,
				slidesToShow: 1,
				autoplay: true,
				autoplaySpeed: 2000
			})
		}

		if ($counters.exists()) {
			setTimeout(function(){
				counterSectionRcsarTop = $counters[0].offsetTop;
				windowHeight = window.innerHeight;
				show = true;
			}, 100);
		}

		if ($carouselReviews.exists()) {
			$carouselReviews.slick({
				fade: true,
				infinite: true,
				cssEase: 'linear',
				speed: 500,
				dots: true
			});
		}

		if ($slickLogos.exists()) {
			$slickLogos.slick({
				cssEase: 'linear',
				arrows: false,
				slidesToShow: 5,
				autoplay: true,
				autoplaySpeed: 0,
				speed: 5000
			});
		}
	});

	$(document).on('animationend', '.animation', function(){
		var $this = $(this);

	});

	$(document).on('change', '.select-careers-tab', function() {
		$('#pillsTab li a').eq($(this).val()).tab('show');
	});

	$(document).on('click', '.careers-grandmother-container', function(){
		if (window.outerWidth > 425) {
			return;
		}
		var $this = $(this);
		var $careersGrandmotherLinkActive = $this.find('.careers-grandmother-link.active');
		var $careersGrandmotherLinkNext = $careersGrandmotherLinkActive.next('.careers-grandmother-link').exists() ? $careersGrandmotherLinkActive.next('.careers-grandmother-link') : $this.find('.careers-grandmother-link').first();
		var $beTextActive = $this.find('.be-text.active');
		var $beTextNext = $beTextActive.next('.be-text').exists() ? $beTextActive.next('.be-text') : $this.find('.be-text').first();
		$careersGrandmotherLinkActive.removeClass('active');
		$beTextActive.removeClass('active');
		$careersGrandmotherLinkNext.addClass('active');
		$beTextNext.addClass('active');
	});

	$(document).on('click', '.video-carousel', function() {
		var $this = $(this);
		var $video = $this.find('video');
		if (!$video.exists() || $this.hasClass('play')) {
			return;
		}
		$this.addClass('play');
		$video[0].play();
	});

	$(document).on('mouseover', '.careers-grandmother-link', function(){
		$(this).closest('.careers-grandmother-container').addClass('hover');
	});

	$(document).on('mouseout', '.careers-grandmother-link', function(){
		$(this).closest('.careers-grandmother-container').removeClass('hover');
	});

	$(window).on('scroll', function () {
		if ($carouselNavy.exists() && $carouselNavy.is(':inview')) {
			setTimeout(function () {
				startVideo();
			}, 3000);
		}
		if (show && (counterSectionRcsarTop < $(window).scrollTop() + windowHeight)) {
			var $dataCounter = $('[data-counter]');
			if ($dataCounter.exists()) {
				$dataCounter.each(function () {
					var $this = $(this);
					var dataPrefix = $this.attr('data-prefix');
					var dataSuffix = $this.attr('data-suffix');
					$this.prop('counter', 0).animate({
						counter: $this.attr('data-counter')
					}, {
						duration: 1000,
						easing: 'swing',
						step: function (now) {
							$this.text(dataSuffix + this.counter.toFixed(0) + dataPrefix)
						}
					})
				});
			}
			show = false;
		}
	});

	$(window).on('resize', function() {
		initGrandmother();
		initTbcfywCarousel();
		initSolutionCarousel();
	});

}, window.jQuery, window.Zepto));
