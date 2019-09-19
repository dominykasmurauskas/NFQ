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
    {   $this->withoutExceptionHandling();
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
    /** @test */
    public function a_client_has_provided_his_email()
    {
        $client = factory('App\Client')->raw(['email' => '']);
        $this->post('/client-register', $client)->assertSessionHasErrors('email');
    }
    /** @test */
    public function a_client_can_check_time_remaining()
    {
        $client = factory('App\Client')->create();
        $this->post('/time-remaining', $client->toArray())->assertRedirect('/');
    }
    /** @test */
    public function a_client_can_access_his_dashboard()
    {
        # code...
        $client = factory('App\Client')->create();
        $this->get($client->path(), $client->toArray())->assertStatus(200);
    }
    /** @test */
    public function a_client_can_cancel_his_visit()
    {
        //$this->withoutExceptionHandling();
        $client = factory('App\Client')->create();
        $this->post('/clients/' . $client->id . '/cancel')->assertRedirect('/');
        $this->assertDatabaseMissing('clients', $client->toArray());
    }
}
