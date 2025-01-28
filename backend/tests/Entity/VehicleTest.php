<?php

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testVehicleSettersAndGetters(): void
    {
        $address = new Address();
        $address->setStreet('Test Street')
            ->setCity('Test City')
            ->setPostalCode('12345')
            ->setCountry('Polska');

        $vehicle = new Vehicle();
        $vehicle->setBrand('Test Brand')
            ->setRegistrationNumber('TEST123')
            ->setVin('123456789ABCDEFG')
            ->setEmail('test@example.com')
            ->setAddress($address)
            ->setIsRented(false)
            ->setCurrentLocation('Garage A');

        $this->assertEquals('Test Brand', $vehicle->getBrand());
        $this->assertEquals('TEST123', $vehicle->getRegistrationNumber());
        $this->assertEquals('123456789ABCDEFG', $vehicle->getVin());
        $this->assertEquals('test@example.com', $vehicle->getEmail());
        $this->assertFalse($vehicle->getIsRented());
        $this->assertEquals('Garage A', $vehicle->getCurrentLocation());

        $this->assertInstanceOf(Address::class, $vehicle->getAddress());
        $this->assertEquals('Test Street', $vehicle->getAddress()->getStreet());
        $this->assertEquals('Test City', $vehicle->getAddress()->getCity());
        $this->assertEquals('12345', $vehicle->getAddress()->getPostalCode());
        $this->assertEquals('Polska', $vehicle->getAddress()->getCountry());
    }
}
