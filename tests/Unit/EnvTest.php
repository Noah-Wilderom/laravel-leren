<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_Env_Enabled()
    {
        $this->assertTrue(file_exists(__DIR__ . './../../.env'));
    }
}
