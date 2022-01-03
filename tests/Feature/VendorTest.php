<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Vendor()
    {
        $this->assertTrue(file_exists(__DIR__ . './../../vendor'));
    }
}
