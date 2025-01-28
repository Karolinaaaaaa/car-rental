<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     schema="AddressRequest",
 *     type="object",
 *     required={"street", "city", "postalCode"}
 * )
 */
class AddressRequest
{
  /**
   * @OA\Property(type="string", maxLength=255, example="Main Street 1")
   */
  #[Assert\NotBlank]
  public string $street;

  /**
   * @OA\Property(type="string", maxLength=255, example="New York")
   */
  #[Assert\NotBlank]
  public string $city;

  /**
   * @OA\Property(type="string", maxLength=20, example="10001")
   */
  #[Assert\NotBlank]
  public string $postalCode;

  /**
   * @OA\Property(type="string", maxLength=255, example="USA")
   */
  public ?string $country = null;
}
