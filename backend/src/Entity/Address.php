<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'address')]
class Address
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 255)]
  #[Assert\NotBlank]
  private ?string $street = null;

  #[ORM\Column(type: 'string', length: 255)]
  #[Assert\NotBlank]
  private ?string $city = null;

  #[ORM\Column(type: 'string', length: 20)]
  #[Assert\NotBlank]
  private ?string $postalCode = null;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private ?string $country = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getStreet(): ?string
  {
    return $this->street;
  }

  public function setStreet(string $street): self
  {
    $this->street = $street;
    return $this;
  }

  public function getCity(): ?string
  {
    return $this->city;
  }

  public function setCity(string $city): self
  {
    $this->city = $city;
    return $this;
  }

  public function getPostalCode(): ?string
  {
    return $this->postalCode;
  }

  public function setPostalCode(string $postalCode): self
  {
    $this->postalCode = $postalCode;
    return $this;
  }

  public function getCountry(): ?string
  {
    return $this->country;
  }

  public function setCountry(?string $country): self
  {
    $this->country = $country;
    return $this;
  }
}
