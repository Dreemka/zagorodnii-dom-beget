<?php
/*
Plugin Name: Fake Multisite
Description: Плагин для сборки региональных сайтов
Version: 1.0
Author: Sar-Lab.ru
*/
//include_once("class.gen.php");

add_filter( 'posts_clauses', 'filter_function_name_6048', 10, 2 );
function filter_function_name_6048( $clauses, $this ){
	$new_this = (array)$this;
	if($new_this['is_category']){
		//$clauses['where'] .= " AND wp_postmeta.meta_value ON 'engels'";
		//$clauses['join'] .= " INNER JOIN wp_posts.ID ON 165";
		// 165
		//m($clauses);
	}
	return $clauses;
}

function sort_posts( $query ) {
	//$query->set( 'cat', '6' );
}
add_action( 'pre_get_posts', 'sort_posts' );


if(!is_admin()){
ob_start();

add_action('shutdown', function() {
    $final = '';
    $levels = ob_get_level();

    for ($i = 0; $i < $levels; $i++) {
        $final .= ob_get_clean();
    }
    echo apply_filters('final_output', $final);
}, 0);

add_filter('final_output', 'filter_for_theme');
}
#add_filter( 'bloginfo', 'fm_replace_city_seo',50,2);
#add_filter( 'theme_mod_llorix_one_lite_ribbon_title', 'filter_for_theme' );
#add_filter( 'theme_mod_llorix_one_lite_our_story_text', 'filter_for_theme' );
#add_filter( 'theme_mod_llorix_one_lite_header_subtitle', 'filter_for_theme' );

function filter_for_theme( $current_mod,$u ){
	return do_shortcode(fm_replace_city_seo(str_replace('http://'.$_SERVER['SERVER_NAME'],'https://'.$_SERVER['SERVER_NAME'],$current_mod)));
}
function fm_replace_city_seo( $output='', $show='' ){
	$output = str_replace('%fm_name%',field_city_callback(array('field'=>'name')),$output);
	$output = str_replace('%fm_city1%',field_city_callback(array('field'=>'fm_city1')),$output);
	$output = str_replace('%fm_city2%',field_city_callback(array('field'=>'fm_city2')),$output);
	$output = str_replace('%fm_city3%',field_city_callback(array('field'=>'fm_city3')),$output);
	$output = str_replace('%fm_city4%',field_city_callback(array('field'=>'fm_city4')),$output);
	$output = str_replace('%fm_city5%',field_city_callback(array('field'=>'fm_city5')),$output);
	return $output;
}

function m($arr=array(),$text=''){
	echo "<hr>$text<br><pre>";
	print_r($arr);
	echo "</pre><hr>";
}
/*
	$result = explode('|',$matches[1]);
	$result_id = array_rand($result);
	$result = $result[$result_id];
	return $result;
*/
function generate_text_callback($matches){
	$result = explode('|',$matches[1]);
	$result_id = array_rand($result);
	//$result_id = 0;
	$result = $result[$result_id];
	return $result;
}
/*
function generate_text($text='',$count=1){
	//static $return;
	$count = (int)$count;
	if($count==0) $count=1;

	if (preg_match_all("/\{(.*)\}/isU", $text, $matches)){
		$return = array('status'=>'new', 'content'=>preg_replace_callback("/\{(.*)\}/isU","generate_text_callback",$text));
	} else {
		$return = array('status'=>'old','content' => $text);
	}
	return $return;
}
*/
function generate_text($text='',$count=1){
	$count = (int)$count;
	if($count==0) $count=1;
	$return = array('status'=>'old','content'=>'','count'=>$count);
	if (!preg_match("/\{(.*)\}/isU", $text)){
		return $return;
	}
	$temp_return = array();
	$count_i = 1;
	while($count_i<=$count){
		$result = preg_replace_callback("/\{(.*)\}/isU","generate_text_callback",$text);
		$temp_return[] = array('status'=>'new','content'=>$result,'count'=>$count);
	$count_i++;
	}
	$return = $temp_return; // сделать чтобы были только уникальные значения
	return $return;
}

/*
	$generator = new TextTemplateGenerator($text);
	$result = $generator->generate($count);
	return $result;
*/



