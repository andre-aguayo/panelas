<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        //List all Companies route
        ($this->get('/api/companies'))
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        //List all state route
        ($this->get('/api/UF'))
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        //List all cities
        ($this->get('/api/cities'))
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        //List all state and cities
        ($this->get('/api/state-cities?UF=MA',))
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
