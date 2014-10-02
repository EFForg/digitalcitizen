<?php 
	$x = wp_get_form('digitalcitizen-contribute-form');
	echo $x;
	/*foreach( $x->get_children() as $child ) {
		if($child->type == "hidden") continue;
		echo $child->get_attribute('name');
	}*/
?>