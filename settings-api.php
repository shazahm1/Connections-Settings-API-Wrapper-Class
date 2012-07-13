<?php
/*
 * Plugin Name: Connections Settings API
 * Plugin URI: 
 * Description: Connections Settings API
 * Author: Steven A. Zahm
 * Author URI: http://connections-pro.com
 * Version: 0.7.3
 */

if ( ! class_exists('connectionsSettingsAPI') )
{
	class connectionsSettingsAPI
	{
		private $settings;
		private $pageHook;
		
		public function __construct()
		{
			require_once dirname( __FILE__ ) . '/class.settings-api.php';
			$this->settings = cnSettingsAPI::getInstance();
			
			add_action( 'admin_menu', array( &$this , 'loadSettingsPage' ) );
			add_action( 'plugins_loaded', array( &$this , 'init') );
			
			register_deactivation_hook( dirname(__FILE__) . '/settings-api.php', array( &$this , 'deactivate' ) );
		}
		
		public function deactivate()
		{
			// NOTE: In an actual plugin you would not want to delete the settings on deactivation.
			$this->settings->delete( 'connections_settings_api' );
		}
		
		public function init()
		{
			/*
			 * Register the settings tabs shown on the Settings admin page tabs, sections and fields.
			 * Init the registered settings.
			 * NOTE: The init method must be run after registering the tabs, sections and fields.
			 */
			add_filter( 'cn_register_settings_tabs' , array( &$this , 'tabs' ) );
			add_filter( 'cn_register_settings_sections' , array( &$this , 'sections' ) );
			add_filter( 'cn_register_settings_fields' , array( &$this , 'fields' ) );
			$this->settings->init();
		}
		
		public function loadSettingsPage()
		{
			$this->pageHook = add_options_page( 'Settings API', 'Settings API', 'manage_options', 'settings_api_test', array( &$this , 'showPage' ) );
		}
		
		public function tabs( $tabs )
		{
			// Register the core tab banks.
			$tabs[] = array( 
				'id' => 'basic' , 
				'position' => 10 ,
				'title' => __( 'Basic' , 'connections_settings_api' ) , 
				'page_hook' => $this->pageHook
			);
			
			$tabs[] = array( 
				'id' => 'other' , 
				'position' => 20 ,
				'title' => __( 'Other' , 'connections_settings_api' ) , 
				'page_hook' => $this->pageHook
			);
			
			$tabs[] = array( 
				'id' => 'advanced' , 
				'position' => 30 ,
				'title' => __( 'Advanced' , 'connections_settings_api' ) , 
				'page_hook' => $this->pageHook
			);
			
			return $tabs;
		}
		
		public function sections( $sections )
		{
			$sections[] = array(
				'tab' => 'basic' ,
				'id' => 'basic_one' , 
				'position' => 10 , 
				'title' => __( 'Test Section One' , 'connections_settings_api' ) , 
				'callback' => create_function( '', "_e( 'Test Section One Description.' , 'connections_settings_api' );" ) , 
				'page_hook' => $this->pageHook
			);
			$sections[] = array(
				'tab' => 'basic' ,
				'id' => 'basic_two' , 
				'position' => 20 , 
				'title' => __( 'Test Section Two' , 'connections_settings_api' ) , 
				'callback' => create_function( '', "_e( 'Test Section Two Description.' , 'connections_settings_api' );" ) , 
				'page_hook' => $this->pageHook
			);
			
			return $sections;
		}
		
		public function fields( $fields )
		{
			// Test Fields -- Remove before release.
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'checkbox_test',
				'position' => 5,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Checkbox', 'connections_settings_api'),
				'desc' => __('Checkbox Label.', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'checkbox',
				'default' => 1
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'textarea_test',
				'position' => 30,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Rich Text Area', 'connections_settings_api'),
				'desc' => __('This is a test of the RTE.', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'rte',
				'size' => 'large',
				'default' => '<span style="text-decoration: underline;">Default <strong>text</strong> with <em>style</em>!</span>'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'textarea_large',
				'position' => 29,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Large Text Area', 'connections_settings_api'),
				'desc' => __('Text Area', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'textarea',
				'size' => 'large',
				'default' => 'LARGE TEXT AREA'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'text_regular',
				'position' => 28,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Regular Text', 'connections_settings_api'),
				'desc' => __('Regular Text Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'text',
				'size' => 'regular',
				'default' => 'Regular'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'text_small',
				'position' => 27,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Small Text', 'connections_settings_api'),
				'desc' => __('Small Text Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'text',
				'size' => 'small',
				'default' => 'SML'
				
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'text_large',
				'position' => 29,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Large Text', 'connections_settings_api'),
				'desc' => __('Large Text Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'text',
				'size' => 'large',
				'default' => 'LARGE'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'quicktag',
				'position' => 29.5,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Quicktag Text', 'connections_settings_api'),
				'desc' => __('Quicktag Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'quicktag',
				'default' => 'Quicktag Textarea!'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'multicheck_test',
				'position' => 21,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Multi-Checkbox', 'connections_settings_api'),
				'desc' => __('Multi-Checkbox Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'multicheckbox',
				'options' => array(
					'one' => 'One',
					'two' => 'Two',
					'three' => 'Three',
					'four' => 'Four'
				),
				'default' => array( 'one' , 'three' )
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'radio_test',
				'position' => 22,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Radio', 'connections_settings_api'),
				'desc' => __('Radio Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'radio',
				'options' => array(
					'yes' => 'Yes',
					'no' => 'No'
				),
				'default' => 'yes'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'select_test',
				'position' => 23,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Select', 'connections_settings_api'),
				'desc' => __('Select Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'select',
				'options' => array(
					'one' => 'One',
					'two' => 'Two',
					'three' => 'Three',
					'four' => 'Four'
				),
				'default' => 'two'
			);
			$fields[] = array(
				'plugin_id' => 'connections_settings_api',
				'id' => 'multi_select_test',
				'position' => 24,
				'page_hook' => 'settings_page_settings_api_test',
				'tab' => 'basic',
				'section' => 'basic_one',
				'title' => __('Multi-Select', 'connections_settings_api'),
				'desc' => __('Multi-Select Label', 'connections_settings_api'),
				'help' => __(''),
				'type' => 'multiselect',
				'options' => array(
					'one' => 'One',
					'two' => 'Two',
					'three' => 'Three',
					'four' => 'Four',
					'five' => 'Five',
					'six' => 'Six',
					'seven' => 'Seven',
					'eight' => 'Eight',
					'nine' => 'Nine',
					'ten' => 'Ten'
				),
				'default' => array( 'two' , 'four' )
			);
			
			return $fields;
		}
		
		public function showPage()
		{
			echo '<div class="wrap">';
			
			$args = array(
				'page_icon' => '',
				'page_title' => 'Connections : Settings API Test Page',
				'tab_icon' => 'options-general'
				);
			
			$this->settings->form( $this->pageHook , $args );
			
			echo '</div>';
		}
	}
	
	global $connectionsSettingsAPI;
	$connectionsSettingsAPI = new connectionsSettingsAPI();
}
?>