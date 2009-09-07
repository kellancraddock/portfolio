<?php
	class View_Helper_Truncate extends Zend_Controller_Action_Helper_Abstract
	{
		public function truncate($text, $limit) {
      		if (str_word_count($text) > $limit) {
	          	$words = str_word_count($text, 2);
	         	$pos = array_keys($words);
	          	$text = substr($text, 0, $pos[$limit]) . '...';
      		}
      		return $text;
    	}
	}
?>