add_action( 'admin_enqueue_scripts', 'fm_script' );
function fm_script(){
	wp_enqueue_script( 'fm_script', plugins_url( '/common.js', __FILE__ ),array('jquery'));
	wp_enqueue_style("fm_style", plugins_url( '/common.css', __FILE__ ));
}
function fm_remove_post_columns_city($posts_columns) {
	$posts_columns = array(
		"cb" => "2",
		"title" => "Заголовок",
		//"fm_list_city_priority" => "Приоритет",
		//'fm_city1' => 'Родительный падеж (из ...)',
		//'fm_city2' => 'Винительный падеж (в ...)',
		'fm_address' => 'Адрес',
		'fm_phone1' => 'Телефон',
		//'fm_phone2' => 'Телефон 2',
		'fm_slug' => 'Ярлык-Поддомен',
		'fm_active_subdomain' => '',
	);
	return $posts_columns;
}
add_filter('manage_fm-city_posts_columns', 'fm_remove_post_columns_city');
function fm_remove_post_columns_vector($posts_columns) {
	$posts_columns = array(
		"cb" => "",
		"title" => "Заголовок",
		'fm_from' => 'Откуда',
		'fm_to' => 'Куда',
	);
	return $posts_columns;
}
add_filter('manage_fm-vector_posts_columns', 'fm_remove_post_columns_vector');
function button_edit($text='',$id=0,$field=''){
	$id = (int)$id;
	//if(empty($text)) return '';
	$html = '<span class="fm_wrap_column"><span class="fm_value">'.$text.'</span> <span class="fm_button_edit" data-id="'.$id.'" data-field="'.$field.'"><span class="dashicons dashicons-admin-customizer" title="Редактировать значение"></span>';
	//if(!empty($text)) $html .= '<span class="dashicons dashicons-trash" title="Удалить значение"></span>';
	$html .= '<div class="fm_input_text"><input type="text" value="'.$text.'"><span class="dashicons dashicons-yes" title="Сохранить"></span><span class="dashicons dashicons-no" title="Отметить редактирование"></span></div></span></span>';
	return $html;
}
// заполняем колонку данными
add_filter('manage_fm-vector_posts_custom_column', 'fm_views_column_vector', 5, 2);
function fm_views_column_vector( $colname, $post_id ){
	if($colname==='fm_from'){
		echo get_post_meta($post_id, 'fm_from', 1);
		return;
	}
	if($colname==='fm_to'){
		echo get_post_meta($post_id, 'fm_to', 1);
		return;
	}
}
add_filter('manage_fm-city_posts_custom_column', 'fm_views_column_city', 5, 2);
function fm_views_column_city( $colname, $post_id ){
	if( $colname === 'fm_list_city_priority' ){
		if(get_post_field( 'menu_order', $post_id )) echo (int)get_post_field( 'menu_order', $post_id );
		return;
	}
	if( $colname === 'fm_city1' ){
		echo button_edit(get_post_meta($post_id, 'fm_city1', 1),$post_id,'fm_city1');
		return;
	}
	if( $colname === 'fm_city2' ){
		echo button_edit(get_post_meta($post_id, 'fm_city2', 1),$post_id,'fm_city2');
		return;
	}
	if( $colname === 'fm_city3' ){
		echo button_edit(get_post_meta($post_id, 'fm_city3', 1),$post_id,'fm_city3');
		return;
	}
	if( $colname === 'fm_city4' ){
		echo button_edit(get_post_meta($post_id, 'fm_city4', 1),$post_id,'fm_city4');
		return;
	}
	if( $colname === 'fm_city5' ){
		echo button_edit(get_post_meta($post_id, 'fm_city5', 1),$post_id,'fm_city5');
		return;
	}
	if( $colname === 'fm_address' ){
		echo button_edit(get_post_meta($post_id, 'fm_address', 1),$post_id,'fm_address');
		return;
	}
	if( $colname === 'fm_phone1' ){
		echo button_edit(get_post_meta($post_id, 'fm_phone1', 1),$post_id,'fm_phone1');
		return;
	}
	if( $colname === 'fm_phone2' ){
		echo button_edit(get_post_meta($post_id, 'fm_phone2', 1),$post_id,'fm_phone2');
		return;
	}
	if( $colname === 'fm_slug' ){
		echo get_post_field( 'post_name', $post_id );
		return;
	}
	if( $colname === 'fm_active_subdomain' ){
		if(get_post_meta($post_id, 'fm_active_subdomain', 1)==1){
			echo 'Сайт активен';
		} else {
			echo 'Сайт НЕ активен';
		}
		return;
	}
}
/////////////////////////////////////////////////////////////
add_action('add_meta_boxes', 'fm_extra_fields', 1);

