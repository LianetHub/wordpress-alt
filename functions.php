<?php
define('TEMPLATE_PATH', dirname(__FILE__) . '/templates/');
function my_theme_enqueue_styles()
{
	wp_enqueue_style(
		'theme-style', // handle
		get_template_directory_uri() . '/style.css', // путь до style.css
		array(), // зависимости
		filemtime(get_template_directory() . '/style.css') // версия по времени изменения
	);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function theme_enqueue_styles()
{

	wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/libs/swiper-bundle.min.css');
	wp_enqueue_style('fancybox', get_template_directory_uri() . '/assets/css/libs/fancybox.css');
	wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.min.css');
	wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


function theme_enqueue_scripts()
{
	wp_deregister_script('jquery');

	wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/libs/jquery-3.7.1.min.js', array(), null, true);

	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/assets/js/libs/fancybox.umd.js', array(), null, true);

	wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function allow_svg_uploads($mimes)
{

	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');



function set_global_acf_fields()
{
	$GLOBALS['global_acf_fields'] = [
		'phone_number' => get_field('phone_number', 'option'),
		'email_address' => get_field('email_address', 'option'),
		'work_time' => get_field('work_time', 'option'),
		'company_details' => get_field('company_details', 'option'),
		'telegram_url' => get_field('telegram_url', 'option'),
		'whatsapp_url' => get_field('whatsapp_url', 'option'),
		'map_iframe_url' => get_field('map_iframe_url', 'option'),
		'organization_address' => get_field('organization_address', 'option'),
		'benefits_blocks' => get_field('benefits_blocks', 'option'),
		'client_logos' => get_field('client_logos', 'option'),
		'reviews' => get_field('reviews', 'option'),
		'team_members' => get_field('team_members', 'option'),
		'сertificates' => get_field('сertificates', 'option'),
		'support_block' => get_field('support_block', 'option'),
		'company_principles' => get_field('company_principles', 'option'),
	];
}
add_action('wp', 'set_global_acf_fields');



add_filter('wpcf7_autop_or_not', '__return_false');

add_theme_support('post-thumbnails');


function register_my_menus()
{

	register_nav_menus(array(
		'top_header_menu' => __('Меню для государственных заказчиков'),
		'header-menu' => __('Основное меню в шапке'),
	));
}
add_action('after_setup_theme', 'register_my_menus');



class Custom_Nav_Menu_Walker extends Walker_Nav_Menu
{

	function start_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);

		if (0 === $depth) {
			$output .= '<div class="submenu"><div class="container"><div class="submenu__header"><div class="submenu__header-name">ОТРАСЛИ</div><button type="button" class="submenu__close icon-prev">Все меню</button></div><div class="submenu__body"><ul class="submenu__list">';
		} else {
			$output .= "\n{$indent}<ul class=\"sub-menu\">\n";
		}
	}

	function end_lvl(&$output, $depth = 0, $args = null)
	{
		if (0 === $depth) {
			$output .= '</ul>';


			$terms = get_terms(array(
				'taxonomy'   => 'project_industry',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			));

			if (! empty($terms) && ! is_wp_error($terms)) {
				$output .= '<div class="submenu__description">';
				foreach ($terms as $term) {
					$industry_title = esc_html($term->name);


					$industry_text = esc_html($term->description);

					$term_link = get_term_link($term);

					$output .= '<div class="submenu__description-block">';
					$output .= '<h3 class="submenu__description-title title-md">' . $industry_title . '</h3>';
					$output .= '<p class="submenu__description-text">' . $industry_text . '</p>';
					$output .= '<a href="' . esc_url($term_link) . '" class="submenu__description-btn btn btn-primary">Подробнее</a>';
					$output .= '</div>';
				}
				$output .= '</div>';
			}
			$output .= '</div></div></div>';
		} else {
			$indent = str_repeat("\t", $depth);
			$output .= "\n{$indent}</ul>\n";
		}
	}


	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = ($depth) ? str_repeat($t, $depth) : '';

		if (is_array($args)) {
			$args = (object) $args;
		}

		$classes   = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if (0 === $depth) {
			$classes[] = 'menu__item';
		} else {
			$classes[] = 'submenu__item';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

		if (in_array('menu-item-has-children', $classes) && 0 === $depth) {
			$class_names .= ' menu-parent';
		}

		$output .= $indent . '<li id="menu-item-' . $item->ID . '" class="' . esc_attr($class_names) . '">';


		$attributes = '';
		foreach (array('attr_title', 'attr_target', 'attr_rel', 'url') as $attr) {
			if ('url' === $attr) {
				$attributes .= ! empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
			} elseif (! empty($item->$attr)) {
				$attributes .= ' ' . esc_attr(str_replace('attr_', '', $attr)) . '="' . esc_attr($item->$attr) . '"';
			}
		}


		$link_classes = [];

		if (0 === $depth) {
			$link_classes[] = 'menu__link';
		} else {
			$link_classes[] = 'submenu__link';
		}


		$item_output = $args->before;
		$item_output .= '<a' . $attributes . ' class="' . esc_attr(implode(' ', $link_classes)) . '">';


		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';


		if (in_array('menu-item-has-children', $classes) && 0 === $depth) {
			$item_output .= '<button type="button" class="menu__arrow icon-chevron-down"></button>';
		}

		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

function fix_widows_after_prepositions($text)
{

	$prepositions = [
		'в',
		'и',
		'к',
		'с',
		'на',
		'у',
		'о',
		'от',
		'для',
		'за',
		'по',
		'без',
		'из',
		'над',
		'под',
		'при',
		'про',
		'через',
		'об',
		'со'
	];

	$pattern = implode('|', array_map('preg_quote', $prepositions));

	$regex = '/\b(' . $pattern . ')\s+/iu';


	$text = preg_replace_callback($regex, function ($matches) {
		return $matches[1] . "\xC2\xA0";
	}, $text);

	return $text;
}
function get_russian_post_date($post_id = null, $format = 'text')
{
	if (null === $post_id) {
		$post_id = get_the_ID();
	}


	$post_timestamp = get_the_time('U', $post_id);
	if ($format === 'datetime') {
		return get_the_time('c', $post_id);
	}

	$months = [
		1 => 'января',
		2 => 'февраля',
		3 => 'марта',
		4 => 'апреля',
		5 => 'мая',
		6 => 'июня',
		7 => 'июля',
		8 => 'августа',
		9 => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря'
	];

	$day = date('j', $post_timestamp);
	$month = $months[date('n', $post_timestamp)];
	$year = date('Y', $post_timestamp);

	return "$day $month $year";
}



add_filter('wpseo_breadcrumb_separator', 'my_custom_breadcrumb_separator');
function my_custom_breadcrumb_separator($separator)
{
	return '/';
}



function yourtheme_widgets_init()
{
	register_sidebar(array(
		'name'          => esc_html__('Сайдбар статьи (Оглавление)'),
		'id'            => 'article-toc-sidebar',
		'description'   => esc_html__('Добавьте виджеты сюда для оглавления статьи.'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="article__sidebar-caption title-sm">',
		'after_title'   => '</div>',
	));
}
add_action('widgets_init', 'yourtheme_widgets_init');


function create_project_post_type()
{
	$labels = array(
		'name'                  => _x('Проекты', 'Post Type General Name', 'textdomain'),
		'singular_name'         => _x('Проект', 'Post Type Singular Name', 'textdomain'),
		'menu_name'             => __('Проекты', 'textdomain'),
		'name_admin_bar'        => __('Проект', 'textdomain'),
		'archives'              => __('Архивы Проектов', 'textdomain'),
		'attributes'            => __('Атрибуты Проекта', 'textdomain'),
		'parent_item_colon'     => __('Родительский Проект:', 'textdomain'),
		'all_items'             => __('Все Проекты', 'textdomain'),
		'add_new_item'          => __('Добавить новый Проект', 'textdomain'),
		'add_new'               => __('Добавить новый', 'textdomain'),
		'new_item'              => __('Новый Проект', 'textdomain'),
		'edit_item'             => __('Редактировать Проект', 'textdomain'),
		'update_item'           => __('Обновить Проект', 'textdomain'),
		'view_item'             => __('Посмотреть Проект', 'textdomain'),
		'view_items'            => __('Посмотреть Проекты', 'textdomain'),
		'search_items'          => __('Искать Проекты', 'textdomain'),
		'not_found'             => __('Проекты не найдены', 'textdomain'),
		'not_found_in_trash'    => __('В корзине Проекты не найдены', 'textdomain'),
		'featured_image'        => __('Изображение Проекта', 'textdomain'),
		'set_featured_image'    => __('Установить изображение Проекта', 'textdomain'),
		'remove_featured_image' => __('Удалить изображение Проекта', 'textdomain'),
		'use_featured_image'    => __('Использовать как изображение Проекта', 'textdomain'),
		'insert_into_item'      => __('Вставить в Проект', 'textdomain'),
		'uploaded_to_this_item' => __('Загружено для этого Проекта', 'textdomain'),
		'items_list'            => __('Список Проектов', 'textdomain'),
		'items_list_navigation' => __('Навигация по списку Проектов', 'textdomain'),
		'filter_items_list'     => __('Фильтровать список Проектов', 'textdomain'),
	);
	$args = array(
		'label'                 => __('Проект', 'textdomain'),
		'description'           => __('Тип записи для ваших проектов', 'textdomain'),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'), // Убраны comments
		'taxonomies'            => array('project_industry'), // Связываем с нашей новой таксономией
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'rewrite'               => array('slug' => 'projects'),
	);
	register_post_type('project', $args);
}
add_action('init', 'create_project_post_type');


function create_project_industry_taxonomy()
{
	$labels = array(
		'name'                       => _x('Отрасли проектов', 'Taxonomy General Name', 'textdomain'),
		'singular_name'              => _x('Отрасль проекта', 'Taxonomy Singular Name', 'textdomain'),
		'menu_name'                  => __('Отрасли', 'textdomain'),
		'all_items'                  => __('Все Отрасли', 'textdomain'),
		'parent_item'                => __('Родительская Отрасль', 'textdomain'),
		'parent_item_colon'          => __('Родительская Отрасль:', 'textdomain'),
		'new_item_name'              => __('Новая Отрасль', 'textdomain'),
		'add_new_item'               => __('Добавить новую Отрасль', 'textdomain'),
		'edit_item'                  => __('Редактировать Отрасль', 'textdomain'),
		'update_item'                => __('Обновить Отрасль', 'textdomain'),
		'view_item'                  => __('Посмотреть Отрасль', 'textdomain'),
		'separate_items_with_commas' => __('Разделяйте отрасли запятыми', 'textdomain'),
		'add_or_remove_items'        => __('Добавить или удалить отрасли', 'textdomain'),
		'choose_from_most_used'      => __('Выбрать из наиболее используемых', 'textdomain'),
		'popular_items'              => __('Популярные Отрасли', 'textdomain'),
		'search_items'               => __('Искать Отрасли', 'textdomain'),
		'not_found'                  => __('Отрасли не найдены', 'textdomain'),
		'no_terms'                   => __('Нет отраслей', 'textdomain'),
		'items_list'                 => __('Список Отраслей', 'textdomain'),
		'items_list_navigation'      => __('Навигация по списку Отраслей', 'textdomain'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true, // Отображать как колонку в списке проектов
		'query_var'                  => true,
		'rewrite'                    => array(
			'slug'       => 'industries',
			'with_front' => false,
			'hierarchical' => true
		),
	);
	register_taxonomy('project_industry', array('project'), $args); // Связываем таксономию с типом записи 'project'
}
add_action('init', 'create_project_industry_taxonomy', 0);
