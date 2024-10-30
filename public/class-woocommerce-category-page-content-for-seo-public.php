<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    Woocommerce_Category_Page_Content_For_Seo
 * @subpackage Woocommerce_Category_Page_Content_For_Seo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Category_Page_Content_For_Seo
 * @subpackage Woocommerce_Category_Page_Content_For_Seo/public
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */
class CPCFW_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Category_Page_Content_For_Seo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Category_Page_Content_For_Seo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-category-page-content-for-seo-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Category_Page_Content_For_Seo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Category_Page_Content_For_Seo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-category-page-content-for-seo-public.js', array('jquery'), $this->version, false);

	}

	public function cpcfw_content_showing_into_category_page()
	{
		if (is_product_category())
		{
			$category_id = get_queried_object_id();
			$args = array(
				'post_type' => 'category_content',
				'posts_per_page' => -1,
			);

			$category_content = new WP_Query($args);

			if ($category_content->have_posts())
			{
				while ($category_content->have_posts())
				{
					$category_content->the_post();
					$post_id = get_the_ID();

					$product_category = get_post_meta($post_id, '_product_category', true);
					$content_visibility = get_post_meta($post_id, '_content_visibility', true);
					$content = get_post_meta($post_id, '_content_setting', true);

					if ($category_id == $product_category)
					{

						if ($content_visibility == "show")
						{
							// Sanitize and escape the output
							$category_content = $content;
							echo "<div class='category_content_div'> " . wp_kses_post($category_content) . "</div>";
						}
						break;
					}

				}

				wp_reset_postdata();
			}
		}



	}


}
