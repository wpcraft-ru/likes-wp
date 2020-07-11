<?php

/**
 * Plugin Name: # Likes by WS
 * Description: Likes for posts 
 * Plugin URI:  https://wpcraft.ru 
 */

namespace U7;

class Likes
{

    public static $like_counts_key = 'ws_likes_counts';

    public static function init()
    {

        // add_action('ws_single_post_meta_before', [__CLASS__, 'add_like_to_meta']);
        // add_action('init', function(){
        //     // ddd(1);
        // });

        add_shortcode('likes_ws', [__CLASS__, 'render_shortcode']);

        add_filter('the_content', function ($content) {
            if (!is_singular('post')) {
                return $content;
            }

            if( has_shortcode( $content, 'likes_ws' ) ) {
                return $content;
            }

            $content = $content . apply_shortcodes('[likes_ws]');

            return $content;
        });

        add_action('rest_api_init', function () {

            register_rest_route('u7/v1', '/likes/(?P<id>\d+)', array(
                'methods' => array('GET', 'POST'),
                'callback' => [__CLASS__, 'set_likes'],
            ));
        });
    }

    public static function set_likes(\WP_REST_Request $request)
    {
        if (!$post = get_post($request['id'])) {
            return false;
        }

        $data = [];
        $data['method'] = $request->get_method();
        $data['params'] = $request->get_params();
        $data['postId'] = $request->get_param('postId');
        $data['status'] = 200;

        $likes_count = intval(get_post_meta($post->ID, self::$like_counts_key, true));

        if ($data['method'] == 'POST') {
            if ($post->ID != $request->get_param('postId')) {
                return new \WP_Error(400, 'error');
            }

            $likes_count = $likes_count + 1;

            update_post_meta($post->ID, self::$like_counts_key, $likes_count);
        }

        $data['likes_count'] = $likes_count;
        $data['post_id'] = $post->ID;

        $response = new \WP_REST_Response($data);
        return $response;
    }


    public static function render_shortcode()
    {
        if (!is_singular('post')) {
            return;
        }

        $post = get_post();

        $data = [];
        $data['post_id'] = $post->ID;
        $data['likes_count'] = get_post_meta($post->ID, self::$like_counts_key, true);
        if (empty($data['likes_count'])) {
            $data['likes_count'] = 1;
        }

        ob_start();
?>

        <button class="btn btn-blue action-like-post" data-action="u7-like" data-postid="<?= $data['post_id'] ?>">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M24 10h-10v-10h-4v10h-10v4h10v10h4v-10h10z" />
            </svg>

            <span><?= $data['likes_count'] ?></span>
        </button>

    <?php
        self::js();

        $html = ob_get_clean();


        return $html;
    }

    public static function js()
    {
    ?>
        <script>
            document.addEventListener('click', function(event) {

                var el = event.target;
                var actionClassName = 'action-like-post';

                if (el.parentNode.classList.contains(actionClassName)) {
                    el = el.parentNode;
                }

                // console.log(event.target.classList);
                // console.log(event.target.parentNode.classList);
                if (!el.classList.contains(actionClassName)) {
                    return;
                }

                var postId = el.getAttribute("data-postid");

                var url = wpApiSettings.root + 'u7/v1/likes/' + postId;
                // console.log(url);
                var fetch_options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify({
                        'postId': postId
                    })
                };

                fetch(url, fetch_options)
                    .then(response => {

                        response.json().then(data => {
                            console.log(data);
                            if (data.likes_count) {
                                // console.log(el.getElementsByTagName('span')[0]);
                                el.getElementsByTagName('span')[0].innerHTML = data.likes_count;
                            }
                        });
                    });

            });
        </script>
    <?php
    }


    /**
     * 
     * use hook $sections = apply_filters( 'ocean_blog_entry_meta', $sections );
     */
    public static function add_like_to_meta()
    {


    ?>
        <li>

        </li>

<?php


        return;
    }
}
Likes::init();