function fm_extra_fields() {
	add_meta_box( 'fm_fields', 'Дополнительные поля для городов', 'fm_fields_box_func_city', 'fm-city', 'normal', 'high'  );
	add_meta_box( 'fm_fields_generator2', 'Привязка к региону', 'fm_fields_box2_func', 'page', 'side', 'high'  );
	add_meta_box( 'fm_fields_generator2', 'Привязка к региону', 'fm_fields_box2_func', 'post', 'side', 'high'  );
	add_meta_box( 'fm_fields_generator', 'Псевдоуникальный контент для региональных сайтов', 'fm_fields_box_func', 'page', 'normal', 'high'  );
	add_meta_box( 'fm_fields_generator', 'Псевдоуникальный контент для региональных сайтов', 'fm_fields_box_func', 'post', 'normal', 'high'  );
}
function fm_fields_box_func_city( $post ){
	if(!get_post_meta($post->ID, 'fm_city1', 1)||!get_post_meta($post->ID, 'fm_city2', 1)||!get_post_meta($post->ID, 'fm_city3', 1)||!get_post_meta($post->ID, 'fm_city4', 1)||!get_post_meta($post->ID, 'fm_city5', 1)){
		echo '<div class="fm_block_alert_morphos">Склонение по падежам загружены автоматически. <br>Необходимо проверить правильность. <br><button class="button button-primary button-large">Сохранить город</button></div>';
		$meta_city = json_decode(file_get_contents('http://morphos.io/api/inflect-geographical-name?name='.get_the_title()),true);
		//print_r($meta_city);
	}
	if(get_post_meta($post->ID, 'fm_city1', 1)) $fm_city1 = get_post_meta($post->ID, 'fm_city1', 1); else $fm_city1 = $meta_city['cases'][1];
	if(get_post_meta($post->ID, 'fm_city2', 1)) $fm_city2 = get_post_meta($post->ID, 'fm_city2', 1); else $fm_city2 = $meta_city['cases'][2];
	if(get_post_meta($post->ID, 'fm_city3', 1)) $fm_city3 = get_post_meta($post->ID, 'fm_city3', 1); else $fm_city3 = $meta_city['cases'][3];
	if(get_post_meta($post->ID, 'fm_city4', 1)) $fm_city4 = get_post_meta($post->ID, 'fm_city4', 1); else $fm_city4 = $meta_city['cases'][4];
	if(get_post_meta($post->ID, 'fm_city5', 1)) $fm_city5 = get_post_meta($post->ID, 'fm_city5', 1); else $fm_city5 = $meta_city['cases'][5];
	?>
	<p>Создать поддомен: <?php $current = get_post_meta($post->ID, 'fm_active_subdomain', 1); ?>
		 <label><input type="radio" name="fm-extra[fm_active_subdomain]" value="1" <?php checked( $current, '1' ); ?> /> Создать</label>
		 <label><input type="radio" name="fm-extra[fm_active_subdomain]" value="" <?php checked( $current, '' ); ?> /> Не создавать</label>
	</p>

	<p><label><input placeholder="Телефон в шапке" type="text" name="fm-extra[fm_phone1]" value="<?php echo get_post_meta($post->ID, 'fm_phone1', 1); ?>" style="width:50%" /> Телефон в шапке. <br><i>Если не указан, то отображается 8-800</i></label></p>

	<!--p><label><input placeholder="Второй телефон в шапке" type="text" name="fm-extra[fm_phone2]" value="<?php echo get_post_meta($post->ID, 'fm_phone2', 1); ?>" style="width:50%" /> Второй телефон в шапке</label></p-->

	<p><label><input placeholder="Адрес в подвале" type="text" name="fm-extra[fm_address]" value="<?php echo get_post_meta($post->ID, 'fm_address', 1); ?>" style="width:50%" /> Адрес в подвале и на странице контактов</label></p>

	<p><label><input placeholder="Город в родительном падеже" type="text" name="fm-extra[fm_city1]" value="<?php echo $fm_city1; ?>" style="width:50%" /> Город в родительном падеже.<br><i>с, у, от, до, из, без, для, вокруг, око­ло, воз­ле, кро­ме</i></label></p>
	
	<p><label><input placeholder="Город в дательном падеже" type="text" name="fm-extra[fm_city2]" value="<?php echo $fm_city2; ?>" style="width:50%" /> Город в дательном падеже.<br><i>к, по, бла­го­да­ря, вопре­ки, соглас­но</i></label></p>

	<p><label><input placeholder="Город в винительном падеже" type="text" name="fm-extra[fm_city3]" value="<?php echo $fm_city3; ?>" style="width:50%" /> Город в винительном падеже.<br><i>под, за, про, через, в, на, во</i></label></p>
	
	<p><label><input placeholder="Город в творительном падеже" type="text" name="fm-extra[fm_city4]" value="<?php echo $fm_city4; ?>" style="width:50%" /> Город в творительном падеже.<br><i>с, со, за, над, под, меж­ду, перед</i></label></p>
	
	<p><label><input placeholder="Город в предложном падеже" type="text" name="fm-extra[fm_city5]" value="<?php echo $fm_city5; ?>" style="width:50%" /> Город в предложном падеже.<br><i>в, о, об, на, при, по</i></label></p>

	<p><label><input placeholder="Адрес сайта, включая http:// или http://" type="text" name="fm-extra[fm_custom_url]" value="<?php echo get_post_meta($post->ID, 'fm_custom_url', 1); ?>" style="width:50%" /> Адрес будет использоваться для формирования списка городов. Если указан адрес, то необходимо включить поддомены (первый пункт настроек).</label></p>


	<input type="hidden" name="fm_extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}
function fm_fields_box2_func ($post){ ?>
	<input type="hidden" name="fm_extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<select name="fm-extra[_city_link]">
	<option value="">- Без привязки -</option>
	<?php 
	$args = array(
		'numberposts' => -1,
		'orderby'     => 'title',
		'order'       => 'ASC',
		'include'     => array(),
		'exclude'     => array(),
		'meta_key'    => 'fm_active_subdomain',
		'meta_value'  =>'1',
		'post_type'   => 'fm-city',
		'post_status'   => 'publish',
		'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
	);
	$value_field = get_post_meta($post->ID, '_city_link',1);
	//echo '<option>'.$value_field.'</option>';
	$posts_city = get_posts( $args );
	foreach($posts_city as $item_city){
		echo '<option value="'.$item_city->post_name.'" '.selected($item_city->post_name, $value_field, false ).'>'.$item_city->post_title.' ('.$item_city->post_name.')</option>';
	}
	
	?>	
	</select>
	<p>Если выбрать привязку к региону для страницы или записи, то они будут отображаться только на поддомене, к которому они привязаны.<br><i>Вывод на лицевой части сайта будет выполнен после наполнения сайта.</i></p>
<?php }
function fm_fields_box_func( $post ){
	?>
	<div class="fm_overlay_background"></div>
	<div class="fm_overlay_content">Генерируем текст для городов. Может занять продожительное время. <br>Проявите пожалуйста терпение.<br><span class="count"></span></div>
	<input type="hidden" name="fm_extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<p>Контент для региональных сайтов: <?php $current = get_post_meta($post->ID, '_fm_active_generator', 1);
	//if($current=='') echo '<style>.fm_textarea_wrap{display:none;}</style>';
	?>
		 <label><input type="radio" name="fm-extra[_fm_active_generator]" value="1" <?php checked( $current, '1' ); ?> /> Включить</label>
		 <label><input type="radio" name="fm-extra[_fm_active_generator]" value="" <?php checked( $current, '' ); ?> /> Выключить</label>
	</p>
	<?php if($current!=1) return ''; ?>
	<div class="fm_textarea_wrap">
	<div class="fm_textarea_button">
		<ul>
			<li><button class="button button-primary button-large fm_textarea_button_generate_empty" name="123">Генерировать текст из шаблона для сайтов без текста (с пустым контентом)</button></li>
		</ul>
		<button class="button button-secondary button-large fm_textarea_button_generate_clear">Очистить контент всех сайтов</button>
	</div>
	<h1>Шаблон для региональных сайтов</h1>
	<?php
	$fm_template = get_post_meta($post->ID, '_fm_generator_template', 1);
	wp_editor($fm_template, 'fmgteratetextareaadmin'.$post->ID, array(
		'wpautop'       => 1,
		'media_buttons' => 1,
		'textarea_name' => 'fm-extra[_fm_generator_template]',
		'textarea_rows' => 10,
		'tabindex'      => null,
		'editor_css'    => '',
		'editor_class'  => 'fm_textarea_template_item',
		'teeny'         => 0,
		'dfw'           => 0,
		'tinymce'       => 1,
		'quicktags'     => 1,
		'drag_drop_upload' => false
	) );
	?>
	<div class="fm_textarea_wrap_textarea" data-count="<?php echo (int)$result_generate_count; ?>">
	<?php $i=1;

	$args = array(
		'numberposts' => -1,
		'orderby'     => 'title',
		'order'       => 'ASC',
		'include'     => array(),
		'exclude'     => array(),
		'meta_key'    => 'fm_active_subdomain',
		'meta_value'  =>'1',
		'post_type'   => 'fm-city',
		'post_status'   => 'publish',
		'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
	);

	$posts_city = get_posts( $args );
	foreach($posts_city as $item_city){
		//m($item_city);
		echo '<h1>'.$item_city->post_title.'</h1>';
		$slug = $item_city->post_name;
		$value_field = get_post_meta($post->ID, '_fm_generator_text_'.$slug, 1);
		$value_empty = '';
		if(empty($value_field)) $value_empty = ' empty';
		wp_editor($value_field, 'fmgteratetextareaadmin'.$slug.'field'.$i, array(
			'wpautop'       => 1,
			'media_buttons' => 0,
			'textarea_name' => 'fm-extra[_fm_generator_text_'.$slug.']',
			'textarea_rows' => 5,
			'tabindex'      => null,
			'editor_css'    => '',
			'editor_class'  => 'fm_textarea_item'.$value_empty,
			'teeny'         => 0,
			'dfw'           => 0,
			'tinymce'       => 0,
			'quicktags'     => 0,
			'drag_drop_upload' => false
		) );
		$i++;
	}
	/*
	while($i<=15){
		$temp_result_id = array_rand($result_generate);
		$temp_result = $result_generate[$temp_result_id];
		unset($result_generate[$temp_result_id]);
		echo '<b>Результат '.$i.': </b>'.$temp_result.'<br><br>';
		$i++;
	}
	*/
	?>
	</div>

	</div>
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'fm_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function fm_extra_fields_update( $post_id ){
	if ( !isset($_POST['fm_extra_fields_nonce']) || !wp_verify_nonce($_POST['fm_extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['fm-extra']) ) return false;
	$_POST['fm-extra'] = array_map('trim', $_POST['fm-extra']);
	$template = $_POST['fm-extra']['_fm_generator_template'];
	$result_generate = generate_text($template,1000);
	foreach( $_POST['fm-extra'] as $key=>$value ){
		if($value=='%RANDOM_CONTENT_FROM_TEMPLATE%'){
			if(!empty($result_generate)){
				$temp_result_id = array_rand($result_generate);
				$array_text = $result_generate[$temp_result_id]['content'];
				unset($result_generate[$temp_result_id]);
				$value = $array_text;
			} else {
				$value = '';
			}
		}
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}
		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}
add_action('template_redirect', 'fm_set_template');
function fm_set_template() {
	global $post;
    $template_path = TEMPLATEPATH . '/template-fm-city.php';
    if(file_exists($template_path)&&$post->post_type=='fm-city'){
        include($template_path);
        exit;
    }
}
add_action('init', 'do_rewrite');
function do_rewrite(){
	add_rewrite_rule( '^robots.txt$', 'index.php?fm_blender=robots', 'top' );
	add_filter( 'query_vars', function( $vars ){
		$vars[] = 'fm_blender';
		return $vars;
	} );
}
add_action( 'init', 'create_topics_hierarchical_taxonomy', 1 );
add_filter( 'pre_handle_404', 'fm_filter_subdomain', 10, 2 );
function field_city_callback( $atts ){
	global $post;
	static $fm_global;
	//return '';
	$post_slug = $post->post_name;
	$post_type = $post->post_type;
	/*
	array(
		'field' => 'fm_city2',
		'action' => 'test',
	);
	*/
	extract($atts);
	$value = '';
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	if($get_slug){
		$host = $post_slug;
	}
	if($fm_global[$host][$field]&&$get_slug==''){
		$value = $fm_global[$host][$field];
		//$fm_global[$field] = $value;
	}
	if(!$value){
		$query_filter = get_posts(array(
			'name' => $host,
			'post_type' => 'fm-city',
			'post_status' => 'publish',
			));
		$query_filter = $query_filter[0];
		$query_filter = $query_filter->ID;
	}
	if($field=='name'&&!$value){
		/*
		[field_city field="fm_city2"]
		[field_city field="fm_city1"]
		[field_city field="fm_address"]
		[field_city field="fm_phone1"]
		[field_city field="fm_phone2"]
		[field_city field="name"]
		[field_city field="fm_phone2" action="phone_link"]
		[field_city field="fm_city2" get_slug="1"]
		*/
		$value = get_post($query_filter);
		$value = $value->post_title;
		$fm_global[$host][$field] = $value;
		return $value;
	}
	if($field=='slug'&&!$value){
		$value = get_post($query_filter);
		$value = $value->post_name;
		$fm_global[$host][$field] = $value;
		return $value;
	}
	if(!$value) $value = get_post_meta($query_filter, $field, 1);
	if($get_slug){
		//$value = '<a href="http://'.$host.'.zagorodnii-dom.ru">'.$value.'</a>';
	}
	
	if(!$value&&$field=='fm_phone1'){
		$value = 'телефон по-умолчанию';
	}
	if(!$value&&$field=='fm_address'){
		$value = 'адрес по-умолчанию';
	}
	
	if($action=='phone_link'){
		$value = str_replace(array('(',')',' ','+','-'),'',$value);
		if(substr($value, 0, 1)==8){
			$value = '+7'.substr($value, 1);
		}
	}
	if(!$action){
		$fm_global[$host][$field] = $value;
	}
	return do_shortcode($value);
}
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'wp_generator' );
function fm_dinamic_contact_mail_callback($in){
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	$return = $host.'@zagorodnii-dom.ru';
	return $return;
}
function fm_list_city_callback($in){
	$link_prior_city = '<ul class="col-4">
		<li><a href="http://zagorodnii-dom.ru">Москва</a></li>
		<li><a href="http://volgograd.zagorodnii-dom.ru/">Волгоград</a></li>
		<li><a href="http://vladivostok.zagorodnii-dom.ru/">Владивосток</a></li>
		<li><a href="http://ekaterinburg.zagorodnii-dom.ru/">Екатеринбург</a></li>
		<li><a href="http://irkutsk.zagorodnii-dom.ru/">Иркутск</a></li>
		<li><a href="http://krasnodar.zagorodnii-dom.ru/">Краснодар</a></li>
		<li><a href="http://krasnoyarsk.zagorodnii-dom.ru/">Красноярск</a></li>
		<li><a href="http://kemerovo.zagorodnii-dom.ru/">Кемерово</a></li>

		<li><a href="http://kazan.zagorodnii-dom.ru/">Казань</a></li>
		<li><a href="http://ufa.zagorodnii-dom.ru/">Уфа</a></li>
		<li><a href="http://voronezh.zagorodnii-dom.ru/">Воронеж</a></li>

		<li><a href="http://nizhniy-novgorod.zagorodnii-dom.ru/">Нижний Новгород</a></li>
		<li><a href="http://novosibirsk.zagorodnii-dom.ru/">Новосибирск</a></li>
		<li><a href="http://omsk.zagorodnii-dom.ru/">Омск</a></li>
		<li><a href="http://perm.zagorodnii-dom.ru/">Пермь</a></li>
		<li><a href="http://rostov-na-donu.zagorodnii-dom.ru/">Ростов-на-Дону</a></li>
		<li><a href="http://sankt-peterburg.zagorodnii-dom.ru/">Санкт-Петербург</a></li>

		<li><a href="http://samara.zagorodnii-dom.ru/">Самара</a></li>
		<li><a href="http://saratov.zagorodnii-dom.ru/">Саратов</a></li>
		<li><a href="http://surgut.zagorodnii-dom.ru">Сургут</a></li>
		<li><a href="http://tyumen.zagorodnii-dom.ru/">Тюмень</a></li>
		<li><a href="http://chelyabinsk.zagorodnii-dom.ru/">Челябинск</a></li>
		<li><a href="http://yakutsk.zagorodnii-dom.ru/">Якутск</a></li>
		<li><a href="http://yaroslavl.zagorodnii-dom.ru/">Ярославль</a></li>

</ul>';
	//return $return;
	$temp_result = '';
	/*
	$query_filter = get_posts(array(
		'post_type' => 'fm-city',
		'post_status' => 'publish',
		'meta_key' => 'fm_active_subdomain',
		'meta_value' => '1',
		'orderby' => 'post_title',
		'order' => 'ASC',
		'numberposts' => -1

	));
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	foreach($query_filter as $city){
		$href = 'http://'.$city->post_name.'.zagorodnii-dom.ru'.$_SERVER['REQUEST_URI'];
		$for_href = get_post_meta($city->ID, 'fm_custom_url', 1);
		if($for_href) $href = $for_href;
		if($host!==$city->post_name) $temp_result .= '<li data-search="'.mb_strtolower($city->post_title).'" class="link"><a href="'.$href.'">'.$city->post_title.'</a></li>';
	}
	*/
	$query = new WP_Query(array(
		'post_type' => 'fm-city',
		'post_status' => 'publish',
		'meta_key' => 'fm_active_subdomain',
		'meta_value' => '1',
		'orderby' => array(/*'menu_order' => 'DESC',*/'post_title' => 'ASC' ),
		'numberposts' => -1,
		'posts_per_page' => -1,


	));
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	$let = '';
	$arr_let = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$post = get_post();
		$href = 'http://'.$post->post_name.'.zagorodnii-dom.ru'.$_SERVER['REQUEST_URI'];
		$for_href = get_post_meta($post->ID, 'fm_custom_url', 1);
		if($for_href) $href = $for_href;
		if($host!==$post->post_name){
			$curr_let = mb_strtolower(get_the_title(), 'UTF-8');
			$curr_let = mb_substr($curr_let,0,1);
			if($curr_let!==$let){
				if($let!=='') $temp_result .= '</ul></div>';
				$arr_let[] = '<li class="let_list_item" data-id="'.$curr_let.'">'.$curr_let.'</li>';
				$temp_result .= '<div class="let_items_wrap" data-id="'.$curr_let.'"><span class="let_items_title">'.$curr_let.'</span><ul class="let_items_ul">';
			}
			$temp_result .= '<li data-search="'.mb_strtolower(get_the_title()).'" class="link"><a href="'.$href.'">'.get_the_title().'</a></li>';
			$let = $curr_let;
		}
	}
	wp_reset_postdata();
	if($temp_result){
		//$return = '<div class="fm_list_city_search"><input type="text" class="fm_list_city_input" placeholder="Поиск ..."></div><ul>';
		$return = '<div class="link_prior_city">'.$link_prior_city.'</div><div class="fm_list_city_search"><input type="text" class="fm_list_city_input" placeholder="Поиск ..."></div><div class="let_list_items_wrap"><ul class="let_list_items">'.implode("\n",$arr_let).'</ul></div>';
		$return .= $temp_result;
		//$return .= '</ul>';
	}
	return $return;
}
add_shortcode('fm_dinamic_contact_mail', 'fm_dinamic_contact_mail_callback');
add_shortcode('fm_list_city', 'fm_list_city_callback');
add_shortcode('field_city', 'field_city_callback');
add_filter('the_title', 'fm_shortcode_callback');
add_filter('aioseop_title', 'fm_shortcode_callback');
add_filter('aioseop_description', 'fm_shortcode_callback');
add_filter('the_content', 'fm_the_content_callback');
function fm_shortcode_callback($text){
	return fm_replace_city_seo(do_shortcode($text));
}
function fm_the_content_callback( $text ){
	global $post;
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	$new_text = get_post_meta($post->ID, '_fm_generator_text_'.$host, 1);
	$generate_on = false;
	$generate_on = get_post_meta($post->ID, '_fm_active_generator', 1);
	if(!$new_text||!$generate_on) return $text;
	return $new_text;
}

function fm_filter_subdomain(){
	global $wp_query;
	if(get_query_var('fm_blender')=='robots'){
		header('Content-Type: text/plain;Charset=utf-8');
		$result = @file_get_contents($_SERVER['DOCUMENT_ROOT'].'/robots_.txt');
		$result = str_replace('%SPEC_RULES_FOR_DOMAIN%',@file_get_contents($_SERVER['DOCUMENT_ROOT'].'/robots_'.$_SERVER['SERVER_NAME'].'.txt'), $result);
		$result = str_replace('%DOMAIN%',$_SERVER['SERVER_NAME'],$result);
		echo $result;
		exit;
	}
	$host = $_SERVER['HTTP_HOST'];
	$host = explode('.',$host);
	$host = $host[0];
	$check = false;
	if(strpos($_SERVER['REQUEST_URI'],'/'.$host.'/')){
		header('Location: '.str_replace($host.'/','',$_SERVER['REQUEST_URI']));
		//echo '301 - test!!!';
		exit;
	}
	$query_filter = get_posts(array(
		'name' => $host,
		'post_type' => 'fm-city',
		'post_status' => 'publish',
		'meta_key' => 'fm_active_subdomain',
		'meta_value' => '1'
		));
	$check = count($query_filter);
	$id_city = $query_filter[0];
	$id_city = $id_city->ID;
	if(!$check||get_query_var('fm_for404')||get_post_meta($id_city, 'fm_custom_url', 1)){
		header('Location: https://zagorodnii-dom.ru/');
		//echo '301 - test!!!';
		exit;
		$wp_query->set_404();
		status_header(404);
		nocache_headers();
		return 'stop';
	}
	return false;
}

function create_topics_hierarchical_taxonomy() {


  $labels = array(
    'name' => "Регионы",
    'singular_name' => "Регионы",
    'search_items' =>  "Поиск регионов",
    'all_items' => "Все регионы",
    //'parent_item' => __( 'Parent Topic' ),
    //'parent_item_colon' => __( 'Parent Topic:' ),
    'edit_item' => "Редактировать регион",
    'update_item' => "Обновить регион",
    'add_new_item' => "Создать новый",
    'new_item_name' => "Создать новый регион",
    'menu_name' => "Регионы",
  );

// Теперь регистрируем таксономию

  register_taxonomy('fm-region',array('fm-city'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    //'query_var' => true,
    'rewrite' => false,
	'show_in_nav_menus' => false,
	'publicly_queryable' => false
  ));

}

add_action('init', 'register_post_types');
function register_post_types(){
	register_post_type('fm-city', array(
		'label'  => false,
		'labels' => array(
			'name'               => 'Города', // основное название для типа записи
			'singular_name'      => 'Представительства в России', // название для одной записи этого типа
			'add_new'            => 'Добавить город', // для добавления новой записи
			'add_new_item'       => 'Добавить новый город', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать город', // для редактирования типа записи
			'new_item'           => 'Новый город', // текст новой записи
			'view_item'          => 'Смотреть город', // для просмотра записи этого типа.
			'search_items'       => 'Искать город', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Города', // название меню
		),
		'description'         => '',
		'public'              => true,
		'exclude_from_search' => true,
		'show_in_rest' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-admin-site',
		'hierarchical' => false,
		//'supports' => array('title','custom-fields'),
		'supports' => array('title','page-attributes','custom-fields'),
		'has_archive' => false,
		//'rewrite' => array('slug'=>'gruzoperevozki-po-rossii','with_front'=>false,'feeds'=>false),
		'rewrite' => array('slug'=>'filial','with_front'=>false,'feeds'=>false),
		//'rewrite' => false,
	) );
	/*
	register_post_type('fm-vector', array(
		'label'  => false,
		'labels' => array(
			'name'               => 'Направления', // основное название для типа записи
			'singular_name'      => 'Направление', // название для одной записи этого типа
			'add_new'            => 'Добавить направление', // для добавления новой записи
			'add_new_item'       => 'Добавить новое направление', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать направление', // для редактирования типа записи
			'new_item'           => 'Новое направление', // текст новой записи
			'view_item'          => 'Смотреть направление', // для просмотра записи этого типа.
			'search_items'       => 'Искать направление', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Направления', // название меню
		),
		'description'         => '',
		'public'              => true,
		'exclude_from_search' => true,
		'show_in_rest' => false,
		'publicly_queryable' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-sort',
		'hierarchical' => false,
		'supports' => array('title','editor','custom-fields'),
		//'supports' => array('title'),
		'has_archive' => false,
		'rewrite' => false,
	) );
	*/
}
add_filter('post_updated_messages', 'fm_updated_messages');
function fm_updated_messages( $messages ) {
	global $post;

	$messages['fm-city'] = array(
		0 => '', // Не используется. Сообщения используются с индекса 1.
		1 => sprintf( 'Город обновлен. <a href="%s">Посмотреть на сайте</a>', esc_url( get_permalink($post->ID) ) ),
		2 => 'Произвольное поле обновлено.',
		3 => 'Произвольное поле удалено.',
		4 => 'Город обновлен.',
		/* %s: дата и время ревизии */
		5 => isset($_GET['revision']) ? sprintf( 'Город восстановлен из ревизии %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Город опубликован. <a href="%s">Перейти к записи</a>', esc_url( get_permalink($post->ID) ) ),
		7 => 'Город сохранен.',
		8 => sprintf( 'Город сохранен. <a target="_blank" href="%s">Предпросмотр записи</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post->ID) ) ) ),
		9 => sprintf( 'Публикация города запланирована на: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Предпросмотр записи</a>',
		  // Как форматировать даты в PHP можно посмотреть тут: http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post->ID) ) ),
		10 => sprintf( 'Черновик города обновлен. <a target="_blank" href="%s">Предпросмотр записи</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post->ID) ) ) ),
	);

	return $messages;
}
// Раздел "помощь" типа записи fm-city
add_action( 'contextual_help', 'add_help_text', 10, 3 );
function add_help_text( $contextual_help, $screen_id, $screen ){
	//$contextual_help .= print_r($screen); // используйте чтобы помочь определить параметр $screen->id
	if('fm-city' == $screen->id ) {
		$contextual_help = '
		<p>На странице создания и редактирования города доступен блок "Дополнительные поля для городов". Поля из блока выводятся на сайте в шаблоне (сайдбаре, шапке, подвале).</p>
		<p>На основе "Ярлыка" будет создан поддомен вида <ярлык>.site.ru</p>';
	}
	elseif( 'edit-fm-city' == $screen->id ) {
		//$contextual_help = '<p>Здесь будет написано описание Городов и их назначение</p>';
	}

	return $contextual_help;
}

add_action('wp_ajax_fm_generate_template', 'fm_generate_template');
function fm_generate_template() {
	extract($_POST);
	$count = (int)$count;
	$result = generate_text($template,$count);
	echo json_encode($result,256);
	wp_die();
}
add_action('wp_ajax_fm_edit_field', 'fm_edit_field_callback');
function fm_edit_field_callback() {
	extract($_POST);
	$id = (int)$id;
	$old_val = get_post_meta($id, $field, 1);
	//var_dump($old_val);
	if($value==''&&$old_val!==''){
		$result = delete_post_meta($id, $field);
	} elseif($old_val!==$value){
		if($old_val!==''){
			$result = update_post_meta($id, $field, $value);
			if($result>0) $result = 1;
		} else {
			$result = add_post_meta($id, $field, $value, true);
			//var_dump($result);
			if($result>0) $result = 1;
		}
	} else{
		$result = 1;
	}
	$result = (int)$result;
	echo $result;
	wp_die();
}
//echo get_bloginfo( 'name','display');
?>
