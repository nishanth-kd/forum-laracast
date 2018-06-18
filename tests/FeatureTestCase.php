<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FeatureTestCase extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        //$this->withoutExceptionHandling();
    }
}
