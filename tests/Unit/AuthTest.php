<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
   
      
        $response = $this->get('/admin');

        $response->assertStatus(200);
        
        $response = $this->post('/validate',['username'=>'tosin',
    'password'=>"vinny"]);

        $response->assertStatus(302);


    }
}
