<?php

/*
	WP-Chatblazer Settings Menu
*/

?>

<link rel="stylesheet" href="<?php echo plugins_url('/wp-chatblazer/lib/colorpicker/css/colorpicker.css') ?>" type="text/css" media="screen" />

<style type="text/css" media="screen">
	h3 {
		background: #ddd;
		padding: 8px;
		margin: 2em 0 0;
		border-top: 1px solid #fff;
		border-bottom: 1px solid #aaa;
	}
	table.form-table {
		border-collapse: fixed;
	}
	table.form-table th[colspan] {
		background: #eee;
		border-top: 1px solid #fff;
		border-bottom: 1px solid #ccc;
		margin-top: 1em;
	}
	table.form-table th h4 {
		margin: 3px 0;
	}
	table.form-table th, 
	table.form-table td {
		padding: 5px 8px;
	}
	.note {
		display:	block;
		font-size:	0.825em;
		font-style: italic;
	}
	.left {
		float:			left;
		margin-right:	10px;
	}
	.left h4 {
		margin:			0 0 0.25em;
	}
	img.thumb {
		float:			left;
		width:			80px;
	}
/*	
	img.thumb:hover {
		position:		absolute;
		width:			auto;
	}
*/
</style>


<h2><?php _e('WP-ChatBlazer Plugin Options'); ?></h2>
<p>
	<a href="javascript:void(0);" onclick="jQuery('#wp-chatblazer-instructions').toggle();"><?php _e('Usage Instructions'); ?></a>
</p>

<div id="wp-chatblazer-instructions" style="display:none; padding-left:20px; border:1px solid #CCC;">
	<p><?php _e('This plugin can be used on a <strong>Page</strong> or in a <strong>Post</strong>.'); ?></p>
	<p>
		<?php _e('<code>[WP-ChatBlazer]</code> - This shorttag embeds the Flash ChatBlazer using the settings below. In a <code>[WP-ChatBlazer]</code> shorttag, you can override the settings using the following attributes:'); ?>
	</p>
	<ul>
		<li><?php _e('<code>source_base</code> - The base URL of the Chatblazer script.'); ?></li>
		<li><?php _e('<code>site_id</code> - The Chatblazer ID for your site.'); ?></li>
		<li><?php _e('<code>config_file</code> - The filename of the configuration XML file.'); ?></li>
		<li><?php _e('<code>lang</code> - The language in which to render your Chatblazer widget.'); ?></li>
		<li><?php _e('<code>room_name</code> - The name of the chat room.'); ?></li>
		<li><?php _e('<code>room_id</code> - The ID of the chat room.'); ?></li>
		<li><?php _e('<code>skin</code> - Which skin you want to use. The options are <code>classic</code>, <code>alien</code>, <code>bluesky</code>, or blank (default)'); ?></li>
		<li><?php _e('<code>width</code> - The chat widget width, in pixels or a percentage.'); ?></li>
		<li><?php _e('<code>height</code> - The chat widget height, in pixels or a percentage.'); ?></li>
		<li><?php _e('<code>username</code> - Your Chatblazer username.'); ?></li>
		<li><?php _e('<code>password</code> - Your Chatblazer password.'); ?></li>
		<li><?php _e('<code>room_password</code> - The password for a private room.'); ?></li>
		<li><?php _e('<code>private_chat_id</code> - The ID of a private chat room.'); ?></li>
		<li><?php _e('<code>logo_path</code> - The URL to a logo you want to display in the chat widget.'); ?></li>
		<li><?php _e('<code>bg_path</code> - The URL to a background image you want to use in the chat widget.'); ?></li>
		<li><?php _e('<code>bg_color</code> - The background color of the chat widget as a 6 character hex code (i.e. f956c8).'); ?></li>
		<li><?php _e('<code>bar_color</code> - The bar color in the chat widget as a 6 character hex code (i.e. f956c8).'); ?></li>
		<li><?php _e('<code>text_color</code> - The text color in the chat widget as a 6 character hex code (i.e. f956c8).'); ?></li>
	</ul>
</div>

