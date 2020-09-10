<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\PetOwner;
use App\Models\Pet;

class PetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePet()
    {

        $user = factory(PetOwner::class)->create();
        
        $data = [
            'name' => 'Animal test',
            'photo' => UploadedFile::fake()->image('animal.jpg'),
            'age' => 17,
            'informations' => 'teste teste teste',
            'city' => 'Marília',
            'state' => 'SP',
            'status' => 'found',
        ];

        $response =  $this->actingAs($user, 'api')->postJson('/api/pets', $data);
        $response->assertStatus(201);

    }

    public function testGetAllPet() 
    {
        $user = factory(PetOwner::class)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/pets');
        $response->assertStatus(200);
    }

    public function testShowPet() 
    {
        $pet = factory(Pet::class)->create();
        $user = factory(PetOwner::class)->create();

        $response = $this->actingAs($user, 'api')
            ->getJson("/api/pets/{$pet->id}");
        $response->assertStatus(200);
    }
}
