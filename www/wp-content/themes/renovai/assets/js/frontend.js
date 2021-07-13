//var jQuery = jquery35109025915789412941;
if(typeof jQuery === "undefined"){
	throw new Error("Frontend requires jQuery");
}

jQuery(function($){
	"use strict";

	var FJS = {
		options: {},
		vars: {
			ww: 0,
			wh: 0,
			scrollTop: 0,
			scrollTopPrev: 0,
			scroll_dir: 'bottom',
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
		},
		Init: function(){
			//this.Common.initScrollToLinks();
			this.CF7.init();
			this.initEvents();
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
				default:
					break;
			}

			e.preventDefault();
		},
		Loader: {
			start: function(){
				FJS.els.cf7_form.addClass('half-trans');
				FJS.els.js_loader.addClass('show');
			},
			stop: function(){
				FJS.els.cf7_form.removeClass('half-trans');
				FJS.els.js_loader.removeClass('show');
			},
		},
		Common: {
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

				if($('nav'+target).hasClass('show')){
					$(target).removeClass('collapse show');
					$(nav_target).removeClass('show');
					$obj.addClass('collapsed').attr('aria-expanded', false);
					setTimeout(function(){
						$('#site_header').removeClass('nav-show');
					}, 300);
				}else{
					$('#site_header').addClass('nav-show');
					$(target).addClass('collapse show');
					$(nav_target).addClass('show');
					$obj.removeClass('collapsed').attr('aria-expanded', true);
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
				for(var i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') {
						c = c.substring(1);
					}
					if (c.indexOf(name) == 0) {
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
				return parts[parts.length-1];
			},
		},
		CaseStudies: {
			openModal: function($obj){
				var $target = $($obj.data('target')),
					$source = $obj.parents('.media-body'),
					case_title = $source.data('case'),
					download_link = $obj.data('download');

				var title = $source.find('[data-src="title"]').html();
				var img = '<img class="mr-2 case-studies-modal-title-logo" src="'+$source.find('[data-src="logo"]').attr('src')+'" alt="'+title+'" title="'+title+'">';
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
					//$('#jobApplicationModal').modal('show'); // test
				}
			},
			initEvents: function(){
				$(document)
					.on('change blur keyup', 'input, textarea', FJS.CF7.validateFields)
					.on('change', 'input[type="file"]', FJS.CF7.displaySelectedFile);
			},
			submit: function(event){
				var post_id = ~~event.detail.containerPostId,
					status = event.detail.status,
					redirect_url = "",
					display_modal = "",
					scheduler_modal = "",
					download_file = "",
					hide_modal = "";

				$.each(event.detail.inputs, function(i, el){
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

				//console.log(download_file);
				//console.log(hide_modal);
				//console.log('wpcf7submit', post_id, status, redirect_url);

				switch(status){
					case "aborted":
						break;
					case "mail_sent":
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
						break;
					case "mail_failed":
						break;
					case "validation_failed":
						break;
				}
			},
			mailsent: function(event){
				FJS.Loader.stop();
				console.log('wpcf7mailsent', event.detail.status);
			},
			invalid: function(event){
				var post_id = ~~event.detail.containerPostId,
					form_id = ~~event.detail.contactFormId,
					invalid_fields = event.detail.apiResponse.invalid_fields;

				FJS.Loader.stop();

				console.log('wpcf7invalid', invalid_fields);
				$.each(invalid_fields, function(i, v){
					$('#'+v.idref).addClass('is-invalid');
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

									if(!$e.length){
										$p.append('<div class="error wpcf7-not-valid-tip red">'+text+'</div>');
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

				$target.val('+' + phonecode).inputmask({"mask": "+*{1,"+length+"} (999) 999-9999"});
			},
		},
	};

	FJS.Init();
});
