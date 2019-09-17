<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTests extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_client_can_visit_registration_page()
    {
        $response = $this->get('/client-register');
        $response->assertStatus(200);
    }
    
    /** @test */
    public function a_client_can_register()
    {   
        $client = factory('App\Client')->create();
        $this->post('/client-register', $client->toArray())->assertRedirect('/');
        $this->assertDatabaseHas('clients', $client->toArray());
    }
    
    /** @test */
    public function a_client_has_specified_his_name()
    {
        $client = factory('App\Client')->raw(['name' => '']);
        $this->post('/client-register', $client)->assertSessionHasErrors('name');
    }
    /** @test */
    public function a_client_has_specified_the_service()
    {
        $client = factory('App\Client')->raw(['service' => '']);
        $this->post('/client-register', $client)->assertSessionHasErrors('service');
    }
}
