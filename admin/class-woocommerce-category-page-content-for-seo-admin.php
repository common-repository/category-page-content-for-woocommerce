<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://shehab24.github.io/portfolio/
 * @since      1.0.0
 *
 * @package    CPCFWClass
 * @subpackage Woocommerce_Category_Page_Content_For_Seo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Category_Page_Content_For_Seo
 * @subpackage Woocommerce_Category_Page_Content_For_Seo/admin
 * @author     Shehab Mahamud <mdshehab204@gmail.com>
 */

class CPCFW_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CPCFWLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CPCFWLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-category-page-content-for-seo-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CPCFWLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CPCFWLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-category-page-content-for-seo-admin.js', array('jquery'), $this->version, false);

	}

	public function cpcfw_admin_menu_add()
	{
		/**
		 * Register a custom post type called "book".
		 *
		 * @see get_post_type_labels() for label keys.
		 */

		$labels = array(
			'name' => _x('Category Content', 'Post type general name', ' category-page-content-for-woocommerce'),
			'singular_name' => _x('Category Content', 'Post type singular name', ' category-page-content-for-woocommerce'),
			'menu_name' => _x('Category Contents', 'Admin Menu text', 'category-page-content-for-woocommerce'),
			'name_admin_bar' => _x('Category Content', 'Add New on Toolbar', 'category-page-content-for-woocommerce'),
			'add_new' => __('Add New', 'category-page-content-for-woocommerce'),
			'all_items' => __('All Content', 'category-page-content-for-woocommerce'),
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'category-page-content'),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => null,
			'menu_icon' => 'dashicons-category',
			'supports' => array('title'),
		);

		register_post_type('category_content', $args);




	}

	public function cpcfw_admin_submenu_add()
	{
		add_submenu_page("edit.php?post_type=category_content", "Settings", "Settings", "manage_options", "category-content-setting", array($this, "cpcfw_category_content_setting_callback"));
	}

	public function cpcfw_category_content_setting_callback()
	{

		if ($_SERVER["REQUEST_METHOD"] === "POST")
		{
			// Nonce verification
			if (!isset($_POST['cpcfw_content_setting_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cpcfw_content_setting_nonce'])), 'cpcfw_content_setting_nonce'))
			{
				// Nonce verification failed, handle error
				echo 'Nonce verification failed!';
				return;
			}

			// Validate and sanitize input
			$valid_locations = array(
				'woocommerce_before_shop_loop',
				'woocommerce_after_shop_loop',
				'woocommerce_before_main_content',
				'woocommerce_after_main_content'
			);
			$displayLocation = isset($_POST['display_location']) && in_array($_POST['display_location'], $valid_locations) ? sanitize_text_field($_POST['display_location']) : '';

			// Update option
			update_option("cpcfw_displayLocation", $displayLocation);
		}

		// Retrieve current display location option
		$currentDisplayLocation = get_option("cpcfw_displayLocation", "");
		?>
		<div class="wrap">
			<h1>Category Content Settings Page</h1>
			<form method="post" class="content_setting_form">
				<?php wp_nonce_field('cpcfw_content_setting_nonce', 'cpcfw_content_setting_nonce'); ?>
				<label for="display_location">Display Location</label>
				<select name="display_location" id="display_location">
					<option <?php selected($currentDisplayLocation, "woocommerce_before_shop_loop"); ?>
						value="woocommerce_before_shop_loop">Before Product Section</option>
					<option <?php selected($currentDisplayLocation, "woocommerce_after_shop_loop"); ?>
						value="woocommerce_after_shop_loop">After Product Section</option>
					<option <?php selected($currentDisplayLocation, "woocommerce_before_main_content"); ?>
						value="woocommerce_before_main_content">Before Main Content</option>
					<option <?php selected($currentDisplayLocation, "woocommerce_after_main_content"); ?>
						value="woocommerce_after_main_content">After Main Content</option>
				</select>
				<?php submit_button(); ?>
			</form>
			<a href="https://www.buymeacoffee.com/shehab24"><img
					src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'images/buy-coffee.gif'); ?>"></a>
		</div>
		<?php
	}

	public function cpcfw_add_content_meta_box()
	{
		add_meta_box(
			'content_for_woo_meta_box',
			'Category content Options',
			array($this, 'content_for_woo_meta_box_callback'),
			'category_content',
			'normal',
			'default'
		);
	}

	public function content_for_woo_meta_box_callback($post)
	{
		// Retrieve existing meta data
		$product_category = get_post_meta($post->ID, '_product_category', true);
		$content_visibility = get_post_meta($post->ID, '_content_visibility', true);

		$product_categories = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'hide_empty' => true,
			)
		);
		?>
		<div class="category_content_div">
			<label for="product_category">Product Category:</label>
			<div class="content_select_box">
				<select name="product_category" id="product_category">
					<option value="">Select a Category</option>
					<?php
					if (!empty($product_categories) && !is_wp_error($product_categories))
					{
						foreach ($product_categories as $category)
						{
							echo '<option value="' . esc_attr($category->term_id) . '"' . selected($category->term_id, $product_category, false) . '>' . esc_html($category->name) . '</option>';
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="category_content_div">
			<label for="content_visibility">Content Visibility:</label>
			<div class="content_select_box">
				<select name="content_visibility" id="content_visibility">
					<option value="show" <?php selected($content_visibility, 'show'); ?>>Show</option>
					<option value="hide" <?php selected($content_visibility, 'hide'); ?>>Hide</option>
				</select>
			</div>
		</div>
		<div class="category_content_div">
			<label for="content_setting">Content :</label>
			<div class="custom-editor-container">
				<?php
				$content = get_post_meta($post->ID, '_content_setting', true);

				// Define editor ID
				$editor_id = 'content_setting';

				// Define editor settings
				$settings = array(
					'textarea_rows' => 20, // Number of rows in the editor
				);

				// Output the editor
				wp_editor($content, $editor_id, $settings);
				?>
			</div>
		</div>

		<?php
		wp_nonce_field('save_post_content_field_meta', 'save_post_content_field_meta');
	}


	public function cpcfw_save_post_meta_box_callback($post_id)
	{
		// Check if nonce is set and valid
		if (isset($_POST['save_post_content_field_meta']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['save_post_content_field_meta'])), 'save_post_content_field_meta'))
		{
			if (isset($_POST['product_category']))
			{
				update_post_meta($post_id, '_product_category', esc_attr(sanitize_text_field($_POST['product_category'])));
			}
			if (isset($_POST['content_visibility']))
			{
				update_post_meta($post_id, '_content_visibility', esc_attr(sanitize_text_field($_POST['content_visibility'])));
			}
			if (isset($_POST['content_setting']))
			{
				$editor_content = wp_kses_post($_POST['content_setting']);

				// Update or save the post meta with the editor content
				update_post_meta($post_id, '_content_setting', $editor_content);
			}
		}
	}
}
