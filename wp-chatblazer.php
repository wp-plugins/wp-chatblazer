<?php

/*************************

Plugin Name: WP-Chatblazer
Plugin URI: http://www.wp-chatblazer.com
Description: Installs a Chatblazer chat application in a Wordpress site
Version: 1.2
Date:  June 25, 2012
Author: Phyllis Erck
Author URI: http://www.phylliserck.net
License: GPL2

*************************/



/*  Copyright 2012  Phyllis Erck  (email : email@phylliserck.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Release History :
 * 1.0:       Initial release
 * 1.1:		  Added description, tags, and link in settings page to chatblazer	
*/

/*****************

Set up initial options

******************/

function WP_Chatblazer_inital_options() {
	if ( ! is_admin() ) {
		return;
	}
	$initial_options = array(
		'SourceBase'			=> 'http://host4.chatblazer.com',
		'SiteID'				=> '',
		'MainConfig'			=> 'config.xml',
		'MainLang'				=> '',
		'MainSkin'				=> '',
		'LogoPath'				=> 'http' . (is_ssl() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/wp-chatblazer/background.png',
		'BGpath'				=> 'http' . (is_ssl() ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/wp-chatblazer/background.png',
		'BGcolor'				=> 'FFCC33',
		'BarColor'				=> 'FFCC33',
		'TextColor'				=> 'FFCC33',
		'ChatWidth'				=> '100%',
		'ChatHeight'			=> '400',
		'Autologon'				=> 1,
		'Username'				=> '',
		'Password'				=> '',
		'RoomName'				=> '',
		'RoomPassword'			=> '',
		'RoomID'				=> '1038',
		'PrivateChatID'			=> '',
		'deactivationCleanup'	=> 1
	);
	
	add_option('WP_Chatblazer', $initial_options);
}

add_action('init', 'WP_Chatblazer_inital_options');


/*****************

Set up deactivation cleanup

******************/

function WP_Chatblazer_deactivate() {
	$options = get_option('WP_Chatblazer');

	if ($options['deactivationCleanup']) {
		delete_option('WP_Chatblazer');
	}
}

register_deactivation_hook( __FILE__, 'WP_Chatblazer_deactivate');


/*****************

WP_Chatblazer Shortcode function

******************/

function WP_Chatblazer($atts, $content = null) {

	$options = get_option('WP_Chatblazer');
	
	$availableSkins = array('','classic','alien','bluesky');
	
	// Read the shortcode attributes
	extract(
		shortcode_atts( array(
			'source_base'		=> $options['SourceBase'],
			'site_id'			=> $options['SiteID'],
			'config_file'		=> $options['MainConfig'],
			'lang'				=> $options['MainLang'],
			'room_name' 		=> $options['RoomName'],
			'room_id' 			=> $options['RoomID'],
			'skin'				=> $options['MainSkin'],
			'width'				=> $options['ChatWidth'],
			'height'			=> $options['ChatHeight'],
			'username'			=> ( $options['Autologon'] ) ? get_userdata(get_current_user_id())->display_name : $options['Username'], // Use currently logged in user is Autologon is checked
			'password'			=> $options['Password'],
			'room_password'		=> $options['RoomPassword'],
			'private_chat_id'	=> $options['PrivateChatID'],
			'logo_path'			=> $options['LogoPath'],
			'bg_path'			=> $options['BGpath'],
			'bg_color'			=> $options['BGcolor'],
			'bar_color'			=> $options['Barcolor'],
			'text_color'		=> $options['Textcolor']
		), $atts )
	);

	// Ensure there's a trailing slash on the source base
	if ( ! preg_match('/\/$/', $source_base) ) {
		$source_base .= '/';
	}
	
	// Make sure the skin name passed in the shortcode is valid.
	if ( ! in_array($skin, $availableSkins) ) {
		$skin = $options['MainSkin'];
	}
	
	// Ensure color codes have a hash prepended to them
	$bg_color	= WP_Chatblazer_hash_hex_code($bg_color);
	$bar_color	= WP_Chatblazer_hash_hex_code($bar_color);
	$text_color	= WP_Chatblazer_hash_hex_code($text_color);

    
	$out = array();	
    
	$out[]	= '<script type="text/javascript" charset="utf-8">';
	$out[]	= '	(function(){';	
	$out[]	= '		var	mainSkin	= "' . $skin  . '",';
	$out[]	= '			flashPath	= "ChatBlazer8" + ( mainSkin !== "" ? "_" + mainSkin : "") + ".swf?cb=1",';
	$out[]	= '			addParam	= function(pname, pval) {';
	$out[]	= '				if (typeof pval !== "undefined" && pval) {';
	$out[]	= '					flashPath = flashPath + "&" + pname + "=" + encodeURIComponent(pval);';
	$out[]	= '				}';
	$out[]	= '			};';
	$out[]	= '';
	$out[]	= '		addParam("lang", "' . $lang . '");';
	$out[]	= '		addParam("config", "' . $site_id. '/' . $config_file . '");';
	$out[]	= '		addParam("skin", mainSkin);';
	$out[]	= '		addParam("username", "' . $username . '");';
	$out[]	= '		addParam("password", "' . $password . '");';
	$out[]	= '		addParam("roompass", "' . $room_password . '");';
	$out[]	= '		addParam("roomid", "' . $room_id . '");';
	$out[]	= '		addParam("roomname", "' . $room_name . '");';
	$out[]	= '		addParam("privatechatcid", "' . $private_chat_id . '");';
	$out[]	= '		addParam("logo", "' . $logo_path . '");';
	$out[]	= '		addParam("bgpath", "' . $bg_path . '");';
	$out[]	= '		addParam("bgcolor", "' . $bg_color . '");';
	$out[]	= '		addParam("barcolor", "' . $bar_color . '");';
	$out[]	= '		addParam("textcolor", "' . $text_color . '");';
	$out[]	= '		if (navigator.appVersion.indexOf("MSIE") !== -1) {';
	$out[]	= '			addParam("isIE","1");';
	$out[]	= '		}';
	$out[]	= '		embedFlash(flashPath, "' . $width . '", "' . $height . '", "cb8", "' . $source_base . '", "#000000");';
	$out[]	= '	})();';
	$out[]	= '</script>';
	
	return join("\n", $out);
}

function WP_Chatblazer_hash_hex_code($code) {
	if ( preg_match('/^#/', $code ) ) {
		return $code;
	} else {
		return "#$code";
	}
}

add_shortcode( 'WP-ChatBlazer', 'WP_ChatBlazer' );

/*****************

WP_Chatblazer Header Javascript

******************/

function WP_Chatblazer_header_js() {
	if ( is_admin() ) {
		
		// Admin (color picker)
		wp_register_script( 'jquery-colorpicker', plugins_url('/wp-chatblazer/lib/colorpicker/js/colorpicker.js'), array('jquery') );
	    wp_enqueue_script( 'jquery-colorpicker' );
	
	} else {
		
		// Front end
		$options 		= get_option('WP_Chatblazer');	
		$source_base 	= $options['SourceBase'];

		// Ensure there's a trailing slash on the source base
		if ( ! preg_match('/\/$/', $source_base) ) {
			$source_base .= '/';
		}

	    wp_register_script( 'chatblazer', $source_base.'chatblazer.js');
	    wp_enqueue_script( 'chatblazer' );
	}
}

add_action('init', 'WP_Chatblazer_header_js');


/*****************

WP_Chatblazer Plugin Options Menu

******************/



add_action('admin_init', 'WP_Chatblazer_options_init' );
add_action('admin_menu', 'WP_Chatblazer_options_add_page');



// Init plugin options to white list our options

function WP_Chatblazer_options_init(){
	register_setting( 'WP_Chatblazer_options', 'WP_Chatblazer', 'WP_Chatblazer_options_validate' );
}



// Add Administrator Options Setting Menu page

function WP_Chatblazer_options_add_page() {
	add_options_page('WP-ChatBlazer plugin Options', 'WP-ChatBlazer', 'manage_options', 'wp-chatblazer', 'WP_Chatblazer_options_do_page');
}



// Draw the menu page itself

function WP_Chatblazer_options_do_page() {
	include ( ABSPATH . 'wp-content/plugins/wp-chatblazer/chatblazer_settings_menu.php' );
}



// Sanitize and validate input. Accepts an array, return a sanitized array.

function WP_Chatblazer_options_validate($input) {

	// value is either 0 or 1

	$input['Autologon'] 	  = ( $input['Autologon'] == 1 ? 1 : 0 );

	// Say our second option must be safe text with no HTML tags

	$input['SourceBase']    = wp_filter_nohtml_kses($input['SourceBase']);
	$input['SiteID']        = wp_filter_nohtml_kses($input['SiteID']);
	$input['TagName']       = wp_filter_nohtml_kses($input['TagName']);
	$input['MainConfig']    = wp_filter_nohtml_kses($input['MainConfig']);
	$input['MainLang']      = wp_filter_nohtml_kses($input['MainLang']);
	$input['Username']      = wp_filter_nohtml_kses($input['Username']);
	$input['Password']      = wp_filter_nohtml_kses($input['Password']);
	$input['RoomPassword']  = wp_filter_nohtml_kses($input['RoomPassword']);
	$input['RoomID']        = wp_filter_nohtml_kses($input['RoomID']);
	$input['PrivateChatID'] = wp_filter_nohtml_kses($input['PrivateChatID']);
	$input['LogoPath']      = wp_filter_nohtml_kses($input['LogoPath']);
	$input['BGpath']        = wp_filter_nohtml_kses($input['BGpath']);
	$input['BGcolor']       = wp_filter_nohtml_kses($input['BGcolor']);
	$input['BarColor']      = wp_filter_nohtml_kses($input['BarColor']);
	$input['TextColor']     = wp_filter_nohtml_kses($input['TextColor']);
	$input['ChatWidth']     = wp_filter_nohtml_kses($input['ChatWidth']);
	$input['ChatWidth']     = wp_filter_nohtml_kses($input['ChatWidth']);

	return $input;

}

