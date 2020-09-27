<?php

namespace App\Service\Offer;

use Exception;
use PHPUnit\Framework\TestCase;

class OfferFactoryTest extends TestCase
{
    private OfferFactory $offerFactory;

    protected function setUp(): void
    {
        $this->offerFactory = new OfferFactory();
    }

    public function testGetOfferShouldThrowAnExceptionIfOfferNameNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->offerFactory->getOffer('invalid');
    }

    public function testGetOfferShouldReturnAnInstanceOfThreeForOneThursdayIfFound(): void
    {
        $offer = $this->offerFactory->getOffer('ThreeForOneThursdays');
        $this->assertInstanceOf(ThreeForOneThursdays::class, $offer);
    }
}
