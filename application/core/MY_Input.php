<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Input Class
 *
 * Pre-processes global input data for security
 *
 * @package    CodeIgniter
 * @subpackage Libraries
 * @category   Input
 * @author     Michal Sniatala <m.sniatala@gmail.com>
 * @link       https://github.com/michalsn/CodeIgniter-PJAX
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @version    1.0
 */
class MY_Input extends CI_Input {

	/**
	 * Is PJAX request?
	 *
	 * Test to see if a request contains the HTTP_X_PJAX header.
	 *
	 * @return bool
	 */
	public function is_pjax_request()
	{
		return (bool) ($this->server('HTTP_X_PJAX') === 'true');
	}

}
