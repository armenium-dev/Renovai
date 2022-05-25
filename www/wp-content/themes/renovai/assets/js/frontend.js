(function ($) {
	'use strict';

	jQuery(document).ready(function($){

		var FJS = {
			options: {},
			vars: {
				ww: 0,
				wh: 0,
				scrollTop: 0,
				scrollTopPrev: 0,
				scroll_dir: 'bottom',
				book_a_demo_storage_key: 'book_a_demo_params',
			},
			labels: {},
			messages: {
				ajax_error: 'SYSTEM TECHNICAL ERROR'
			},
			routes: {
				load_countries_list: 'load_countries_list',
				load_more_news: 'load_more_news',
				load_more_posts: 'load_more_posts',
			},
			els: {
				body: $("body"),
				header: $("#site_header"),
				js_loader: $(".js_data_loader"),
				cf7_form: $('.wpcf7-form'),
				book_a_demo_section: $('#book-a-demo-section'),
			},
			Init: function(){
				//this.Common.initScrollToLinks();
				this.CF7.init();
				this.ROI.init();
				this.Reviews.init();
				this.initEvents();
				this.eventResizeWindow();
			},
			initEvents: function(){
				$(window)
					.on('scroll', FJS.eventScrollWindow)
					.on('resize orientationchange deviceorientation', FJS.eventResizeWindow);

				$(document)
					.on('blur', '[data-trigger="js_action_blur"]', FJS.doAction)
					.on('change', '[data-trigger="js_action_change"]', FJS.doAction)
					.on('click', '[data-trigger="js_action_click"]', FJS.doAction)
					.on('submit', '[data-trigger="js_action_submit"]', FJS.doAction)
					.on('click', '[data-trigger="ga"]', FJS.GA.parseAndSend)
					.on('wpcf7submit', FJS.CF7.submit)
					.on('wpcf7beforesubmit', FJS.CF7.beforesubmit)
					.on('wpcf7invalid', FJS.CF7.invalid)
					.on('wpcf7mailfailed', FJS.CF7.mailfailed)
					.on('wpcf7spam', FJS.CF7.spam)
					.on('wpcf7mailsent', FJS.CF7.mailsent);
			},
			eventResizeWindow: function(){
				FJS.vars.ww = $(window).width();
				FJS.vars.wh = $(window).height();
			},
			eventScrollWindow: function(){
				FJS.vars.scrollTop = $(window).scrollTop();
				if(FJS.vars.scrollTopPrev > 0){
					if(FJS.vars.scrollTop > FJS.vars.scrollTopPrev){
						FJS.vars.scroll_dir = 'bottom';
					}else{
						FJS.vars.scroll_dir = 'top';
					}
				}
				FJS.vars.scrollTopPrev = FJS.vars.scrollTop;
			},
			doAction: function(e){
				var $this = $(this),
					action = $(this).data('action');

				switch(action){
					case "download_file_with_modal":
						FJS.News.openModal($this);
						break;
					case "open_video_modal":
						FJS.Reviews.openModal($this);
						break;
					case "open_case_modal":
						FJS.CaseStudies.openModal($this);
						break;
					case "set_phone_code":
						FJS.CF7.setPhoneCode($this);
						break;
					case "load_more_news":
						FJS.News.loadMore($this);
						break;
					case "load_more_posts":
						FJS.Blog.loadMore($this);
						break;
					case "scroll_to_el":
						FJS.Common.scrollTo($this);
						break;
					case "toggle_mobile_nav":
						FJS.Common.toggleMobileNav($this);
						break;
					case "toggle_submenu":
						FJS.Common.toggleMobileSubmenu($this);
						break;
					case "social_shraing_service":
						FJS.Blog.OpenSocialShare($this);
						break;
					case "social_shraing_copy_link":
						FJS.Blog.CopyPostLink($this);
						break;
					case "save_to_storage":
						FJS.Common.saveToStorage($this);
						break;
					case "roi_calc_result":
						FJS.ROI.calc($this);
						break;
					default:
						break;
				}

				e.preventDefault();
			},
			Loader: {
				start: function(){
					if(FJS.els.js_loader.exists()){
						FJS.els.cf7_form.addClass('half-trans');
						FJS.els.js_loader.addClass('show');
					}
				},
				stop: function(){
					if(FJS.els.js_loader.exists()){
						FJS.els.cf7_form.removeClass('half-trans');
						FJS.els.js_loader.removeClass('show');
					}
				},
			},
			Common: {
				getSessionStorage: function(key){
					return sessionStorage.getItem(key);
				},
				setSessionStorage: function(key, value){
					sessionStorage.setItem(key, value);
				},
				initScrollToLinks: function(){
					var $links = $('a[href^="#"]');

					if($links.length){
						$links.each(function(i, el){
							var target = $(this).attr('href');

							if($(target).length){
								console.log(i, target, $(target).length);
								$(el)
									.attr('data-trigger', 'js_action_click')
									.attr('data-action', 'scroll_to_el')
									.attr('data-target', target);
							}
						});
					}
				},
				scrollTo: function($obj){
					var $target = $($obj.data('target')),
						offset = FJS.els.header.height(),
						speed = 800,
						top = 0;

					if(offset >= 0){
						top = $target.offset().top - offset;
					}else{
						top = $target.offset().top + (offset);
					}

					$('html, body').stop().animate({'scrollTop': top}, speed);
				},
				toggleMobileNav: function($obj){
					var target = $obj.data('target'),
						nav_target = $obj.data('nav-target');

					if($('nav' + target).hasClass('show')){
						$(target).removeClass('collapse show');
						$(nav_target).removeClass('show');
						$('body').removeClass('nav-mob-opened');
						$obj.addClass('collapsed').attr('aria-expanded', false);
						$('#site_header').removeClass('nav-show');
						setTimeout(function(){
						}, 300);
					}else{
						$(target).addClass('collapse show');
						$(nav_target).addClass('show');
						$('body').addClass('nav-mob-opened');
						$obj.removeClass('collapsed').attr('aria-expanded', true);
						$('#site_header').addClass('nav-show');
					}
				},
				toggleMobileSubmenu: function($obj){
					if(FJS.vars.ww < 768){
						var $target = $($obj.data('target'));

						if($target.hasClass('show')){
							$target.removeClass('show');
						}else{
							$target.addClass('show');
						}
					}else{
						/*var href = $obj.attr('href');
						if(href.indexOf('#') == -1){
							window.location.href = href;
						}*/
					}
				},
				setCookies: function(cname, cvalue, exdays){
					var d = new Date();
					d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);

					var options = {
						expires: d.toUTCString(),
						path: "/",
						domain: globals.domain,
						//secure: globals.secure,
						//httponly: false,
						//samesite: "Lax",
					};

					var updatedCookie = encodeURIComponent(cname) + "=" + encodeURIComponent(cvalue);

					for(var optionKey in options){
						updatedCookie += "; " + optionKey + "=" + options[optionKey];
					}
					//console.log(updatedCookie);

					document.cookie = updatedCookie;
				},
				getCookie: function(cname){
					var name = cname + "=";
					var ca = document.cookie.split(';');
					for(var i = 0; i < ca.length; i++){
						var c = ca[i];
						while(c.charAt(0) == ' '){
							c = c.substring(1);
						}
						if(c.indexOf(name) == 0){
							return c.substring(name.length, c.length);
						}
					}
					return "";
				},
				downloadURI: function(uri, name){
					var link = document.createElement("a");
					link.setAttribute('download', name);
					link.href = uri;
					document.body.appendChild(link);
					link.click();
					link.remove();
				},
				basename: function(path){
					var parts = path.split('/');
					return parts[parts.length - 1];
				},
				saveToStorage: function($btn){
					var referer = $btn.data('referer'),
						url = $btn.attr('href'),
						title = 'Site header',
						$parent_section = $btn.parents('section'),
						data = {};

					if($parent_section.length){
						if($parent_section.find('h1').length){
							title = $parent_section.find('h1').html();
						}else if($parent_section.find('h2').length){
							title = $parent_section.find('h2').html();
						}else if($parent_section.find('p').length){
							title = $parent_section.find('p:first').html();
						}
					}


					data['referer'] = referer;
					data['title'] = title;
					var json_text = JSON.stringify(data, null, 2);
					//console.log(json_text);

					this.setSessionStorage(FJS.vars.book_a_demo_storage_key, json_text);

					window.location.href = url;

					return true;
				},
			},
			CaseStudies: {
				openModal: function($obj){
					var $target = $($obj.data('target')),
						$source = $obj.parents('.media-body'),
						case_title = $source.data('case'),
						download_link = $obj.data('download');

					var title = $source.find('[data-src="title"]').html();
					var img = '<img class="mr-2 case-studies-modal-title-logo" src="' + $source.find('[data-src="logo"]').attr('src') + '" alt="' + title + '" title="' + title + '">';
					title = img + title;

					$target
						.find('[name="case"]').val(case_title)
						.end()
						.find('[data-dst="title"]').html(title)
						.end()
						.find('[data-dst="content"]').html($source.find('[data-src="content"]').html())
						.end()
						.find('[name="download_file"]').val(download_link)
						.end()
						.modal('show');
				},
			},
			Blog: {
				loadMore: function($obj){
					var $target = $($obj.data('target')),
						parent_post_id = $target.data('parent_post_id'),
						total = $target.data('total'),
						offset = $target.data('offset');

					$obj.attr('disabled', true);

					$.ajax({
						type: "POST",
						url: globals.ajax_url,
						data: {
							'action': FJS.routes.load_more_posts,
							'nonce': globals.nonce,
							'offset': offset,
							'parent_post_id': parent_post_id
						},
						dataType: "json"
					}).done(function(responce){
						if(responce.error == 0){
							$target.data('offset', responce.offset).append(responce.result);
							if(responce.offset >= total){
								$obj.addClass('d-none');
							}
						}
						$obj.attr('disabled', false);
					}).fail(function(){
						console.log("SYSTEM TECHNICAL ERROR");
						$obj.attr('disabled', false);
					});

				},
				OpenSocialShare: function($this){
					var url = $this.data('url'),
						service = $this.data('service');

					window.open(url, service + "Window", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");

					return false;
				},
				CopyPostLink: function($this){
					var url = $this.data("url");

					if(navigator.clipboard){
						navigator.clipboard.writeText(url).then(function(){
							$(".custom-toast").slideDown(250).delay(2500).slideUp(250)
							console.log('Async: Copying to clipboard was successful!');
						}, function(err){
							console.error('Async: Could not copy text: ', err);
						});
					}else{
						var $temp = $("<input>");
						$("body").append($temp);
						$temp.val(url).select();
						document.execCommand("copy");
						$temp.remove();
						$(".custom-toast").slideDown(250).delay(2500).slideUp(250)
					}
				},
			},
			News: {
				loadMore: function($obj){
					var $target = $($obj.data('target')),
						parent_post_id = $target.data('parent_post_id'),
						total = $target.data('total'),
						offset = $target.data('offset');

					$obj.attr('disabled', true);

					$.ajax({
						type: "POST",
						url: globals.ajax_url,
						data: {
							'action': FJS.routes.load_more_news,
							'nonce': globals.nonce,
							'offset': offset,
							'parent_post_id': parent_post_id
						},
						dataType: "json"
					}).done(function(responce){
						if(responce.error == 0){
							$target.data('offset', responce.offset).append(responce.result);
							if(responce.offset >= total){
								$obj.addClass('d-none');
							}
						}
						$obj.attr('disabled', false);
					}).fail(function(){
						console.log("SYSTEM TECHNICAL ERROR");
						$obj.attr('disabled', false);
					});

				},
				openModal: function($obj){
					//console.log($obj.data());

					var $modal_1 = $($obj.data('modal_1')),
						$modal_2 = $($obj.data('modal_2')),
						download_file = $obj.attr('href'),
						download_file_name = $obj.attr('download');

					$modal_1.modal('show');
					setTimeout(function(){
						$modal_2.modal('show');
						$modal_1.modal('hide');
					}, 5000);

					FJS.Common.downloadURI(download_file, download_file_name);

					return false;
				},
			},
			CF7: {
				vars: {
					form_is_present: false,
					all_is_valid: true,
				},
				init: function(){
					if(FJS.els.cf7_form.length && FJS.els.cf7_form.hasClass('init')){
						//FJS.els.cf7_form.addClass('');
						FJS.els.cf7_form.find('.wpcf7-response-output').addClass('d-none');
						FJS.CF7.vars.form_is_present = true;
						FJS.CF7.initEvents();
						FJS.CF7.loadCountriesOptionsList();
						FJS.CF7.validateFields();
						FJS.CF7.fillStorageData();
						//$('#jobApplicationModal').modal('show'); // test
					}
				},
				initEvents: function(){
					$(document)
						.on('change blur keyup', 'input, textarea', FJS.CF7.validateFields)
						.on('change', 'input[type="file"]', FJS.CF7.displaySelectedFile);
				},
				submit: function(event){
					//console.log(FJS.CF7.vars.all_is_valid);
					if(!FJS.CF7.vars.all_is_valid){
						return;
					}

					var post_id = ~~event.detail.containerPostId,
						status = event.detail.status,
						after_send_action = "",
						redirect_url = "",
						display_modal = "",
						scheduler_modal = "",
						download_file = "",
						hide_modal = "";

					$.each(event.detail.inputs, function(i, el){
						if(el.name == 'after_send_action')
							after_send_action = el.value;
						if(el.name == 'redirect_url')
							redirect_url = el.value;
						if(el.name == 'display_modal')
							display_modal = el.value;
						if(el.name == 'scheduler_modal')
							scheduler_modal = el.value;
						if(el.name == 'hide_modal')
							hide_modal = el.value;
						if(el.name == 'download_file')
							download_file = el.value;
					});

					console.log(after_send_action);
					//console.log(hide_modal);
					//console.log('wpcf7submit', post_id, status, redirect_url);

					switch(status){
						case "aborted":
							break;
						case "mail_sent":
							if(after_send_action != ""){
								switch(after_send_action){
									case "run_roi_calc":
										FJS.ROI.calc(null);
										break;
								}
							}
							if(redirect_url != ""){
								window.location.href = redirect_url;
							}
							if(hide_modal != ""){
								$(hide_modal).modal('hide');
							}
							if(display_modal != ""){
								if($(display_modal).length){
									$(display_modal).modal('show');
								}
							}
							if(download_file != ""){
								FJS.Common.downloadURI(download_file, FJS.Common.basename(download_file));
								/*$.fileDownload(download_file)
									.done(function(){
										alert('File download a success!');
										FJS.Common.setCookies('fileDownload', true);
									})
									.fail(function(){
										alert('File download failed!');
									});*/
							}
							if(scheduler_modal != ""){
								if($(scheduler_modal).length){
									setTimeout(function(){
										$(scheduler_modal).modal('show');
										if(display_modal != ""){
											if($(display_modal).length){
												$(display_modal).modal('hide');
											}
										}
									}, 5000);
								}
							}
							if(FJS.els.cf7_form.find('.js_custom_response').length){
								FJS.els.cf7_form.find('.js_custom_response').fadeIn(400).delay(4000).fadeOut(400);
							}
							break;
						case "mail_failed":
							break;
						case "validation_failed":
							break;
					}
				},
				mailsent: function(event){
					FJS.GA.send();
					FJS.Loader.stop();
					FJS.Common.setSessionStorage(FJS.vars.book_a_demo_storage_key, null);
					console.log('wpcf7mailsent', event.detail.status);
				},
				invalid: function(event){
					var post_id = ~~event.detail.containerPostId,
						form_id = ~~event.detail.contactFormId,
						invalid_fields = event.detail.apiResponse.invalid_fields;

					FJS.Loader.stop();

					console.log('wpcf7invalid', invalid_fields);
					$.each(invalid_fields, function(i, v){
						$('#' + v.idref).addClass('is-invalid');
					});
				},
				mailfailed: function(event){
					FJS.Loader.stop();
					console.log('wpcf7mailfailed', event.detail.contactFormId);
				},
				beforesubmit: function(event){
					FJS.Loader.start();
					console.log('wpcf7beforesubmit', event.detail.contactFormId, event.detail.status);
				},
				spam: function(event){
					console.log('wpcf7spam', event.detail.contactFormId);
				},
				validateFields: function(){
					if(FJS.CF7.vars.form_is_present){
						FJS.CF7.vars.all_is_valid = true;

						FJS.els.cf7_form.find('.wpcf7-validates-as-required').each(function(i, el){
							var el_val = $(el).val();
							//console.log('CF7 > validateFields', el_val);

							if($(el).inputmask("hasMaskedValue")){
								if($(el).inputmask("isComplete")){
									$(el).addClass('is-valid').removeClass('is-invalid');
								}else{
									$(el).removeClass('is-valid');
									FJS.CF7.vars.all_is_valid = false;
								}
							}else{
								if(el_val == ''){
									$(el).removeClass('is-valid');
									FJS.CF7.vars.all_is_valid = false;
								}else{
									$(el).addClass('is-valid').removeClass('is-invalid');
								}
							}
							if($(el).attr('type') == 'email' && $(el).hasClass('ignore-free-mail')){
								var $p = $(el).parent('.wpcf7-form-control-wrap');
								var $e = $p.find('.error');
								var index_at = el_val.indexOf('@');

								if(index_at > -1){
									var freeRegex = /^[\w-\.]+@([hotmail+\.]|[yahoo+\.]|[gmail+\.])+[\w-]{2,4}$/;
									if(el_val.match(freeRegex)){
										$(el).removeClass('is-valid');
										FJS.CF7.vars.all_is_valid = false;
										//var a = el_val.split('@');
										//var domain = a[1];
										var text = 'Please enter your business email address';
										//console.log(text);
										if(!$e.length){
											$p.append('<div class="error wpcf7-not-valid-tip red">' + text + '</div>');
										}else{
											$e.text(text);
										}
									}else{
										if($e.length){
											$e.text('');
										}
									}
								}
							}
						});

						FJS.els.cf7_form.find('[type="submit"]').prop('disabled', !FJS.CF7.vars.all_is_valid);
					}
				},
				displaySelectedFile: function(e){
					var fileName = e.target.files[0].name;
					//console.log($(this).parents('form').length);
					//var file = $(this)[0].files[0];
					$(e.target).parents('.custom-file').find('.file-placeholder').text(fileName);
				},
				loadCountriesOptionsList: function(){
					var $country_field = FJS.els.cf7_form.find('#country');

					if($country_field.length){

						$.ajax({
							type: "POST",
							url: globals.ajax_url,
							data: {'action': FJS.routes.load_countries_list, 'nonce': globals.nonce},
							dataType: "json"
						}).done(function(responce){
							if(responce.error == 0){
								$country_field
									.html(responce.result)
									.find('option[value="972"]')
									.prop('selected', true)
									.end()
									.trigger('change');
							}
						}).fail(function(){
							console.log("SYSTEM TECHNICAL ERROR");
						});

					}
				},
				setPhoneCode: function($obj){
					var $target = $($obj.data('target')),
						phonecode = $obj.val(),
						length = phonecode.length;

					$target.val('+' + phonecode).inputmask({"mask": "+*{1," + length + "} (999) 999-9999"});
				},
				fillStorageData: function(){
					if(FJS.els.book_a_demo_section.length){
						var storage_data = FJS.Common.getSessionStorage(FJS.vars.book_a_demo_storage_key);

						if(storage_data != null){
							storage_data = JSON.parse(storage_data);
							//console.log(storage_data);

							FJS.GA._setParams({
								hintType: 'event',
								eventCategory: 'Book-a-Demo',
								eventAction: 'submit',
								eventLabel: storage_data.title,
								//eventValue: storage_data.referer,
							});

							if(FJS.els.cf7_form.find('input[name="referer"]').length){
								FJS.els.cf7_form.find('input[name="referer"]').val(storage_data.referer);
							}
							if(FJS.els.cf7_form.find('input[name="section"]').length){
								FJS.els.cf7_form.find('input[name="section"]').val(storage_data.title);
							}

							//console.log(FJS.els.cf7_form.find('input[name="referer"]').val());
							//console.log(FJS.els.cf7_form.find('input[name="section"]').val());
						}
					}
				},
			},
			GA: {
				params: {
					hintType: '',
					eventCategory: '',
					eventAction: '',
					eventLabel: '',
					eventValue: '',
				},
				_setParam: function(key, value){
					FJS.GA.params[key] = value;
				},
				_setParams: function(params){
					$.each(params, function(key, value){
						FJS.GA._setParam(key, value);
					});
				},
				parseAndSend: function(){
					var $this = $(this);

					FJS.GA.params = {
						hintType: 'event',
						eventCategory: 'Blog Post View',
						eventAction: 'click',
						eventLabel: $this.attr('title'),
						//eventValue: $this.attr('href'),
					};

					FJS.GA.send();
				},
				send: function(){
					ga(function(tracker){
						console.log(tracker.get('trackingId'), FJS.GA.params);
					});
					ga('send', FJS.GA.params);

				},
			},
			ROI: {
				vars: {
					currentSessionsValue: 5000,
					currentSKUValue: 500,
					currentAverageOrderValue: 70,
					sessionsMarks: [],
					stepForSessionMarks: 1000,
					maxValueForSessionMarks: 25000000,
					minValueForSessionMarks: 5000,
					fromValueForSessionsMarks: 0,

					SKUMarks: [],
					stepForSKUMarks: 100,
					maxValueForSKUMarks: 300000,
					minValueForSKUMarks: 200,
					fromValueForSKUMarks: 0,

					averageOrderMarks: [],
					stepAverageOrderMarks: 10,
					maxValueAverageOrderMarks: 500,
					minValueAverageOrderMarks: 50,
					fromValueForAverageOrderMarks: 0,
				},
				els: {
					sessionValue: $('#roi-calc-session-value'),
					roi_calculator_form__range__sessions: $('.roi-calculator-form__range--sessions'),
					SKUValue: $('#roi-calc-SKU-value'),
					roi_calculator_form__range__SKU: $('.roi-calculator-form__range--SKU'),
					averageOrderValue: $('#average-order-value'),
					roi_calculator_form__range__average_order: $('.roi-calculator-form__range--average-order'),

					// Calculating Result
					resultSection: $(".roi-calculator-result"),
					loader: $("#calc-loader"),

					// Boxes for result values
					aovResultBox: $("#AOV-result"),
					cvrResultBox: $("#CVR-result"),
					arpuResultBox: $("#ARPU-result"),
					totalUpliftBox: $("#total-uplift"),
				},
				init: function(){
					for(let i = FJS.ROI.vars.minValueForSessionMarks; i <= FJS.ROI.vars.maxValueForSessionMarks; i += FJS.ROI.vars.stepForSessionMarks){
						FJS.ROI.vars.sessionsMarks.push(i);
					}

					for(let i = FJS.ROI.vars.minValueForSKUMarks; i <= FJS.ROI.vars.maxValueForSKUMarks; i += FJS.ROI.vars.stepForSKUMarks){
						FJS.ROI.vars.SKUMarks.push(i);
					}

					for(let i = FJS.ROI.vars.minValueAverageOrderMarks; i <= FJS.ROI.vars.maxValueAverageOrderMarks; i += FJS.ROI.vars.stepAverageOrderMarks){
						FJS.ROI.vars.averageOrderMarks.push(i);
					}

					FJS.ROI.initRangeSliders();
				},
				initRangeSliders: function(){
					if(FJS.ROI.els.roi_calculator_form__range__sessions.length){
						FJS.ROI.els.roi_calculator_form__range__sessions.ionRangeSlider({
							skin: "round",
							values: FJS.ROI.vars.sessionsMarks,
							grid: false,
							from: FJS.ROI.vars.fromValueForSessionsMarks,
							hide_min_max: true,
							onChange: (e) => {
								FJS.ROI.vars.currentSessionsValue = e.from_value;
								FJS.ROI.els.sessionValue.text(FJS.ROI.addThousandsSeparator(e.from_value));
							}
						});
					}

					if(FJS.ROI.els.roi_calculator_form__range__SKU.length){
						FJS.ROI.els.roi_calculator_form__range__SKU.ionRangeSlider({
							skin: "round",
							values: FJS.ROI.vars.SKUMarks,
							grid: false,
							from: FJS.ROI.vars.fromValueForSKUMarks,
							hide_min_max: true,
							prettify_separator: ',',
							onChange: (e) => {
								FJS.ROI.vars.currentSKUValue = e.from_value;
								FJS.ROI.els.SKUValue.text(FJS.ROI.addThousandsSeparator(e.from_value));
							}
						});
					}

					if(FJS.ROI.els.roi_calculator_form__range__average_order.length){
						FJS.ROI.els.roi_calculator_form__range__average_order.ionRangeSlider({
							skin: "round",
							values: FJS.ROI.vars.averageOrderMarks,
							grid: false,
							from: FJS.ROI.vars.fromValueForAverageOrderMarks,
							hide_min_max: true,
							prefix: "$",
							onChange: (e) => {
								FJS.ROI.vars.currentAverageOrderValue = e.from_value;
								FJS.ROI.els.averageOrderValue.text("$" + e.from_value);
							}
						});
					}
				},
				addThousandsSeparator: function(number){
					const separator = ',';
					return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator);
				},
				calc: function($btn){
					FJS.ROI.els.resultSection.removeClass("roi-calculator-result--active");
					FJS.ROI.els.loader.addClass("roi-calculator-result__loader--active");

					// Timeout for loader
					setTimeout(() => {
						FJS.ROI.els.loader.removeClass("roi-calculator-result__loader--active");
						FJS.ROI.els.resultSection.addClass("roi-calculator-result--active");
					}, 1500);

					// someСalculations -- какой-то общий коефициент или что-то вроде этого (спросить)
					let someСalculations = 1 + (0.003 * (FJS.ROI.vars.currentSKUValue - 200) / 3000);
					FJS.ROI.els.aovResultBox.text(Math.round((0.2 * 0.7 * someСalculations) * 100) + "%");
					FJS.ROI.els.cvrResultBox.text(Math.round((0.2 * 0.3 * someСalculations) * 100) + "%");
					FJS.ROI.els.arpuResultBox.text(Math.round((0.2 * someСalculations) * 100) + "%");
					FJS.ROI.els.totalUpliftBox.text("$" + FJS.ROI.addThousandsSeparator(Math.round(FJS.ROI.vars.currentSessionsValue * 0.025 * FJS.ROI.vars.currentAverageOrderValue * 0.2 * someСalculations)));

					// different styles/classes, for different result lengths
					if(FJS.ROI.els.totalUpliftBox.text().length > 7){
						FJS.ROI.els.totalUpliftBox.addClass("roi-calculator-result__total-uplift--large-value");
					}else if(FJS.ROI.els.totalUpliftBox.text().length <= 7){
						FJS.ROI.els.totalUpliftBox.removeClass("roi-calculator-result__total-uplift--large-value");
					}
				},
			},
			Reviews: {
				options: {
					type: "loop",
					focus: "center",
					lazyLoad: "nearby",
					//drag: "free",
					perPage: 3,
					perMove: 1,
					padding: 0,
					speed: 500,
					cover: false,
					//snap: true,
					//wheel: true,
					arrows: false,
					pagination: false,
					breakpoints: {
						767: {perPage: 1, arrows: true,}
					}
				},
				els: {
					sliders: []
				},
				init: function(){
					this.initSliders();
				},
				initSliders: function(){
					var $splide = $('.splide');
					if($splide.length){
						$.each($splide, function(i, el){
							FJS.Reviews.els.sliders[i] = new Splide(el, FJS.Reviews.options);
							FJS.Reviews.els.sliders[i].mount();
						});
					}
				},
				openModal: function($obj){
					var $target = $($obj.data('target')),
						video_src = $obj.data('video'),
						$video = $target.find('video');

					$video.attr('src', video_src);
					$target.modal('show').on('hidden.bs.modal', function(event){
						$video.trigger('pause');
					});
					$video.trigger('play');
				},
			},
		};

		FJS.Init();
	});

})(jQuery);
