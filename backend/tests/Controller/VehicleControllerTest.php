<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{
  public function testGetVehicles(): void
  {
    $client = static::createClient();
    $client->request('GET', '/api/vehicles');

    $this->assertResponseIsSuccessful();
    $this->assertResponseHeaderSame('Content-Type', 'application/json');
    $this->assertJson($client->getResponse()->getContent());
  }

  public function testCreateVehicle(): void
  {
    $client = static::createClient();
    $data = [
      'brand' => 'Test Brand',
      'registrationNumber' => 'TEST123',
      'vin' => '123456789ABCDEFG',
      'email' => 'test@example.com',
      'address' => [
        'street' => 'Test Street',
        'city' => 'Test City',
        'postalCode' => '12345',
        'country' => 'Polska',
      ],
      'isRented' => false,
      'currentLocation' => 'Garage A',
    ];

    $client->request(
      'POST',
      '/api/vehicles',
      [],
      [],
      ['CONTENT_TYPE' => 'application/json'],
      json_encode($data)
    );

    $this->assertResponseStatusCodeSame(201);
    $this->assertJson($client->getResponse()->getContent());
    $this->assertStringContainsString('Test Brand', $client->getResponse()->getContent());
  }

  public function testUpdateVehicle(): void
  {
    $client = static::createClient();

    $data = [
      'brand' => 'Updated Brand',
      'registrationNumber' => 'UPDATED123',
      'vin' => 'UPDATEDVIN123456789',
      'email' => 'updated@example.com',
      'address' => [
        'street' => 'Updated Street',
        'city' => 'Updated City',
        'postalCode' => '67890',
        'country' => 'Polska',
      ],
      'isRented' => true,
      'currentLocation' => 'Updated Location',
    ];

    $client->request(
      'PUT',
      '/api/vehicles/1',
      [],
      [],
      ['CONTENT_TYPE' => 'application/json'],
      json_encode($data)
    );

    $this->assertResponseIsSuccessful();
    $this->assertStringContainsString('Updated Brand', $client->getResponse()->getContent());
  }

  public function testDeleteVehicle(): void
  {
    $client = static::createClient();
    $client->request('DELETE', '/api/vehicles/1');

    $this->assertResponseStatusCodeSame(200);
  }
}
