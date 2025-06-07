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
		'telegram_url' => get_field('telegram_url', 'option'),
		'organization_address' => get_field('organization_address', 'option'),
		'benefits_blocks' => get_field('benefits_blocks', 'option'),
	];
}
add_action('wp', 'set_global_acf_fields');



add_filter('wpcf7_autop_or_not', '__return_false');

add_theme_support('post-thumbnails');



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


// function register_teachers_post_type()
// {
// 	register_post_type('teacher', [
// 		'labels' => [
// 			'name' => 'Преподаватели',
// 			'singular_name' => 'Преподаватель',
// 			'add_new' => 'Добавить преподавателя',
// 			'edit_item' => 'Редактировать преподавателя'
// 		],
// 		'public' => true,
// 		'has_archive' => false,
// 		'publicly_queryable' => false,
// 		'menu_icon' => 'dashicons-welcome-learn-more',
// 		'supports' => ['title', 'editor', 'thumbnail'],
// 	]);
// }
// add_action('init', 'register_teachers_post_type');
