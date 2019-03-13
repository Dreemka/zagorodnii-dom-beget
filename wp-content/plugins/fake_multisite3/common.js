;(function($){
	function fm_send_req(id,field,value){
		//alert(id+' : '+field+' : '+value);
		var data = {
			action: 'fm_edit_field',
			id: id,
			field: field,
			value: value
		};
		$this = $('.fm_button_edit[data-id="'+id+'"][data-field="'+field+'"]');
		console.log($this);
		$.post( ajaxurl, data, function(response) {
			if(response=='1'){
				$this.parents('.fm_wrap_column').find('.fm_input_text').hide();
				$this.parents('.fm_wrap_column').find('.fm_value').text(value);
			} else {
				alert('При отправке запроса возникла ошибка');
			}
		});
	}
	$(document).ready(function(){
		$('.fm_textarea_button_generate_empty').live('click',function(){
			//return true;
			var template = $('.fm_textarea_template_item').val();
			if(template==''){
				alert('Не указан шаблон.');
				return false;
			}
			var ajax_result = '';
				var data = {
					action: 'fm_generate_template',
					template: template
				};
			
			//console.log(textarea_length);
			$('.fm_textarea_wrap_textarea .fm_textarea_item').each(function(){
				var val = $(this).val();
				if(val!=='') return;
				$(this).val('%RANDOM_CONTENT_FROM_TEMPLATE%');
			});
			/*
			var citys = '';
			$('.fm_textarea_wrap_textarea .fm_textarea_item').each(function(){
				var val = $(this).val();
				if(val!=='') return;
				var city = $(this).parents('.wp-editor-wrap').prev().text();
				citys += "- "+city+"\n";
			});
			*/
			//if(citys!=='') alert("Не сгенерировано для городов: \n"+citys);
			//return false;
			});
			
		$('.fm_textarea_button_generate_clear').live('click',function(){
			var prompt_txt = prompt('Для подтверждения очистки контента ВСЕХ региональных сайтов введите "del" в поле ниже');
			if(prompt_txt!=='del'){
				alert('Контент не очищен');
				return false;
			}
			//$('.fm_textarea_wrap_textarea .wp-switch-editor.switch-html').click();
			$('.fm_textarea_wrap_textarea .fm_textarea_item').val('');
			$('.fm_textarea_wrap_textarea .fm_textarea_item').addClass('empty');
			return false;
		});
		$('.fm_input_text input').keydown(function(e) {
			if(e.keyCode === 27) {
				$(this).parents('.fm_input_text').hide();
			}
		});
		$('.fm_input_text input').keydown(function(e) {
			if(e.keyCode === 13||e.keyCode === 9) { // 9 - Tab
			//if(e.keyCode === 13) {
				if(e.keyCode === 9){
					$(this).parents('td').next().find('input').focus();
				}
				var id = $(this).parents('.fm_button_edit').attr('data-id');
				var field = $(this).parents('.fm_button_edit').attr('data-field');
				var value = $(this).parents('.fm_button_edit').find('input').val();
				fm_send_req(id,field,value);
				return false;
			}
		});
		$('.fm_button_edit .dashicons-admin-customizer, .fm_button_edit .fm_input_text .dashicons-no').live('click',function(){
			$(this).parents('.fm_button_edit').find('.fm_input_text').toggle();
		});
		$('.fm_input_text .dashicons-yes').live('click',function(){
			var id = $(this).parents('.fm_button_edit').attr('data-id');
			var field = $(this).parents('.fm_button_edit').attr('data-field');
			var value = $(this).parents('.fm_button_edit').find('input').val();
			fm_send_req(id,field,value);
		});
	});
})(jQuery);