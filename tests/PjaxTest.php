<?php

use \Mockery as m;

class PjaxTest extends PHPUnit_Framework_TestCase {

	public $pjax;

	public function setUp()
	{
		include_once('application/hooks/Pjax.php');

		$this->pjax             = new Pjax();
		$this->pjax->ci->input  = m::mock('input');
		$this->pjax->ci->output = m::mock('output');
		$this->pjax->ci->config = m::mock('config');
		$this->pjax->ci->uri    = m::mock('uri');
	}

	protected function tearDown() {
		m::close();
	}

	public function test_pjax_request()
	{
		
		$this->pjax->ci->input->shouldReceive('is_pjax_request')->once()->andReturn(true);

		$content = file_get_contents(__DIR__.'/fixtures/file1.html');
		$this->pjax->ci->output->shouldReceive('get_output')->once()->andReturn($content);

		$this->pjax->ci->uri->shouldReceive('uri_string')->once()->andReturn('mocked/url');
		$this->pjax->ci->config->shouldReceive('site_url')->with('mocked/url')->once()->andReturn('http://site.app/mocked/url');
		$this->pjax->ci->output->shouldReceive('set_header')->with('X-PJAX-URL: http://site.app/mocked/url')->once();

		$this->pjax->ci->input->shouldReceive('server')->with('HTTP_X_PJAX_CONTAINER')->once()->andReturn('#pjax-container');
		$this->pjax->ci->output->shouldReceive('set_output')->with('<title>Sample</title>Sample container')->once();

		$result = $this->pjax->initialize();

		$this->assertTrue($result, 'is PJAX');

	}

	public function test_pjax_request_with_bad_container()
	{
		
		$this->pjax->ci->input->shouldReceive('is_pjax_request')->once()->andReturn(true);

		$content = file_get_contents(__DIR__.'/fixtures/file1.html');
		$this->pjax->ci->output->shouldReceive('get_output')->once()->andReturn($content);

		$this->pjax->ci->uri->shouldReceive('uri_string')->once()->andReturn('mocked/url');
		$this->pjax->ci->config->shouldReceive('site_url')->with('mocked/url')->once()->andReturn('http://site.app/mocked/url');
		$this->pjax->ci->output->shouldReceive('set_header')->with('X-PJAX-URL: http://site.app/mocked/url')->once();

		$this->pjax->ci->input->shouldReceive('server')->with('HTTP_X_PJAX_CONTAINER')->once()->andReturn('#pjax-container-bad');
		$this->pjax->ci->output->shouldReceive('set_output')->with('<title>Sample</title>')->once();

		$result = $this->pjax->initialize();

		$this->assertTrue($result, 'is PJAX');

	}

	public function test_pjax_request_with_version()
	{
		
		$this->pjax->ci->input->shouldReceive('is_pjax_request')->once()->andReturn(true);

		$content = file_get_contents(__DIR__.'/fixtures/file2.html');
		$this->pjax->ci->output->shouldReceive('get_output')->once()->andReturn($content);

		$this->pjax->ci->uri->shouldReceive('uri_string')->once()->andReturn('mocked/url');
		$this->pjax->ci->config->shouldReceive('site_url')->with('mocked/url')->once()->andReturn('http://site.app/mocked/url');
		$this->pjax->ci->output->shouldReceive('set_header')->with('X-PJAX-URL: http://site.app/mocked/url')->once();

		$this->pjax->ci->output->shouldReceive('set_header')->with('X-PJAX-Version: v123')->once();

		$this->pjax->ci->input->shouldReceive('server')->with('HTTP_X_PJAX_CONTAINER')->once()->andReturn('#pjax-container');
		$this->pjax->ci->output->shouldReceive('set_output')->with('<title>Sample</title>Sample container')->once();

		$result = $this->pjax->initialize();

		$this->assertTrue($result, 'is PJAX');

	}

	public function test_test_not_pjax_request()
	{
		
		$this->pjax->ci->input->shouldReceive('is_pjax_request')->once()->andReturn(false);

		$result = $this->pjax->initialize();

		$this->assertFalse($result, 'is not PJAX');

	}

}