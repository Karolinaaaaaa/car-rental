<?php

namespace App\DTO;

use App\Entity\Address;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AddressResponse",
 *     type="object"
 * )
 */
class AddressResponse
{
  /**
   * @OA\Property(type="string")
   */
  public string $street;

  /**
   * @OA\Property(type="string")
   */
  public string $city;

  /**
   * @OA\Property(type="string")
   */
  public string $postalCode;

  /**
   * @OA\Property(type="string", nullable=true)
   */
  public ?string $country;

  public static function fromEntity(Address $address): self
  {
    $response = new self();
    $response->street = $address->getStreet();
    $response->city = $address->getCity();
    $response->postalCode = $address->getPostalCode();
    $response->country = $address->getCountry();

    return $response;
  }
}
