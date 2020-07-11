<?php 

add_filter('body_class', function($classes){
    if(is_page_template('page-blank.php')){
      $classes[] = 'content-full-width';
    }
    return $classes;
  });

  
/**
 * Добавляем h3 для названия продуктов
 */
add_action('ocean_before_archive_product_title_inner', function(){
    echo '<h3>';
});
add_action('ocean_after_archive_product_title_inner', function(){
    echo '</h3>';
});

/**
 * Отключаем jQuery Migrate
 * @see https://wpcraft.ru/2019/otklyuchaem-soobshhenie-jqmigrate-migrate-is-installed-version-1-4-1/
 */
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

/**
 * Remove header from blank page
 */
add_action('wp', function(){
  if(is_page_template('page-blank.php')){
    remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );

    remove_action( 'ocean_before_primary', 'oceanwp_display_sidebar' );
    remove_action( 'ocean_after_primary', 'oceanwp_display_sidebar' );

  }
}, 30);

/**
 * Отключаем подзаголовок для страницы каталога
 */
add_filter('ocean_post_subheading', function($subheading){

    if(is_post_type_archive('product')){
        $subheading = 'Плагины, темы, шаблоны и другие компоненты от wpcraft.ru';
    }

    return $subheading;
});

/**
 * Подменяем заголовок для страницы каталога
 */
add_filter('ocean_title', function($title){

    if(is_post_type_archive('product')){
        $title = 'Каталог решений для WordPress & WooCommerce';
    }

    return $title;
});



/**
 * Подмена h1 на strong для заголовка в шапке у постов блога
 */
// add_filter('ocean_page_header_heading', function($heading_tag){
//
//   if(is_singular('post')){
//     $heading_tag = 'strong';
//   }
//   // var_dump($heading_tag);
//
//   return $heading_tag;
// });
//
// /**
//  * Подмена заголовка постов на h1
//  */
// add_filter('ocean_blog_entries_heading', function($heading_tag){
//
//   if(is_singular('post')){
//     $heading_tag = 'h1';
//   }
//   // var_dump($heading_tag);
//
//   return $heading_tag;
// });

