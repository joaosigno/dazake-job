<?php
/*
  Plugin Name: WP Better Emails
  Plugin URI: http://wordpress.org/extend/plugins/wp-better-emails/
  Description: Beautify the default text/plain WP mails into fully customizable HTML emails.
  Version: 0.2.4
  Author: ArtyShow
  Author URI: http://wordpress.org/extend/plugins/wp-better-emails/
  License: GPLv2
 */

/*
  Copyright (c) 2011 Nicolas Lemoine.

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if (!class_exists('WP_Better_Emails')) {

	if (!defined('WPBE_JS_URL'))
		define('WPBE_JS_URL', plugin_dir_url(__FILE__) . 'js');
	if (!defined('WPBE_CSS_URL'))
		define('WPBE_CSS_URL', plugin_dir_url(__FILE__) . 'css');

	class WP_Better_Emails {

		var $options = array();
		var $page = '';

		/**
		 * Construct function (old way)
		 * 
		 * @since 0.2
		 */
		function WP_Better_Emails() {
			$this->__construct();
		}

		/**
		 * Construct function
		 * 
		 * @since 0.2
		 */
		function __construct() {
			global $wp_version;
			
			$this->get_options();
			
			// Front end filter
			add_filter('wp_mail_from_name', array(&$this, 'set_from_name'));
			add_filter('wp_mail_from', array($this, 'set_from_email'));
			add_filter('wp_mail_content_type', array(&$this, 'set_content_type'));

			if (!is_admin())
				return;

			// Load translations
			load_plugin_textdomain('wp-better-emails', null, basename(dirname(__FILE__)) . '/langs/');

			// Actions
			add_action('admin_init', array(&$this, 'init'));
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_action('wp_ajax_send_preview', array(&$this, 'ajax_send_preview'));
			if (version_compare($wp_version, '3.2.1', '<='))
				add_action('admin_head', array(&$this, 'load_wp_tiny_mce'));
			if( version_compare($wp_version, '3.2', '<') && version_compare($wp_version, '3.0.6', '>') )
				add_action( 'admin_print_footer_scripts', 'wp_tiny_mce_preload_dialogs');
			
			// Filters
			add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'settings_link'));
			add_filter('contextual_help', array(&$this, 'contextual_help'), 10, 3);
			add_filter('mce_external_plugins', array(&$this, 'tinymce_plugins'));
			add_filter('mce_buttons', array(&$this, 'tinymce_buttons'));
			add_filter('tiny_mce_before_init', array(&$this, 'tinymce_config'));
		}

		/**
		 * Get recorded options
		 * 
		 * @since 0.2
		 */
		function get_options() {
			$this->options = get_option('wpbe_options');
		}

		/**
		 * Set the default options
		 * 
		 * @since 0.2
		 */
		function set_options() {
			$template = '';
			@require('templates/template-1.php');
			$this->options = array(
				'from_email' => '',
				'from_name' => '',
				'template' => $template
			);
			if (get_option('wpbe_options') == null)
				add_option('wpbe_options', $this->options);
		}

		/**
		 * Init plugin options to white list our options & register our script
		 *
		 * @since 0.1
		 */
		function init() {
			register_setting('wpbe_full_options', 'wpbe_options', array(&$this, 'validate_options'));
			wp_register_script('wpbe-admin-script', WPBE_JS_URL . '/wpbe-admin-script.js', array('jquery', 'thickbox'), null, true);
			wp_register_style('wpbe-admin-style', WPBE_CSS_URL . '/wpbe-admin-style.css');
		}

		/**
		 * Settings link in the plugins page
		 *
		 * @since 0.1
		 *
		 * @param array $links Plugin links
		 * @return array Plugins links with settings added
		 */
		function settings_link($links) {
			$links[] = '<a href="options-general.php?page=wpbe_options">' . __('Settings', 'wp-better-emails') . '</a>';
			return $links;
		}

		/**
		 * Record options on plugin activation
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function install() {
			global $wp_version;
			// Prevent activation if requirements are not met
			// WP 2.8 required
			if (version_compare($wp_version, '2.8', '<=')) {
				deactivate_plugins(__FILE__);
				wp_die(__('WP Better Emails requires WordPress 2.8 or newer.', 'wp-better-emails'), __('Upgrade your Wordpress installation.', 'wp-better-emails'));
			}
			$this->set_options();
		}

		/**
		 * Option page to the built-in settings menu
		 *
		 * @since 0.1
		 */
		function admin_menu() {
			$this->page = add_options_page(__('Email settings', 'wp-better-emails'), __('WP Better Emails', 'wp-better-emails'), 'administrator', 'wpbe_options', array(&$this, 'admin_page'));
			add_action('admin_print_scripts-' . $this->page, array(&$this, 'admin_print_script'));
			add_action('admin_print_styles-' . $this->page, array(&$this, 'admin_print_style'));
		}

		/**
		 * Check if we're on the plugin page
		 * 
		 * @since 0.2
		 * @global type $page_hook
		 * @return type 
		 */
		function is_wpbe_page() {
			global $page_hook;
			if ($page_hook === $this->page)
				return true;
			return false;
		}

		/**
		 * Enqueue the script to display it on the options page
		 * Add Javascript to handle AJAX email preview
		 *
		 * @since 0.1
		 */
		function admin_print_script() {
			wp_enqueue_script('wpbe-admin-script');
			$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
			$ajax_vars = array(
				'url' => admin_url('admin-ajax.php', $protocol),
				'nonce' => wp_create_nonce('email_preview'),
				'action' => 'send_preview'
			);
			wp_localize_script('wpbe-admin-script', 'wpbe_ajax_vars', $ajax_vars);
		}

		/**
		 * Enqueue the style to display it on the options page
		 *
		 * @since 0.1
		 */
		function admin_print_style() {
			wp_enqueue_style('wpbe-admin-style');
			wp_enqueue_style('thickbox');
		}

		/**
		 * Include admin options page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function admin_page() {
			global $wp_version;
			require('wpbe-options.php');
		}

		/**
		 * Sanitize each option value
		 *
		 * @since 0.1
		 * @param array $input The options returned by the options page
		 * @return array $input Sanitized values
		 */
		function validate_options($input) {

			$from_email = strtolower($input['from_email']);

			// Checking emails
			if (!empty($from_email) && !is_email($from_email)) {
				add_settings_error('wpbe_options', 'settings_updated', __('Please enter a valid sender email address.', 'wp-better-emails'), 'error');
				$input['from_email'] = '';
			} else {
				$input['from_email'] = sanitize_email($from_email);
			}

			// Check name
			$input['from_name'] = esc_html($input['from_name']);

			if (empty($input['template']))
				add_settings_error('wpbe_options', 'settings_updated', __('Template is empty', 'wp-better-emails'));
			// Check if %content% tag is the template body
			elseif (strpos($input['template'], '%content%') === false)
				// add_settings_error('wpbe_options', 'settings_updated', __('No content tag found. The %content% tag is required in your template', 'wp-better-emails'));
			$input['template'] = $input['template'];

			return $input;
		}

		/**
		 * Send a email preview to test the template
		 *
		 * @since 0.1
		 * @param string $email
		 */
		
		function ajax_send_preview($email) {
			if (!current_user_can('manage_options'))
				die();
			check_ajax_referer('email_preview');
			// $preview_email = sanitize_email($_POST['preview_email']);
			$preview_email = $_POST['preview_email'];
			// if (empty($preview_email))
			// 	die('<div class="error"><p>' . __('Please enter an email', 'wp-better-emails') . '</p></div>');
			// if (!is_email($preview_email))
			// 	die('<div class="error"><p>' . __('Please enter a valid email', 'wp-better-emails') . '</p></div>');
			$message = __('Hey !', 'wp-better-emails');
			$message .= "\r\n\r\n";
			$message .= __('This is a sample email to test your HTML template.', 'wp-better-emails');
			$message .= "\r\n\r\n";
			$message .= __('If you\'re not skilled in HTML/CSS email coding, I strongly recommend to leave the default template as it is. It has been tested on various and popular email clients like Gmail, Yahoo Mail, Hotmail/Live, Thunderbird, Apple Mail, Outlook, and many more.', 'wp-better-emails');
			$message .= "\r\n\r\n";
			$message .= __('If you have any problems or any suggestions to improve this plugin, please let me know.', 'wp-better-emails');
			$message .= "\r\n\r\n";

			
			for($i=0; $i<count($preview_email); $i++){
				if (wp_mail($preview_email[$i], $this->options['email_subject'], $message))
					die('<div class="updated"><p>' . sprintf(__('An email has been successfully sent to clients' , 'wp-better-emails'), esc_attr($preview_email[$i]) ) . '</p></div>');
				else
					die('<div class="error"><p>' . __('An error occured while sending email. Please check your server configuration.', 'wp-better-emails') . '</p></div>');
			}
			
		}

		/**
		 * Replace variables in the template
		 *
		 * @since 0.1
		 * @param string $template Template with variables
		 * @return string Template with variables replaced
		 */
		function template_vars_replacement($template) {
			$to_replace = array(
				'blog_url'			=> get_option('siteurl'),
				'home_url'			=> get_option('home'),
				'blog_name'			=> get_option('blogname'),
				'blog_description'	=> get_option('blogdescription'),
				'admin_email'		=> get_option('admin_email'),
				'date'				=> date_i18n(get_option('date_format')),
				'time'				=> date_i18n(get_option('time_format'))
			);
			$to_replace = apply_filters('wpbe_tags', $to_replace);
			foreach ($to_replace as $tag => $var)
				$template = str_replace('%' . $tag . '%', $var, $template);
			return $template;
		}

		/**
		 * Checks the WP Better Emails options
		 *
		 * @since 0.1
		 * @return bool
		 */
		function check_template() {
			// if (strpos($this->options['template'], '%content%') === false || empty($this->options['template']))
			// 	return false;
			return true;
		}

		/**
		 * Add the HTML template to the message body.
		 * Looks for %message% into the template and replace it with the message
		 *
		 * @since 0.1
		 * @param string $body The message to templatize
		 * @return string $email The email surrounded by template
		 */
		function set_email_template($body) {
			$template = '';
			if (isset($this->options['template']) && !empty($this->options['template']))
				$template .= $this->options['template'];
			return str_replace('%content%', $body, $template);
		}

		/**
		 * Replaces sender email if set & valid
		 *
		 * @since 0.1
		 * @param string $from_email
		 * @return string 
		 */
		function set_from_email($from_email) {
			if (!empty($this->options['from_email']) && is_email($this->options['from_email']))
				return $this->options['from_email'];
			return $from_email;
		}

		/**
		 * Replaces sender name if set
		 *
		 * @since 0.1
		 * @param string $from_name
		 * @return string
		 */
		function set_from_name($from_name) {
			if (!empty($this->options['from_name']))
				return wp_specialchars_decode($this->options['from_name'], ENT_QUOTES);
			return $from_name;
		}

		/**
		 * Always set content type to HTML
		 *
		 * @since 0.1
		 * @param string $content_type
		 * @return string $content_type
		 */
		function set_content_type($content_type) {
			// Only convert if the message is text/plain and the template is ok
			if ($content_type == 'text/plain' && $this->check_template() === true) {
				add_action('phpmailer_init', array(&$this, 'send_html'));
				return $content_type = 'text/html';
			}
			return $content_type;
		}

		/**
		 * Add the email template and set it multipart
		 *
		 * @since 0.1
		 * @param object $phpmailer
		 */
		function send_html($phpmailer) {
			// Set the original plain text message
			$phpmailer->AltBody = wp_specialchars_decode($phpmailer->Body, ENT_QUOTES);
			// Clean < and > around text links in WP 3.1
			$phpmailer->Body = $this->esc_textlinks($phpmailer->Body);
			// Convert line breaks & make links clickable
			$phpmailer->Body = nl2br(make_clickable($phpmailer->Body));
			// Add template to message
			$phpmailer->Body = $this->set_email_template($phpmailer->Body);
			// Replace variables in email
			$phpmailer->Body = $this->template_vars_replacement($phpmailer->Body);
		}

		/**
		 * Replaces the < & > of the 3.1 email text links
		 *
		 * @since 0.1.2
		 * @param string $body
		 * @return string
		 */
		function esc_textlinks($body) {
			return preg_replace('#<(https?://[^*]+)>#', '$1', $body);
		}

		/**
		 * Help on template variables in contextual help
		 *
		 * @since 0.2
		 * @global string $page
		 * @param string $contextual_help
		 * @param string $screen_id
		 * @param string $screen
		 */
		function contextual_help($contextual_help, $screen_id, $screen) {
			if (!$this->is_wpbe_page())
				return $contextual_help;
			return '<p>' . __('Some dynamic tags can be included in your email template :', 'wp-better-emails') . '</p>
					<ul>
						<li>' . __('<strong>%content%</strong> : will be replaced with the message content.', 'wp-better-emails') . '<br />
						<span class="description"> ' . __('NOTE: The content tag is <strong>required</strong>, WP Better Emails will be automatically desactivated if no content tag is found.', 'wp-better-emails') . '</span></li>
						<li>' . __('<strong>%blog_url%</strong> : will be replaced with your blog URL.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%home_url%</strong> : will be replaced with your home URL.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%blog_name%</strong> : will be replaced with your blog name.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%blog_description%</strong> : will be replaced with your blog description.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%admin_email%</strong> : will be replaced with admin email.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%date%</strong> : will be replaced with current date, as formatted in <a href="options-general.php">general options</a>.', 'wp-better-emails') . '</li>
						<li>' . __('<strong>%time%</strong> : will be replaced with current time, as formatted in <a href="options-general.php">general options</a>.', 'wp-better-emails') . '</li>
					</ul>';
		}

		/**
		 * TinyMCE plugins
		 *
		 * Editing HTML emails requires some more plugins from TinyMCE:
		 *  - fullpage to handle html, meta, body tags
		 *  - codemirror for editing source
		 * 
		 * @since 0.2
		 * @param array $external_plugins
		 * @return array
		 */
		function tinymce_plugins($external_plugins) {
			global $wp_version;
			if (!$this->is_wpbe_page())
				return $external_plugins;

			$fullpage = array();
			if (version_compare($wp_version, '3.2', '<'))
				$fullpage = array('fullpage' => plugins_url('tinymce-plugins/3.3.x/fullpage/editor_plugin.js', __FILE__));
			else
				$fullpage = array('fullpage' => plugins_url('tinymce-plugins/3.4.x/fullpage/editor_plugin.js', __FILE__));

			$cmseditor = array('cmseditor' => plugins_url('tinymce-plugins/cmseditor/editor_plugin.js', __FILE__));
			$external_plugins = $external_plugins + $fullpage + $cmseditor;
			return $external_plugins;
		}

		/**
		 * Button to the TinyMCE toolbar
		 * 
		 * @since 0.2
		 * @global string $page
		 * @global type $page_hook
		 * @param type $buttons
		 * @return type 
		 */
		function tinymce_buttons($buttons) {
			if ($this->is_wpbe_page())
				array_push($buttons, 'cmseditor');
			return $buttons;
		}

		/**
		 * Prevent TinyMCE from removing line breaks
		 * 
		 * @param array $init
		 * @return boolean 
		 */
		function tinymce_config($init) {
			if (!$this->is_wpbe_page())
				return $init;
			$init['remove_linebreaks'] = false;
			$init['content_css'] = ''; // WP =< 3.0
			if ( isset($init['extended_valid_elements']) )
				$init['extended_valid_elements'] = $init['extended_valid_elements'] . ',td[*]';
			return $init;
		}

		/**
		 * Load WP tinyMCE editor
		 * 
		 * @since 0.2
		 */
		function load_wp_tiny_mce() {
			if (!$this->is_wpbe_page())
				return;
			$settings = array(
				'editor_selector' => 'wpbe_template',
				'height' => '400'
			);
			wp_tiny_mce(false, $settings);
		}

		/**
		 * Print WP TinyMCE editor to edit template
		 * 
		 * @since 0.2
		 * @global string $wp_version
		 */
		function template_editor() {
			global $wp_version;

			if (version_compare($wp_version, '3.2.1', '<=')) {
				?>
				<textarea id="wpbe_template" class="wpbe_template" name="wpbe_options[template]" cols="80" rows="10"><?php echo $this->options['template']; ?></textarea>
				<?php
			} else {
				// WP >= 3.3
				$settings = array('wpautop' => false, 'editor_class' => 'wpbe_template', 'quicktags' => false);
				wp_editor($this->options['template'], 'wpbe_options[template]', $settings);
			}
		}

	}

}

if (class_exists('WP_Better_Emails')) {
	$wp_better_emails = new WP_Better_Emails();
	register_activation_hook(__FILE__, array($wp_better_emails, 'install'));
}
?>