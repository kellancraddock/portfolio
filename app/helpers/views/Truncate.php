<?php
	class View_Helper_Truncate extends Zend_Controller_Action_Helper_Abstract
	{
		public function truncate($text, $options) {
      		if (str_word_count($text) > $options['limit']) {
	          	$words = str_word_count($text, 2);
	         	$pos = array_keys($words);
	         	$url = (isset($options['url'])) ? '<a href="' . $options['url'] . '">More</a>' : '';
	          	$text = substr($text, 0, $pos[$options['limit']]) . "... {$url}";
      		}
      		return $text;
    	}
	}
?>