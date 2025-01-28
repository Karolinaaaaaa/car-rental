<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     schema="CreateVehicleRequest",
 *     type="object",
 *     required={"brand", "registrationNumber", "vin", "email", "address", "isRented", "currentLocation"}
 * )
 */
class CreateVehicleRequest
{
  /**
   * @OA\Property(type="string", maxLength=255, example="Toyota")
   */
  #[Assert\NotBlank]
  public string $brand;

  /**
   * @OA\Property(type="string", maxLength=255, example="KR12345")
   */
  #[Assert\NotBlank]
  public string $registrationNumber;

  /**
   * @OA\Property(type="string", maxLength=255, example="JT3DJ81W8V0071234")
   */
  #[Assert\NotBlank]
  public string $vin;

  /**
   * @OA\Property(type="string", format="email", example="example@email.com")
   */
  #[Assert\NotBlank]
  #[Assert\Email]
  public string $email;

  /**
   * @OA\Property(ref="#/components/schemas/AddressRequest")
   */
  #[Assert\Valid]
  public AddressRequest $address;

  /**
   * @OA\Property(type="boolean", example=true)
   */
  #[Assert\NotNull]
  public bool $isRented;

  /**
   * @OA\Property(type="string", maxLength=255, example="Garage A")
   */
  #[Assert\NotBlank]
  public string $currentLocation;
}
