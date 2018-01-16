<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RulesResourceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function canAddRule()
    {

    }


    // canEditRule
    // canShowRule
    // canListRules
    // canDeleteRule
}
