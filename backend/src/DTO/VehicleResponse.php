<?php

namespace App\DTO;

use App\Entity\Vehicle;

/**
 * @OA\Schema(schema="VehicleResponse", type="object")
 */
class VehicleResponse
{
  /**
   * @OA\Property()
   */
  public int $id;

  /**
   * @OA\Property()
   */
  public string $brand;

  /**
   * @OA\Property()
   */
  public string $registrationNumber;

  /**
   * @OA\Property()
   */
  public string $vin;

  /**
   * @OA\Property()
   */
  public string $email;

  /**
   * @OA\Property()
   */
  public AddressResponse $address;

  /**
   * @OA\Property()
   */
  public string $currentLocation;

  /**
   * @OA\Property()
   */
  public bool $isRented;

  public static function fromEntity(Vehicle $vehicle): self
  {
    $response = new self();
    $response->id = $vehicle->getId();
    $response->brand = $vehicle->getBrand();
    $response->registrationNumber = $vehicle->getRegistrationNumber();
    $response->vin = $vehicle->getVin();
    $response->email = $vehicle->getEmail();
    $response->address = AddressResponse::fromEntity($vehicle->getAddress());
    $response->currentLocation = $vehicle->getCurrentLocation();
    $response->isRented = $vehicle->getIsRented();
    return $response;
  }
}
