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
	if (function_exists('get_field')) {
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
}
add_action('acf/init', 'set_global_acf_fields');



add_filter('wpcf7_autop_or_not', '__return_false');

add_theme_support('post-thumbnails');


function register_my_menus()
{

	register_nav_menus(array(
		'top_header_menu' => __('Меню для государственных заказчиков'),
		'header-menu' => __('Основное меню в шапке'),
		'footer-industry-menu' => __('Меню отраслей в подвале'),
		'footer-products-menu' => __('Меню продукции в подвале'),
		'footer-primary-menu' => __('Основное Меню в подвале'),
	));
}
add_action('after_setup_theme', 'register_my_menus');



class Custom_Nav_Menu_Walker extends Walker_Nav_Menu
{
	private $first_level_term_ids = [];

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

			$terms_to_display = [];
			foreach ($this->first_level_term_ids as $term_id) {
				$term = get_term($term_id, 'project_industry');
				if ($term && !is_wp_error($term)) {
					$terms_to_display[$term_id] = $term;
				}
			}


			$all_terms = get_terms(array(
				'taxonomy'   => 'project_industry',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			));

			if (!empty($all_terms) && !is_wp_error($all_terms)) {
				foreach ($all_terms as $term) {
					if (!isset($terms_to_display[$term->term_id])) {
						$terms_to_display[$term->term_id] = $term;
					}
				}
			}


			if (! empty($terms_to_display)) {
				$output .= '<div class="submenu__description">';
				foreach ($terms_to_display as $term) {
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

			if ($item->object === 'project_industry' && $item->type === 'taxonomy') {
				$this->first_level_term_ids[] = (int) $item->object_id;
			}
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

function plural_days($number)
{
	$cases = array('день', 'дня', 'дней');
	$abs_number = abs($number);

	if ($abs_number % 100 > 10 && $abs_number % 100 < 20) {
		return $cases[2];
	} else {
		switch ($abs_number % 10) {
			case 1:
				return $cases[0];
			case 2:
			case 3:
			case 4:
				return $cases[1];
			default:
				return $cases[2];
		}
	}
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
		'name'                  => _x('Проекты', 'Post Type General Name'),
		'singular_name'         => _x('Проект', 'Post Type Singular Name'),
		'menu_name'             => __('Проекты'),
		'name_admin_bar'        => __('Проект'),
		'archives'              => __('Архивы Проектов'),
		'attributes'            => __('Атрибуты Проекта'),
		'parent_item_colon'     => __('Родительский Проект:'),
		'all_items'             => __('Все Проекты'),
		'add_new_item'          => __('Добавить новый Проект'),
		'add_new'               => __('Добавить новый'),
		'new_item'              => __('Новый Проект'),
		'edit_item'             => __('Редактировать Проект'),
		'update_item'           => __('Обновить Проект'),
		'view_item'             => __('Посмотреть Проект'),
		'view_items'            => __('Посмотреть Проекты'),
		'search_items'          => __('Искать Проекты'),
		'not_found'             => __('Проекты не найдены'),
		'not_found_in_trash'    => __('В корзине Проекты не найдены'),
		'featured_image'        => __('Изображение Проекта'),
		'set_featured_image'    => __('Установить изображение Проекта'),
		'remove_featured_image' => __('Удалить изображение Проекта'),
		'use_featured_image'    => __('Использовать как изображение Проекта'),
		'insert_into_item'      => __('Вставить в Проект'),
		'uploaded_to_this_item' => __('Загружено для этого Проекта'),
		'items_list'            => __('Список Проектов'),
		'items_list_navigation' => __('Навигация по списку Проектов'),
		'filter_items_list'     => __('Фильтровать список Проектов'),
	);
	$args = array(
		'label'                 => __('Проект'),
		'description'           => __('Тип записи для ваших проектов'),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
		'taxonomies'            => array('project_industry'),
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
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array(
			'slug'       => 'proekty',
			'with_front' => false,
			'pages'      => true,
			'hierarchical' => true
		),
	);
	register_post_type('project', $args);
}
add_action('init', 'create_project_post_type');


function create_project_industry_taxonomy()
{
	$labels = array(
		'name'                       => _x('Отрасли проектов', 'Taxonomy General Name'),
		'singular_name'              => _x('Отрасль проекта', 'Taxonomy Singular Name'),
		'menu_name'                  => __('Отрасли'),
		'all_items'                  => __('Все Отрасли'),
		'parent_item'                => __('Родительская Отрасль'),
		'parent_item_colon'          => __('Родительская Отрасль:'),
		'new_item_name'              => __('Новая Отрасль'),
		'add_new_item'               => __('Добавить новую Отрасль'),
		'edit_item'                  => __('Редактировать Отрасль'),
		'update_item'                => __('Обновить Отрасль'),
		'view_item'                  => __('Посмотреть Отрасль'),
		'separate_items_with_commas' => __('Разделяйте отрасли запятыми'),
		'add_or_remove_items'        => __('Добавить или удалить отрасли'),
		'choose_from_most_used'      => __('Выбрать из наиболее используемых'),
		'popular_items'              => __('Популярные Отрасли'),
		'search_items'               => __('Искать Отрасли'),
		'not_found'                  => __('Отрасли не найдены'),
		'no_terms'                   => __('Нет отраслей'),
		'items_list'                 => __('Список Отраслей'),
		'items_list_navigation'      => __('Навигация по списку Отраслей'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'query_var'                  => true,
		'publicly_queryable'         => true,
		'rewrite'                    => array(
			'slug'       => '/',
			'with_front' => false,
			'hierarchical' => false,
			'feed'       => false
		),
	);
	register_taxonomy('project_industry', array('project'), $args);
}
add_action('init', 'create_project_industry_taxonomy', 0);

function load_more_projects_ajax_handler()
{
	$current_page_requested = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 4;
	$industry_filter = isset($_POST['industry_filter']) ? sanitize_text_field($_POST['industry_filter']) : '';


	$args = array(
		'post_type'      => 'project',
		'posts_per_page' => $posts_per_page,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'paged'          => $current_page_requested,
	);

	if (!empty($industry_filter)) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'project_industry',
				'field'    => 'slug',
				'terms'    => $industry_filter,
			),
		);
	}

