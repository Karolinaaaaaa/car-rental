<?php

namespace App\Tests\Service;

use App\DTO\CreateVehicleRequest;
use App\DTO\AddressRequest;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use App\Service\VehicleService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class VehicleServiceTest extends TestCase
{
  private $vehicleService;
  private $vehicleRepository;
  private $entityManager;

  protected function setUp(): void
  {
    $this->vehicleRepository = $this->createMock(VehicleRepository::class);
    $this->entityManager = $this->createMock(EntityManagerInterface::class);
    $this->vehicleService = new VehicleService($this->vehicleRepository, $this->entityManager);
  }

  public function testCreateVehicle(): void
  {
    $addressRequest = new AddressRequest();
    $addressRequest->street = 'Test Street';
    $addressRequest->city = 'Test City';
    $addressRequest->postalCode = '12345';
    $addressRequest->country = 'Polska';

    $createRequest = new CreateVehicleRequest();
    $createRequest->brand = 'Test Brand';
    $createRequest->registrationNumber = 'TEST123';
    $createRequest->vin = '123456789ABCDEFG';
    $createRequest->email = 'test@example.com';
    $createRequest->address = $addressRequest;
    $createRequest->isRented = false;
    $createRequest->currentLocation = 'Garage A';


    $this->entityManager->expects($this->exactly(2))->method('persist');
    $this->entityManager->expects($this->once())->method('flush');

    $vehicle = $this->vehicleService->createVehicle($createRequest);

    $this->assertInstanceOf(Vehicle::class, $vehicle);
    $this->assertEquals('Test Brand', $vehicle->getBrand());
  }

  public function testGetAllVehicles(): void
  {
    $vehicle = (new Vehicle())->setBrand('Test Brand');
    $this->vehicleRepository->expects($this->once())
      ->method('findAll')
      ->willReturn([$vehicle]);

    $vehicles = $this->vehicleService->getAllVehicles();

    $this->assertCount(1, $vehicles);
    $this->assertEquals('Test Brand', $vehicles[0]->getBrand());
  }
}
