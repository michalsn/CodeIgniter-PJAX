<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PJAX Hook Class
 *
 * Post Controller Hook
 *
 * @package    CodeIgniter
 * @subpackage Hooks
 * @author     Michal Sniatala <m.sniatala@gmail.com>
 * @link       https://github.com/michalsn/CodeIgniter-PJAX
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @version    1.0
 */
class Pjax {

	/**
	 * CI object.
	 *
	 * @var object
	 */
	public $ci;

	/**
	 * Dom object.
	 *
	 * @var object 
	 */
	protected $dom;

	/**
	 * Title.
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Content.
	 *
	 * @var string
	 */
	protected $content = '';

	// ------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->ci = get_instance();
	}

	/**
	 * Prepare output for PJAX.
	 *
	 * @return void
	 */
	public function initialize()
	{
		if ($this->ci->input->is_pjax_request())
		{
			$this->set_title()->set_url()->set_version()->set_content();

			$this->ci->output->set_output($this->title . $this->content);

			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set title.
	 *
	 * @return $this
	 */
	protected function set_title()
	{
		$dom = $this->load_dom();

		// prepare title
		$title_tag = $dom->getElementsByTagName('title');
		if ($title_tag->length !== 0)
		{
			$this->title = $dom->saveHTML($title_tag->item(0));
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set X-PJAX-URL header.
	 *
	 * @return $this
	 */
	protected function set_url()
	{
		$this->ci->output->set_header('X-PJAX-URL: ' . $this->ci->config->site_url($this->ci->uri->uri_string()));

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set X-PJAX-Version header.
	 *
	 * @return $this
	 */
	protected function set_version()
	{
		$dom = $this->load_dom();

		// prepare version
		$meta_tags = $dom->getElementsByTagName('meta');
		if ($meta_tags->length !== 0)
		{
			foreach($meta_tags as $meta)
			{
				if (strtolower($meta->getAttribute('http-equiv')) === 'x-pjax-version')
				{ 
					$version = $meta->getAttribute('content');
					// set pjax version header
					$this->ci->output->set_header('X-PJAX-Version: ' . $version);

					break;
				}
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set content.
	 *
	 * @return $this
	 */
	protected function set_content()
	{
		$dom = $this->load_dom();

		// prepare content
		$container = $this->ci->input->server('HTTP_X_PJAX_CONTAINER');
		$container = ltrim($container, '#');

		$content_tag = $dom->getElementById($container);
		if ($content_tag !== NULL)
		{
			foreach ($content_tag->childNodes as $child)
			{
				$this->content .= $dom->saveHTML($child);
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Load output to DOMDocument.
	 *
	 * @return DOMDocument
	 */
	protected function load_dom()
	{
		if ($this->dom)
		{
			return $this->dom;
		}

		$output = $this->ci->output->get_output();

		$this->dom = new DOMDocument;
		libxml_use_internal_errors(TRUE);
		$this->dom->loadHTML($output);
		libxml_clear_errors();

		return $this->dom;
	}

}