	$projects_query = new WP_Query($args);

	ob_start();

	if ($projects_query->have_posts()) :
		while ($projects_query->have_posts()) : $projects_query->the_post();
			$project_location = get_field('project_location');
			$delivery_contract_days = get_field('delivery_contract_days');
			$delivery_actual_days = get_field('delivery_actual_days');

			$thumbnail_id = get_post_thumbnail_id();
			$thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'full') : '';
			$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';

			if (empty($thumbnail_alt)) {
				$thumbnail_alt = get_the_title();
			}
?>
			<div class="case">
				<div class="case__main">
					<a href="<?php the_permalink(); ?>" class="case__name title-sm"><?php the_title(); ?></a>
					<?php if (!empty($project_location)) : ?>
						<div class="case__location icon-location">
							<div class="case__location-caption">Регион поставки:</div>
							<address class="case__location-address"><?php echo esc_html($project_location); ?></address>
						</div>
					<?php endif; ?>
					<p class="case__desc"><?php the_excerpt(); ?></p>
					<div class="case__footer">
						<?php
						$has_contract_time = !empty($delivery_contract_days);
						$has_actual_time = !empty($delivery_actual_days);

						if ($has_contract_time || $has_actual_time) :
						?>
							<div class="case__time">
								<div class="case__time-caption">Срок поставки договор/факт:</div>
								<div class="case__time-value title-sm">
									<?php
									if ($has_contract_time) {
										echo esc_html($delivery_contract_days) . ' ' . plural_days($delivery_contract_days);
									}
									if ($has_contract_time && $has_actual_time) {
										echo '/';
									}
									if ($has_actual_time) {
										echo esc_html($delivery_actual_days) . ' ' . plural_days($delivery_actual_days);
									}
									?>
								</div>
							</div>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="case__btn more-link icon-arrow">Подробнее о проекте</a>
					</div>
				</div>
				<a href="<?php the_permalink(); ?>" class="case__image">
					<?php if ($thumbnail_url) : ?>
						<img src="<?php echo esc_url($thumbnail_url); ?>" class="cover-image" alt="<?php echo esc_attr($thumbnail_alt); ?>">
					<?php else : ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.jpg" class="cover-image" alt="Изображение не найдено">
					<?php endif; ?>
				</a>
			</div>
<?php
		endwhile;
	else :
		echo '<p>По выбранным критериям проекты не найдены.</p>';
	endif;

	wp_reset_postdata();

	$response_html = ob_get_clean();


	wp_send_json(array(
		'html'      => $response_html,
		'has_more'  => ($projects_query->max_num_pages > $current_page_requested),
		'next_page' => $current_page_requested,
		'max_pages' => $projects_query->max_num_pages
	));

	wp_die();
}

add_action('wp_ajax_load_more_projects', 'load_more_projects_ajax_handler');
add_action('wp_ajax_nopriv_load_more_projects', 'load_more_projects_ajax_handler');

function enqueue_project_scripts()
{
	wp_enqueue_script(
		'projects-ajax-script',
		get_template_directory_uri() . '/assets/js/projects-ajax.js',
		array('jquery'),
		filemtime(get_template_directory() . '/assets/js/projects-ajax.js'),
		true
	);

	wp_localize_script(
		'projects-ajax-script',
		'project_ajax_object',
		array(
			'ajax_url'    => admin_url('admin-ajax.php'),
			'archive_url' => get_post_type_archive_link('project')
		)
	);
}
add_action('wp_enqueue_scripts', 'enqueue_project_scripts');

function fix_project_archive_paged_404($query)
{

	if (! is_admin() && $query->is_main_query() && $query->is_post_type_archive('project')) {


		if (isset($_GET['paged'])) {
			$paged = intval($_GET['paged']);
			if ($paged > 1) {
				$query->set('paged', $paged);
			} else {

				$query->set('paged', 1);
			}
		}
	}
}
add_action('pre_get_posts', 'fix_project_archive_paged_404');


function custom_project_query_vars($vars)
{
	$vars[] = 'paged';
	$vars[] = 'type';
	return $vars;
}
add_filter('query_vars', 'custom_project_query_vars');


add_theme_support('woocommerce');
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
	add_theme_support('woocommerce');
}


add_action('template_redirect', function () {
	if (is_404() && untrailingslashit($_SERVER['REQUEST_URI']) === '/katalog-category') {
		wp_redirect(home_url('/katalog/'), 301);
		exit;
	}
});
