<?php
/*
Plugin Name: EFF Piwik
Plugin URI: http://eff.org
Description:  Collect stats anonymously through EFF's Piwik setup.
Version: 0.1
Author: Matthew Gerring
Author URI: http://matthewgerring.com
License: GPLv2 or later
Text Domain: eff-piwik
*/

/*
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

add_action('wp_footer', 'eff_piwik_inject_tracker', 11);

function eff_piwik_inject_tracker() {
?>
<noscript>
	<img src="https://anon-stats.eff.org/js/?idsite=16&amp;rec=1&amp;action_name=<?php echo urlencode(wp_title('|',false,'right')); ?>" style="border:0" height="0" width="0" alt="" />
</noscript>

<div style="height: 0; width: 0" id="anon-stats"></div>

<script type="text/javascript">
	document.getElementById('anon-stats').innerHTML = '<img src="https://anon-stats.eff.org/js/?idsite=16&amp;rec=1&amp;urlref=' + encodeURIComponent(document.referrer) + '&amp;action_name=' + encodeURIComponent(document.title) + '" style="border:0" height="0" width="0" alt="" />';
</script>

<?php
}
?>
