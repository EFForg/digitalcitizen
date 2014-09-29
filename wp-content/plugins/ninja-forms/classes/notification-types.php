<?php
/**
 * Notification Types Class. 
 * This class instantiates all of our registered notification types.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Nofitications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Notification_Types
{

	/**
	 * Get things rolling by instantiating our notification type classes.
	 */

	function __construct() {
		foreach( Ninja_Forms()->registered_notification_types as $slug => $type ) {
			$classname = $type['classname'];
			if ( class_exists( $classname ) )
				$this->$slug = new $classname();
		}
	}

}