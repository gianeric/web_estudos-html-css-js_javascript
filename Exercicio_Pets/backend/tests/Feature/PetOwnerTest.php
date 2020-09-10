<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetOwnerTest extends TestCase
{
    /**
     * Create pet owner
     *
     * @return void
     */
    public function testCreatePetOwner()
    {

        $data = [
            'name' => 'Pedro Henrique', 
            'email' => 'pedro.henrique.p.l@hotmail.com', 
            'password' => '123456', 
            'password_confirmation' => '123456',
            'phone' => '14998527786'
        ];

        $response = $this->postJson('/api/owners', $data);


        $response->assertStatus(201);

    }
}
