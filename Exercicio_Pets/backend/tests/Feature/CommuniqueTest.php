<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;

class CommuniqueTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateCommunique()
    {
        $pet = factory(Pet::class)->create();
        $data = ['name' => 'Test Communique', 'phone' => '1111111111'];
        $response = $this->postJson("/api/communiques/{$pet->id}", $data);

        $response->assertStatus(201);
    }
}
