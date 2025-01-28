<?php

namespace App\Service;

use App\DTO\CreateVehicleRequest;
use App\DTO\UpdateVehicleRequest;
use App\Entity\Vehicle;
use App\Entity\Address;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;

class VehicleService
{
  private VehicleRepository $vehicleRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(VehicleRepository $vehicleRepository, EntityManagerInterface $entityManager)
  {
    $this->vehicleRepository = $vehicleRepository;
    $this->entityManager = $entityManager;
  }

  public function getAllVehicles(): array
  {
    return $this->vehicleRepository->findAll();
  }

  public function createVehicle(CreateVehicleRequest $request): Vehicle
  {
    $vehicle = new Vehicle();
    $vehicle->setBrand($request->brand);
    $vehicle->setRegistrationNumber($request->registrationNumber);
    $vehicle->setVin($request->vin);
    $vehicle->setEmail($request->email);
    $vehicle->setIsRented($request->isRented);
    $vehicle->setCurrentLocation($request->currentLocation);

    $address = $this->createAddressFromRequest($request->address);
    $vehicle->setAddress($address);

    $this->saveVehicle($vehicle);

    return $vehicle;
  }

  public function updateVehicle(int $id, UpdateVehicleRequest $request): ?Vehicle
  {
    $vehicle = $this->findVehicleById($id);
    if (!$vehicle) {
      return null;
    }

    $vehicle->setBrand($request->brand);
    $vehicle->setRegistrationNumber($request->registrationNumber);
    $vehicle->setVin($request->vin);
    $vehicle->setEmail($request->email);
    $vehicle->setIsRented($request->isRented);
    $vehicle->setCurrentLocation($request->currentLocation);

    $address = $vehicle->getAddress();
    if ($address) {
      $this->updateAddressFromRequest($address, $request->address);
    } else {
      $address = $this->createAddressFromRequest($request->address);
      $vehicle->setAddress($address);
    }

    $this->saveVehicle($vehicle);

    return $vehicle;
  }

  public function deleteVehicle(int $id): bool
  {
    $vehicle = $this->findVehicleById($id);
    if (!$vehicle) {
      return false;
    }

    $this->entityManager->remove($vehicle);
    $this->entityManager->flush();

    return true;
  }

  public function saveVehicle(Vehicle $vehicle): void
  {
    $this->entityManager->persist($vehicle);
    $this->entityManager->flush();
  }

  public function findVehicleById(int $id): ?Vehicle
  {
    return $this->vehicleRepository->find($id);
  }

  public function getFilteredVehicles(?string $brand, ?bool $isRented): array
  {
    return $this->vehicleRepository->findFilteredVehicles($brand, $isRented);
  }

  private function createAddressFromRequest($request): Address
  {
    if (!$request || !$request->postalCode) {
      throw new \InvalidArgumentException('Kod pocztowy jest wymagany.');
    }

    $address = new Address();
    $address->setStreet($request->street ?? '');
    $address->setCity($request->city ?? '');
    $address->setPostalCode($request->postalCode);
    $address->setCountry($request->country ?? '');

    $this->entityManager->persist($address);

    return $address;
  }

  private function updateAddressFromRequest(Address $address, $request): void
  {
    if (!$request || !$request->postalCode) {
      throw new \InvalidArgumentException('Kod pocztowy jest wymagany.');
    }

    $address->setStreet($request->street);
    $address->setCity($request->city);
    $address->setPostalCode($request->postalCode);
    $address->setCountry($request->country ?? '');

    $this->entityManager->persist($address);
  }

  public function updateVehicleLocation(int $vehicleId, string $newLocation): ?Vehicle
  {
    $vehicle = $this->findVehicleById($vehicleId);
    if (!$vehicle) {
      return null;
    }

    $vehicle->setCurrentLocation($newLocation);
    $this->saveVehicle($vehicle);

    return $vehicle;
  }
}
