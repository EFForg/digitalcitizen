<?php
/**
 * @package Facebook Open Graph Meta Tags for WordPress
 * @subpackage Settings Page
 *
 * @since 0.1
 * @author Webdados
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		
	//First we save!
	if ( isset($_POST['action']) ) {
		if (trim($_POST['action'])=='save') {
			//This should also use the $wonderm00n_open_graph_plugin_settings array, but because of intval and trim we still can't
			$usersettings['fb_app_id_show']= 					intval(wonderm00n_open_graph_post('fb_app_id_show'));
			$usersettings['fb_app_id']= 						trim(wonderm00n_open_graph_post('fb_app_id'));
			$usersettings['fb_admin_id_show']= 					intval(wonderm00n_open_graph_post('fb_admin_id_show'));
			$usersettings['fb_admin_id']= 						trim(wonderm00n_open_graph_post('fb_admin_id'));
			$usersettings['fb_locale_show']= 					intval(wonderm00n_open_graph_post('fb_locale_show'));
			$usersettings['fb_locale']= 						trim(wonderm00n_open_graph_post('fb_locale'));
			$usersettings['fb_sitename_show']= 					intval(wonderm00n_open_graph_post('fb_sitename_show'));
			$usersettings['fb_title_show']= 					intval(wonderm00n_open_graph_post('fb_title_show'));
			$usersettings['fb_title_show_schema']= 				intval(wonderm00n_open_graph_post('fb_title_show_schema'));
			$usersettings['fb_url_show']= 						intval(wonderm00n_open_graph_post('fb_url_show'));
			$usersettings['fb_url_canonical']= 					intval(wonderm00n_open_graph_post('fb_url_canonical'));
			$usersettings['fb_url_add_trailing']= 				intval(wonderm00n_open_graph_post('fb_url_add_trailing'));
			$usersettings['fb_type_show']= 						intval(wonderm00n_open_graph_post('fb_type_show'));
			$usersettings['fb_type_homepage']= 					trim(wonderm00n_open_graph_post('fb_type_homepage'));
			$usersettings['fb_desc_show']= 						intval(wonderm00n_open_graph_post('fb_desc_show'));
			$usersettings['fb_desc_show_meta']= 				intval(wonderm00n_open_graph_post('fb_desc_show_meta'));
			$usersettings['fb_desc_show_schema']= 				intval(wonderm00n_open_graph_post('fb_desc_show_schema'));
			$usersettings['fb_desc_chars']= 					intval(wonderm00n_open_graph_post('fb_desc_chars'));
			$usersettings['fb_desc_homepage']= 					trim(wonderm00n_open_graph_post('fb_desc_homepage'));
			$usersettings['fb_desc_homepage_customtext']= 		trim(wonderm00n_open_graph_post('fb_desc_homepage_customtext'));
			$usersettings['fb_image_show']= 					intval(wonderm00n_open_graph_post('fb_image_show'));
			$usersettings['fb_image_show_schema']= 				intval(wonderm00n_open_graph_post('fb_image_show_schema'));
			$usersettings['fb_image']= 							trim(wonderm00n_open_graph_post('fb_image'));
			$usersettings['fb_image_rss']= 						intval(wonderm00n_open_graph_post('fb_image_rss'));
			$usersettings['fb_image_use_specific']= 			intval(wonderm00n_open_graph_post('fb_image_use_specific'));
			$usersettings['fb_image_use_featured']= 			intval(wonderm00n_open_graph_post('fb_image_use_featured'));
			$usersettings['fb_image_use_content']= 				intval(wonderm00n_open_graph_post('fb_image_use_content'));
			$usersettings['fb_image_use_media']= 				intval(wonderm00n_open_graph_post('fb_image_use_media'));
			$usersettings['fb_image_use_default']= 				intval(wonderm00n_open_graph_post('fb_image_use_default'));
			$usersettings['fb_show_wpseoyoast']= 				intval(wonderm00n_open_graph_post('fb_show_wpseoyoast'));
			$usersettings['fb_show_subheading']= 				intval(wonderm00n_open_graph_post('fb_show_subheading'));
			$usersettings['fb_show_businessdirectoryplugin']= 	intval(wonderm00n_open_graph_post('fb_show_businessdirectoryplugin'));
			//Update
			update_option('webdados_fb_open_graph_settings', $usersettings);
		}
	}
	
	//Load the settings
	extract(wonderm00n_open_graph_load_settings());

	?>
	<div class="wrap">
		
	<?php screen_icon(); ?>
  	<h2>Facebook Open Graph Meta Tags for WordPress (<?php echo $wonderm00n_open_graph_plugin_version; ?>)</h2>
  	<br class="clear"/>
  	<p><?php _e('Please set some default values and which tags should, or should not, be included. It may be necessary to exclude some tags if other plugins are already including them.', 'wd-fb-og'); ?></p>
  	
  	<?php
  	settings_fields('wonderm00n_open_graph');
  	?>
  	
  	<div class="postbox-container" style="width: 69%;">
  		<div id="poststuff">
  			<form name="form1" method="post">
	  			<div id="wonderm00n_open_graph-settings" class="postbox">
	  				<h3 id="settings"><?php _e('Settings'); ?></h3>
	  				<div class="inside">
	  					<table width="100%" class="form-table">
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Facebook Platform App ID (fb:app_id) tag?', 'wd-fb-og'); ?></th>
									<td>
										<input type="checkbox" name="fb_app_id_show" id="fb_app_id_show" value="1" <?php echo (intval($fb_app_id_show)==1 ? ' checked="checked"' : ''); ?> onclick="showAppidOptions();"/>
									</td>
								</tr>
								<tr class="fb_app_id_options">
									<th scope="row" nowrap="nowrap"><?php _e('Facebook Platform App ID', 'wd-fb-og'); ?>:</th>
									<td>
										<input type="text" name="fb_app_id" id="fb_app_id" size="30" value="<?php echo $fb_app_id; ?>"/>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Facebook Admin(s) ID (fb:admins) tag?', 'wd-fb-og'); ?></th>
									<td>
										<input type="checkbox" name="fb_admin_id_show" id="fb_admin_id_show" value="1" <?php echo (intval($fb_admin_id_show)==1 ? ' checked="checked"' : ''); ?> onclick="showAdminOptions();"/>
									</td>
								</tr>
								<tr class="fb_admin_id_options">
									<th scope="row" nowrap="nowrap"><?php _e('Facebook Admin(s) ID', 'wd-fb-og'); ?>:</th>
									<td>
										<input type="text" name="fb_admin_id" id="fb_admin_id" size="30" value="<?php echo $fb_admin_id; ?>"/>
										<br/>
										<?php _e('Comma separated if more than one', 'wd-fb-og'); ?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include locale (fb:locale) tag?', 'wd-fb-og'); ?></th>
									<td>
										<input type="checkbox" name="fb_locale_show" id="fb_locale_show" value="1" <?php echo (intval($fb_locale_show)==1 ? ' checked="checked"' : ''); ?> onclick="showLocaleOptions();"/>
									</td>
								</tr>
								<tr class="fb_locale_options">
									<th scope="row" nowrap="nowrap"><?php _e('Locale', 'wd-fb-og'); ?>:</th>
									<td>
										<select name="fb_locale" id="fb_locale">
											<option value=""<?php if (trim($fb_locale)=='') echo ' selected="selected"'; ?>><?php _e('WordPress current locale/language', 'wd-fb-og'); ?> (<?php echo get_locale(); ?>)&nbsp;</option>
											<?php
												$listLocales=false;
												$loadedOnline=false;
												$loadedOffline=false;
												//Online
												if (!empty($_GET['localeOnline'])) {
													if (intval($_GET['localeOnline'])==1) {
														if ($ch = curl_init('http://www.facebook.com/translations/FacebookLocales.xml')) {
															curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
															$fb_locales=curl_exec($ch);
															if (curl_errno($ch)) {
																//echo curl_error($ch);
															} else {
																$info = curl_getinfo($ch);
																if (intval($info['http_code'])==200) {
																	//Save the file locally
																	$fh = fopen(ABSPATH . 'wp-content/plugins/wonderm00ns-simple-facebook-open-graph-tags/includes/FacebookLocales.xml', 'w') or die("Can't open file");
																	fwrite($fh, $fb_locales);
																	fclose($fh);
																	$listLocales=true;
																	$loadedOnline=true;
																}
															}
															curl_close($ch);
														}
													}
												}
												//Offline
												if (!$listLocales) {
													if ($fb_locales=file_get_contents(ABSPATH . 'wp-content/plugins/wonderm00ns-simple-facebook-open-graph-tags/includes/FacebookLocales.xml')) {
														$listLocales=true;
														$loadedOffline=true;
													}
												}
												//OK
												if ($listLocales) {
													$xml=simplexml_load_string($fb_locales);
													$json = json_encode($xml);
													$locales = json_decode($json,TRUE);
													if (is_array($locales['locale'])) {
														foreach ($locales['locale'] as $locale) {
															?><option value="<?php echo $locale['codes']['code']['standard']['representation']; ?>"<?php if (trim($fb_locale)==trim($locale['codes']['code']['standard']['representation'])) echo ' selected="selected"'; ?>><?php echo $locale['englishName']; ?> (<?php echo $locale['codes']['code']['standard']['representation']; ?>)</option><?php
														}
													}
												}
											?>
										</select>
										<br/>
										<?php
										if ($loadedOnline) {
											_e('List loaded from Facebook (online)', 'wd-fb-og');
										} else {
											if ($loadedOffline) {
												_e('List loaded from local cache (offline)', 'wd-fb-og'); ?> - <a href="?page=wonderm00n-open-graph.php&amp;localeOnline=1" onClick="return(confirm('<?php _e('You\\\'l lose any changes you haven\\\'t saved. Are you sure?', 'wd-fb-og'); ?>'));"><?php _e('Reload from Facebook', 'wd-fb-og'); ?></a><?php
											} else {
												_e('List not loaded', 'wd-fb-og');
											}
										}
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Site Name (og:site_name) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_sitename_show" id="fb_sitename_show" value="1" <?php echo (intval($fb_sitename_show)==1 ? ' checked="checked"' : ''); ?>/>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Post/Page title (og:title) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_title_show" id="fb_title_show" value="1" <?php echo (intval($fb_title_show)==1 ? ' checked="checked"' : ''); ?> onclick="showTitleOptions();"/>
									</td>
								</tr>
								<tr class="fb_title_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also include Schema.org "itemprop" Name tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_title_show_schema" id="fb_title_show_schema" value="1" <?php echo (intval($fb_title_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="name" content="..."/&gt;</i>
										<br/>
										<?php _e('Recommended for Google+ sharing purposes if no other plugin is setting it already', 'wd-fb-og');?>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include URL (og:url) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_url_show" id="fb_url_show" value="1" <?php echo (intval($fb_url_show)==1 ? ' checked="checked"' : ''); ?> onclick="showUrlOptions();"/>
									</td>
								</tr>
								<tr class="fb_url_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also set Canonical URL', 'wd-fb-og');?>:</th>
									<td>
										<input type="checkbox" name="fb_url_canonical" id="fb_url_canonical" value="1" <?php echo (intval($fb_url_canonical)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;link rel="canonical" href="..."/&gt;</i>
									</td>
								</tr>
								<tr class="fb_url_options">
									<th scope="row" nowrap="nowrap"><?php _e('Add trailing slash at the end', 'wd-fb-og');?>:</th>
									<td>
										<input type="checkbox" name="fb_url_add_trailing" id="fb_url_add_trailing" value="1" <?php echo (intval($fb_url_add_trailing)==1 ? ' checked="checked"' : ''); ?> onclick="showUrlTrail();"/>
										<br/>
										<?php _e('On the homepage will be', 'wd-fb-og');?>: <i><?php echo get_option('siteurl'); ?><span id="fb_url_add_trailing_example">/</span></i>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Type (og:type) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_type_show" id="fb_type_show" value="1" <?php echo (intval($fb_type_show)==1 ? ' checked="checked"' : ''); ?> onclick="showTypeOptions();"/>
										<br/>
										<?php printf( __('Will be "%1$s" for posts and pages and "%2$s" or "%3$s"; for the homepage', 'wd-fb-og'), 'article', 'website', 'blog' );?>
									</td>
								</tr>
								<tr class="fb_type_options">
									<th scope="row" nowrap="nowrap"><?php _e('Homepage type', 'wd-fb-og');?>:</th>
									<td>
										<?php _e('Use', 'wd-fb-og');?>
										<select name="fb_type_homepage" id="fb_type_homepage">
											<option value="website"<?php if (trim($fb_type_homepage)=='' || trim($fb_type_homepage)=='website') echo ' selected="selected"'; ?>>website&nbsp;</option>
											<option value="blog"<?php if (trim($fb_type_homepage)=='blog') echo ' selected="selected"'; ?>>blog&nbsp;</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Description (og:description) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_desc_show" id="fb_desc_show" value="1" <?php echo (intval($fb_desc_show)==1 ? ' checked="checked"' : ''); ?> onclick="showDescriptionOptions();"/>
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also include Meta Description tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_desc_show_meta" id="fb_desc_show_meta" value="1" <?php echo (intval($fb_desc_show_meta)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta name="description" content="..."/&gt;</i>
										<br/>
										<?php _e('Recommended for SEO purposes if no other plugin is setting it already', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also include Schema.org "itemprop" Description tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_desc_show_schema" id="fb_desc_show_schema" value="1" <?php echo (intval($fb_desc_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="description" content="..."/&gt;</i>
										<br/>
										<?php _e('Recommended for Google+ sharing purposes if no other plugin is setting it already', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap"><?php _e('Description maximum length', 'wd-fb-og');?>:</th>
									<td>
										<input type="text" name="fb_desc_chars" id="fb_desc_chars" size="3" maxlength="3" value="<?php echo (intval($fb_desc_chars)>0 ? intval($fb_desc_chars) : ''); ?>"/> characters,
										<br/>
										<?php _e('0 or blank for no maximum length', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_description_options">
									<th scope="row" nowrap="nowrap"><?php _e('Homepage description', 'wd-fb-og');?>:</th>
									<td>
										<?php
										$hide_home_description=false;
										if (get_option('show_on_front')=='page') {
											$hide_home_description=true;
											_e('The description of your front page:', 'wd-fb-og');
											echo '<a href="'.get_edit_post_link(get_option('page_on_front')).'" target="_blank">'.get_the_title(get_option('page_on_front')).'</a>';
										}; ?>
										<div<?php if ($hide_home_description) echo ' style="display: none;"'; ?>><?php _e('Use', 'wd-fb-og');?>
											<select name="fb_desc_homepage" id="fb_desc_homepage" onchange="showDescriptionCustomText();">
												<option value=""<?php if (trim($fb_desc_homepage)=='') echo ' selected="selected"'; ?>><?php _e('Website tagline', 'wd-fb-og');?>&nbsp;</option>
												<option value="custom"<?php if (trim($fb_desc_homepage)=='custom') echo ' selected="selected"'; ?>><?php _e('Custom text', 'wd-fb-og');?>&nbsp;</option>
											</select>
											<div id="fb_desc_homepage_customtext_div">
												<textarea name="fb_desc_homepage_customtext" id="fb_desc_homepage_customtext" rows="3" cols="50"><?php echo $fb_desc_homepage_customtext; ?></textarea>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr/></td>
								</tr>
								<tr>
									<th scope="row" nowrap="nowrap"><?php _e('Include Image (og:image) tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_image_show" id="fb_image_show" value="1" <?php echo (intval($fb_image_show)==1 ? ' checked="checked"' : ''); ?> onclick="showImageOptions();"/>
										<br/>
										<?php _e('All images MUST have at least 200px on both dimensions in order to Facebook to load them at all. Minimum of 600x315px is recommended.', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also include Schema.org "itemprop" Image tag?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_image_show_schema" id="fb_image_show_schema" value="1" <?php echo (intval($fb_image_show_schema)==1 ? ' checked="checked"' : ''); ?>/>
										<br/>
										<i>&lt;meta itemprop="image" content="..."/&gt;</i>
										<br/>
										<?php _e('Recommended for Google+ sharing purposes if no other plugin is setting it already', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap"><?php _e('Default image', 'wd-fb-og');?>:</th>
									<td>
										<input type="text" name="fb_image" id="fb_image" size="50" value="<?php echo $fb_image; ?>"/>
										<input id="fb_image_button" class="button" type="button" value="Upload/Choose image" />
										<br/>
										<?php _e('Full URL with http://', 'wd-fb-og');?>
										<br/>
										<?php _e('Recommended size: 1200x630px', 'wd-fb-og'); ?>
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap"><?php _e('Also add image to RSS/RSS2 feeds?', 'wd-fb-og');?></th>
									<td>
										<input type="checkbox" name="fb_image_rss" id="fb_image_rss" value="1" <?php echo (intval($fb_image_rss)==1 ? ' checked="checked"' : ''); ?> onclick="showImageOptions();"/>
										<br/>
										<?php _e('For auto-posting apps like RSS Graffiti, twitterfeed, ...', 'wd-fb-og');?>
									</td>
								</tr>
								<tr class="fb_image_options">
									<th scope="row" nowrap="nowrap"><?php _e('On posts/pages', 'wd-fb-og');?>:</th>
									<td>
										<div>
											1) <input type="checkbox" name="fb_image_use_specific" id="fb_image_use_specific" value="1" <?php echo (intval($fb_image_use_specific)==1 ? ' checked="checked"' : ''); ?>/>
											<?php _e('Image will be fetched from the specific "Open Graph Image" custom field on the post', 'wd-fb-og');?>
										</div>
										<div>
											2) <input type="checkbox" name="fb_image_use_featured" id="fb_image_use_featured" value="1" <?php echo (intval($fb_image_use_featured)==1 ? ' checked="checked"' : ''); ?>/>
											<?php _e('If it\'s not set, image will be fetched from post/page featured/thumbnail picture', 'wd-fb-og');?>
										</div>
										<div>
											3) <input type="checkbox" name="fb_image_use_content" id="fb_image_use_content" value="1" <?php echo (intval($fb_image_use_content)==1 ? ' checked="checked"' : ''); ?>/>
											<?php _e('If it doesn\'t exist, use the first image from the post/page content', 'wd-fb-og');?>
										</div>
										<div>
											4) <input type="checkbox" name="fb_image_use_media" id="fb_image_use_media" value="1" <?php echo (intval($fb_image_use_media)==1 ? ' checked="checked"' : ''); ?>/>
											<?php _e('If it doesn\'t exist, use first image from the post/page media gallery', 'wd-fb-og');?>
										</div>
										<div>
											5) <input type="checkbox" name="fb_image_use_default" id="fb_image_use_default" value="1" <?php echo (intval($fb_image_use_default)==1 ? ' checked="checked"' : ''); ?>/>
											<?php _e('If it doesn\'t exist, use the default image above', 'wd-fb-og');?>
										</div>
									</td>
								</tr>
	  					</table>
	  				</div>
	  			</div>
	  			<div id="wonderm00n_open_graph-thirdparty" class="postbox">
	  				<h3 id="thirdparty"><?php _e('3rd Party Integration', 'wd-fb-og');?></h3>
	  				<div class="inside">
	  					<?php
	  					$thirdparty=false;
	  					//WordPress SEO by Yoast
	  					if ( defined('WPSEO_VERSION') ) {
	  						$thirdparty=true;
	  						?>
	  						<h4><a href="http://wordpress.org/plugins/wordpress-seo/" target="_blank">WordPress SEO by Yoast</a></h4>
	  						<table width="100%" class="form-table">
									<tr>
										<th scope="row" nowrap="nowrap"><?php _e('Use title, url (canonical) and description from WPSEO?', 'wd-fb-og');?></th>
										<td>
											<input type="checkbox" name="fb_show_wpseoyoast" id="fb_show_wpseoyoast" value="1" <?php echo (intval($fb_show_wpseoyoast)==1 ? ' checked="checked"' : ''); ?>/>
											<br/>
											<?php _e('It\'s HIGHLY recommended to go to <a href="admin.php?page=wpseo_social">SEO &gt; Social</a> and disable "Add Open Graph meta data"', 'wd-fb-og'); ?>
										</td>
									</tr>
								</table>
	  						<?php
	  					}
	  					//SubHeading
	  					if(is_plugin_active('subheading/index.php')) {
	  						$thirdparty=true;
	  						?>
	  						<h4><a href="http://wordpress.org/extend/plugins/subheading/" target="_blank">SubHeading</a></h4>
	  						<table width="100%" class="form-table">
									<tr>
										<th scope="row" nowrap="nowrap"><?php _e('Add SubHeading to Post/Page title?', 'wd-fb-og');?></th>
										<td>
											<input type="checkbox" name="fb_show_subheading" id="fb_show_subheading" value="1" <?php echo (intval($fb_show_subheading)==1 ? ' checked="checked"' : ''); ?>/>
										</td>
									</tr>
								</table>
	  						<?php
	  					}
	  					//Business Directory Plugin 
	  					if(is_plugin_active('business-directory-plugin/wpbusdirman.php')) {
	  						$thirdparty=true;
	  						?>
	  						<h4><a href="http://wordpress.org/extend/plugins/business-directory-plugin/" target="_blank">Business Directory Plugin</a></h4>
	  						<table width="100%" class="form-table">
									<tr>
										<th scope="row" nowrap="nowrap"><?php _e('Use BDP listing contents as OG tags?', 'wd-fb-og');?></th>
										<td>
											<input type="checkbox" name="fb_show_businessdirectoryplugin" id="fb_show_businessdirectoryplugin" value="1" <?php echo (intval($fb_show_businessdirectoryplugin)==1 ? ' checked="checked"' : ''); ?>/>
											<br/>
											<?php _e('Setting "Include URL", "Also set Canonical URL", "Include Description" and "Include Image" options above is HIGHLY recommended', 'wd-fb-og');?>
										</td>
									</tr>
								</table>
	  						<?php
	  					}
	  					if (!$thirdparty) {
	  						?>
	  						<p><?php _e('You don\'t have any compatible 3rd Party plugin installed/active.', 'wd-fb-og');?></p>
	  						<p><?php _e('This plugin is currently compatible with:', 'wd-fb-og');?></p>
	  						<ul>
	  							<li><a href="http://wordpress.org/extend/plugins/wordpress-seo/" target="_blank">WordPress SEO by Yoast</a></li>
	  							<li><a href="http://wordpress.org/extend/plugins/subheading/" target="_blank">SubHeading</a></li>
	  							<li><a href="http://wordpress.org/extend/plugins/business-directory-plugin/" target="_blank">Business Directory Plugin</a></li>
	  						</ul>
	  						<?php
	  					}
	  					?>
	  				</div>
	  			</div>
	  			<p class="submit">
	  				<input type="hidden" name="action" value="save"/>
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					</p>
  			</form>
  		</div>
  	</div>
  	
  	<?php
  		$links[0]['text']=__('Test your URLs at Facebook URL Linter / Debugger', 'wd-fb-og');
  		$links[0]['url']='https://developers.facebook.com/tools/debug';

  		$links[10]['text']=__('About the Open Graph Protocol (on Facebook)', 'wd-fb-og');
  		$links[10]['url']='https://developers.facebook.com/docs/opengraph/';

  		$links[20]['text']=__('The Open Graph Protocol (official website)', 'wd-fb-og');
  		$links[20]['url']='http://ogp.me/';

  		$links[30]['text']=__('Plugin official URL', 'wd-fb-og');
  		$links[30]['url']='http://www.webdados.pt/produtos-e-servicos/internet/desenvolvimento-wordpress/facebook-open-graph-meta-tags-wordpress/?utm_source=fb_og_wp_plugin_settings&amp;utm_medium=link&amp;utm_campaign=fb_og_wp_plugin';

  		$links[40]['text']=__('Author\'s website: Webdados', 'wd-fb-og');
  		$links[40]['url']='http://www.webdados.pt/?utm_source=fb_og_wp_plugin_settings&amp;utm_medium=link&amp;utm_campaign=fb_og_wp_plugin';

  		$links[50]['text']=__('Author\'s Facebook page: Webdados', 'wd-fb-og');
  		$links[50]['url']='http://www.facebook.com/Webdados';

  		$links[60]['text']=__('Author\'s Twitter account: @Wonderm00n<br/>(Webdados founder)', 'wd-fb-og');
  		$links[60]['url']='http://twitter.com/wonderm00n';
  	?>
  	<div class="postbox-container" style="width: 29%; float: right;">
  		
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_links" class="postbox">
  				<h3 id="settings"><?php _e('Rate this plugin', 'wd-fb-og');?></h3>
  				<div class="inside">
  					<?php _e('If you like this plugin,', 'wd-fb-og');?> <a href="http://wordpress.org/extend/plugins/wonderm00ns-simple-facebook-open-graph-tags/" target="_blank"><?php _e('please give it a high Rating', 'wd-fb-og');?></a>.
  				</div>
  			</div>
  		</div>
		
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_links" class="postbox">
  				<h3 id="settings"><?php _e('Useful links', 'wd-fb-og');?></h3>
  				<div class="inside">
  					<ul>
  						<?php foreach($links as $link) { ?>
  							<li>- <a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['text']; ?></a></li>
  						<?php } ?>
  					</ul>
  				</div>
  			</div>
  		</div>
  	
  		<div id="poststuff">
  			<div id="wonderm00n_open_graph_donation" class="postbox">
  				<h3 id="settings"><?php _e('Donate', 'wd-fb-og');?></h3>
  				<div class="inside">
  					<p><?php _e('If you find this plugin useful and want to make a contribution towards future development please consider making a small, or big ;-), donation.', 'wd-fb-og');?></p>
  					<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="wonderm00n@gmail.com">
						<input type="hidden" name="lc" value="PT">
						<input type="hidden" name="item_name" value="Marco Almeida (Wonderm00n)">
						<input type="hidden" name="item_number" value="wonderm00n_open_graph">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form></center>
  				</div>
  			</div>
  		</div>
  		
  	</div>
  	
  	<div class="clear">
  		<p><br/>&copy 2011<?php if(date('Y')>2011) echo '-'.date('Y'); ?> <a href="http://www.webdados.pt/?utm_source=fb_og_wp_plugin_settings&amp;utm_medium=link&amp;utm_campaign=fb_og_wp_plugin" target="_blank">Webdados</a> &amp; <a href="http://wonderm00n.com/?utm_source=fb_og_wp_plugin_settings&amp;utm_medium=link&amp;utm_campaign=fb_og_wp_plugin" target="_blank">Marco Almeida (Wonderm00n)</a></p>
  	</div>
		
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#fb_image_button').click(function(){
				tb_show('',"media-upload.php?type=image&TB_iframe=true");
			});
			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				jQuery("input"+"#fb_image").val(imgurl);
				tb_remove();
			}
			showAppidOptions();
			showAdminOptions();
			showLocaleOptions();
			showTypeOptions();
			showUrlOptions();
			showUrlTrail();
			jQuery('.fb_description_options').hide();
			showDescriptionOptions();
			showTitleOptions();
			jQuery('#fb_desc_homepage_customtext').hide();
			showDescriptionCustomText();
			showImageOptions();
		});
		function showAppidOptions() {
			if (jQuery('#fb_app_id_show').is(':checked')) {
				jQuery('.fb_app_id_options').show();
			} else {
				jQuery('.fb_app_id_options').hide();
			}
		}
		function showAdminOptions() {
			if (jQuery('#fb_admin_id_show').is(':checked')) {
				jQuery('.fb_admin_id_options').show();
			} else {
				jQuery('.fb_admin_id_options').hide();
			}
		}
		function showLocaleOptions() {
			if (jQuery('#fb_locale_show').is(':checked')) {
				jQuery('.fb_locale_options').show();
			} else {
				jQuery('.fb_locale_options').hide();
			}
		}
		function showUrlOptions() {
			if (jQuery('#fb_url_show').is(':checked')) {
				jQuery('.fb_url_options').show();
			} else {
				jQuery('.fb_url_options').hide();
			}
		}
		function showUrlTrail() {
			if (jQuery('#fb_url_add_trailing').is(':checked')) {
				jQuery('#fb_url_add_trailing_example').show();
			} else {
				jQuery('#fb_url_add_trailing_example').hide();
			}
		}
		function showTypeOptions() {
			if (jQuery('#fb_type_show').is(':checked')) {
				jQuery('.fb_type_options').show();
			} else {
				jQuery('.fb_type_options').hide();
			}
		}
		function showDescriptionOptions() {
			if (jQuery('#fb_desc_show').is(':checked')) {
				jQuery('.fb_description_options').show();
			} else {
				jQuery('.fb_description_options').hide();
			}
		}
		function showTitleOptions() {
			if (jQuery('#fb_title_show').is(':checked')) {
				jQuery('.fb_title_options').show();
			} else {
				jQuery('.fb_title_options').hide();
			}
		}
		function showDescriptionCustomText() {
			if (jQuery('#fb_desc_homepage').val()=='custom') {
				jQuery('#fb_desc_homepage_customtext').show().focus();
			} else {
				jQuery('#fb_desc_homepage_customtext').hide();
			}
		}
		function showImageOptions() {
			if (jQuery('#fb_image_show').is(':checked')) {
				jQuery('.fb_image_options').show();
			} else {
				jQuery('.fb_image_options').hide();
			}
		}
	</script>
	<style type="text/css">
		TABLE.form-table TR TH {
			font-weight: bold;
		}
		TABLE.form-table TR TD HR {
			height: 1px;
  		margin: 0px;
  		background-color: #DFDFDF;
  		border: none;
		}
	</style>