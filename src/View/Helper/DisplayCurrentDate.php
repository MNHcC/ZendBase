<?php

namespace MNHcC\View\Helper {

    use Zend\View\Helper\AbstractHelper;

    class DisplayCurrentDate extends AbstractHelper {

	public function __invoke($format='d.m.Y') {
	    return date($format);
	}

    }

}