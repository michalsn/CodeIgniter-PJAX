<?php

use \Mockery as m;

define('BASEPATH', 'application');

function get_instance() {
    return m::mock('ci');
}
