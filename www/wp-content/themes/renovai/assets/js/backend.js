(function($){
	"use strict";

	var JPA = {
		options: {},
		vars: {},
		els: {
			js_ajax_message: null,
			export_list_form: null,
			webinar_suctomers_search_form: null,
			last_download_link: null,
		},
		Init: function(){
			this.els.js_ajax_message = $('#js_ajax_message');
			this.els.export_list_form = $('#export_list_form');
			this.els.webinar_suctomers_search_form = $('#webinar_suctomers_search_form');
			this.els.last_download_link = $('#last_download_link');

			this.initEvents();
			this.initJobDescriptionTemplateShortcode();
			this.widgetSocialIcons.sortServices();
			this.closeHiddenSections();
			this.disableACFields();
		},
		initEvents: function(){
			$(document)
				.on('change', 'select[name="limit"]', JPA.submitSearchForm)
				.on('click', '.btn-close', JPA.actionCloseMessage)
				.on('click', '#export_all', JPA.actionExportAll)
				.on('submit', '#export_list_form', JPA.submitExportForm)
				.on('widget-updated', JPA.widgetSocialIcons.sortServices)
				.on('widget-added', JPA.widgetSocialIcons.sortServices)
				.on('click', '.siw-form .siw-add', JPA.widgetSocialIcons.addService)
				.on('click', '.siw-form .siw-remove', JPA.widgetSocialIcons.removeService);
		},
		submitSearchForm: function(e){
			JPA.els.webinar_suctomers_search_form.submit();
		},
		submitExportForm: function(e){
			e.preventDefault();

			var data = [];

			JPA.els.export_list_form.find('input:checked').each(function(){
				var id = $(this).val();
				if(id){
					data.push(id);
				}
			});

			JPA.processExport(data);

			return false;
		},
		actionExportAll: function(e){
			e.preventDefault();

			var data = [];

			data.push('all');

			JPA.processExport(data);
		},
		processExport: function(ids){
			JPA.actionDisplayMessage('Sending request...');

			$.ajax({
				type: "POST",
				url: globals.ajax_url,
				data: {'action': globals.export_webinar_cutomers_action, 'nonce': globals.nonce, 'ids': ids},
				dataType: "json"
			}).done(function(responce){
				if(responce.error == 0){
					JPA.els.export_list_form.find("input:checked").prop("checked", false);
					JPA.els.last_download_link.find('span').html(responce.result);
					responce.message += '<br>' + responce.result;
				}
				JPA.actionDisplayMessage(responce.message);
			}).fail(function(){
				JPA.actionDisplayMessage("SYSTEM TECHNICAL ERROR");
			});
		},
		actionCloseMessage: function(e){
			e.preventDefault();
			JPA.els.js_ajax_message.removeClass('show');
		},
		actionDisplayMessage: function(message){
			JPA.els.js_ajax_message.find('.info').html(message).end().addClass('show');
		},
		widgetSocialIcons: {
			sortServices: function(){
				$('#widgets-right .siw-form .siw-sortable, .customize-control .siw-form .siw-sortable').each(function(){
					var id = $(this).attr('id'),
						$el = $('#' + id);

					$el.sortable({
						cursor: 'move',
						placeholder: '.siw-placeholder',
						opacity: 0.6,
						update: function(event, ui){
							if(wp.customize !== undefined){
								$el.find('input.ui-sortable-handle').trigger('change');
							}else{
								$el.find('input[type="text"]').trigger('change');
							}
						}
					});
				});
			},
			addService: function(event){
				event.preventDefault();

				var widgetForm = $(this).closest('.siw-form'),
					cloneEl = widgetForm.find('.siw-clone');

				widgetForm.find('.siw-sortable').append('<li>' + cloneEl.html() + '</li>');
			},
			removeService: function(event){
				event.preventDefault();
				if(confirm(globals.lang.confirm)){
					$(this).closest('li').remove();
				}
			},
		},
		initJobDescriptionTemplateShortcode: function(){
			if($('[data-name="template_shortcode"]').length){
				var $field = $('[data-name="template_shortcode"]').find('input[type="text"]'),
					post_id = $('input[name="post_ID"]').val();

				$field.val('[job_description_template post_id="'+post_id+'"]').attr('readonly', true);
			}
		},
		closeHiddenSections: function(){
			var $normal_sortables = $('.post-type-page').find('#normal-sortables');
			if($normal_sortables.length){
				$normal_sortables.find('.postbox').each(function(){
					if($(this).find('[data-name="display_this_section"]').length){
						var is_display = $(this).find('[data-name="display_this_section"]').find('input[type="checkbox"]').is(':checked');
						//console.log(is_display);
						if(!is_display){
							$(this).addClass('closed');
						}else{
							//$(this).removeClass('closed');
						}
					}
				});
			}
		},
		disableACFields: function(){
			$('td.disabled').each(function(i, el){
				var $input = $(el).find('input');
				if($input.length){
					if($input.val() != ''){
						$input.prop('readonly', true);
					}else{
						$input.prop('readonly', false);
					}
				}
			});
		},
	};

	JPA.Init();

})(jQuery);
