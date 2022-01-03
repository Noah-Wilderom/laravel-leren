<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NodeModulesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_node_modules()
    {
        $this->assertTrue(file_exists(__DIR__ . './../../node_modules'));
    }
}