<form method="post" action="options.php">

	<?php 
		settings_fields('WP_Chatblazer_options'); 
		$options = get_option('WP_Chatblazer');

	?>
	
	<h3><?php _e('Site Settings'); ?></h3>

	<table class="form-table" border="0">
		<tr>
			<th scope="row"><?php _e('Source Base'); ?></th>
			<td><input type="text" size="50" name="WP_Chatblazer[SourceBase]" value="<?php echo $options['SourceBase']; ?>" maxlength="256" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Site ID'); ?></th>
			<td><input type="text" name="WP_Chatblazer[SiteID]" value="<?php echo $options['SiteID']; ?>" maxlength="8" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Main Config File Name'); ?></th>
			<td><input type="text" name="WP_Chatblazer[MainConfig]" value="<?php echo $options['MainConfig']; ?>" maxlength="24" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Language'); ?></th>
			<td><input type="text" name="WP_Chatblazer[MainLang]" value="<?php echo $options['MainLang']; ?>" /></td>
		</tr>
	</table>

	<h3><?php _e('Appearance'); ?></h3>

	<table class="form-table" border="0">

		<tr>
			<th scope="row"><?php _e('Skin'); ?></th>
			<td>
				<select name="WP_Chatblazer[MainSkin]">
					<option <?php if ($options['MainSkin'] == "") echo "selected=\"selected\""; ?> value=""><?php _e('Default'); ?></option>
					<option <?php if ($options['MainSkin'] == "classic") echo "selected=\"selected\""; ?> value="classic"><?php _e('Classic'); ?></option>
					<option <?php if ($options['MainSkin'] == "alien") echo "selected=\"selected\""; ?> value="alien"><?php _e('Alien'); ?></option>
					<option <?php if ($options['MainSkin'] == "bluesky") echo "selected=\"selected\""; ?> value="bluesky"><?php _e('Blue Sky'); ?></option>
				</select>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Logo Path'); ?></th>
			<td>
				<div class="left">
					<input type="text" size="80" name="WP_Chatblazer[LogoPath]" value="<?php echo $options['LogoPath']; ?>" maxlength="256" class="left"  />
					<span class="note"><?php _e('200&times;30 swf/png/jpg/gif'); ?></span>
				</div>
				<div class="left">
					<h4>Current logo image</h4>
					<img class="thumb" src="<?php echo $options['LogoPath']; ?>" />
				</div>
			</td>
		</tr>
		
		<tr>
			<th scope="row"><?php _e('Background Path'); ?></th>
			<td>
				<div class="left">
					<input type="text" size="80" name="WP_Chatblazer[BGpath]" value="<?php echo $options['BGpath']; ?>" maxlength="256" class="left" />
					<span class="note"><?php _e('200&times;30 swf/png/jpg/gif'); ?></span>
				</div>
				<div class="left">
					<h4>Current background image</h4>
					<img class="thumb" src="<?php echo $options['LogoPath']; ?>" />
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Background Color'); ?></th>
			<td><input type="text" name="WP_Chatblazer[BGcolor]" value="<?php echo $options['BGcolor']; ?>" maxlength="7" id="wp-chatblazer-bg-color" /></td>
		</tr>
		
		<tr>
			<th scope="row"><?php _e('Bar Color'); ?></th>
			<td><input type="text" name="WP_Chatblazer[BarColor]" value="<?php echo $options['BarColor']; ?>" maxlength="7" id="wp-chatblazer-bar-color" /></td>
		</tr>
		
		<tr>
			<th scope="row"><?php _e('Text Color'); ?></th>
			<td><input type="text" name="WP_Chatblazer[TextColor]" value="<?php echo $options['TextColor']; ?>" maxlength="7" id="wp-chatblazer-text-color" /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Width'); ?></th>
			<td>
				<input type="text" name="WP_Chatblazer[ChatWidth]" value="<?php echo $options['ChatWidth']; ?>" maxlength="5" />
				<span class="note"><?php _e('either % or pixels'); ?></span>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Height'); ?></th>
			<td>
				<input type="text" name="WP_Chatblazer[ChatHeight]" value="<?php echo $options['ChatHeight']; ?>" />
				<span class="note"><?php _e('either % or pixels'); ?></span>
			</td>
		</tr>
		
	</table>

	<h3><?php _e('Logon'); ?></h3>

	<table class="form-table" border="0">

		<tr>
			<th scope="row"><?php _e('Use Wordpress Display Name?'); ?></th>
			<td><input name="WP_Chatblazer[Autologon]" type="checkbox" value="1" <?php checked('1', $options['Autologon']); ?> /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Username'); ?></th>
			<td><input type="text" name="WP_Chatblazer[Username]" value="<?php echo $options['Username']; ?>" /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Password'); ?></th>
			<td><input type="text" name="WP_Chatblazer[Password]" value="<?php echo $options['Password']; ?>" /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Room Name'); ?></th>
			<td><input type="text" name="WP_Chatblazer[RoomName]" value="<?php echo $options['RoomName']; ?>" /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Room Password'); ?></th>
			<td><input type="text" name="WP_Chatblazer[RoomPassword]" value="<?php echo $options['RoomPassword']; ?>" /></td>
		</tr>

		<tr>
			<th scope="row"><?php _e('Room ID'); ?></th>
			<td><input type="text" name="WP_Chatblazer[RoomID]" value="<?php echo $options['RoomID']; ?>" /></td>
		</tr>
		
		<tr>
			<th scope="row"><?php _e('Private Chat ID'); ?></th>
			<td><input type="text" name="WP_Chatblazer[PrivateChatID]" value="<?php echo $options['PrivateChatID']; ?>" /></td>
		</tr>
	</table>

	<h3><?php _e('Plugin Settings'); ?></h3>
	
	<table class="form-table" border="0">
		<tr>
			<th scope="row"><?php _e('Delete settings when deactivating plugin?'); ?></th>
			<td><input name="WP_Chatblazer[deactivationCleanup]" type="checkbox" value="1" <?php checked('1', $options['deactivationCleanup']); ?> /></td>
		</tr>
	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

</form>

<script type="text/javascript" charset="utf-8">
	(function(){
		try {
			jQuery('#wp-chatblazer-bg-color, #wp-chatblazer-bar-color, #wp-chatblazer-text-color').each(function(){
				var $inp = jQuery(this);
				$inp
					.ColorPicker({
						onSubmit: function(hsb, hex, rgb, el) {
							$inp.val(hex);
							$inp.ColorPickerHide();
						},
						onBeforeShow: function () {
							$inp.ColorPickerSetColor(this.value);
						},
						onChange: function(hsb, hex, rgb) {
							$inp.val(hex);
						}
					})
					.bind('keyup', function(){
						jQuery(this).ColorPickerSetColor(this.value);
					});
			});
				
		} catch(e) {}
	})();
</script>