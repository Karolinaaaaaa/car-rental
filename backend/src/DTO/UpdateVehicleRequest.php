<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(schema="UpdateVehicleRequest", type="object")
 */
class UpdateVehicleRequest
{
  /**
   * @OA\Property()
   */
  #[Assert\NotBlank]
  public string $brand;

  /**
   * @OA\Property()
   */
  #[Assert\NotBlank]
  public string $registrationNumber;

  /**
   * @OA\Property()
   */
  #[Assert\NotBlank]
  public string $vin;

  /**
   * @OA\Property()
   */
  #[Assert\NotBlank]
  #[Assert\Email]
  public string $email;

  /**
   * @OA\Property(ref="#/components/schemas/AddressRequest")
   */
  #[Assert\NotNull]
  public AddressRequest $address;

  /**
   * @OA\Property()
   */
  #[Assert\NotNull]
  public bool $isRented;

  /**
   * @OA\Property()
   */
  #[Assert\NotBlank]
  public string $currentLocation;
}
