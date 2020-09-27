<?php

namespace App\Service\Offer;

include '../../Fixtures.php';

use Mockery;
use PHPUnit\Framework\TestCase;

class ThreeForOneThursdaysTest extends TestCase
{
    private $threeForOneThursdays;

    protected function setUp(): void
    {
        $this->threeForOneThursdays = Mockery::mock(ThreeForOneThursdays::class)->makePartial();
    }

    public function testCalculateFreeTicketReturnsCorrectOutputGivenZeroTickets(): void
    {
        $expectedFreeTickets = 0;
        $freeTickets = $this->threeForOneThursdays->calculateFreeTickets(0);
        $this->assertEquals($freeTickets, $expectedFreeTickets);
    }

    public function testCalculateFreeTicketReturnsCorrectOutputGivenOneTickets(): void
    {
        $expectedFreeTickets = 0;
        $freeTickets = $this->threeForOneThursdays->calculateFreeTickets(1);
        $this->assertEquals($freeTickets, $expectedFreeTickets);
    }

    public function testCalculateFreeTicketReturnsCorrectOutputGivenThreeTickets(): void
    {
        $expectedFreeTickets = 2;
        $freeTickets = $this->threeForOneThursdays->calculateFreeTickets(3);
        $this->assertEquals($freeTickets, $expectedFreeTickets);
    }

    public function testCalculateFreeTicketReturnsCorrectOutputGivenSevenTickets(): void
    {
        $expectedFreeTickets = 4;
        $freeTickets = $this->threeForOneThursdays->calculateFreeTickets(7);
        $this->assertEquals($freeTickets, $expectedFreeTickets);
    }

    public function testCalculateDiscountShouldReturnZeroIfNotThursday(): void
    {
        $this->threeForOneThursdays->shouldReceive('isTodayThursday')->andReturn(false);
        $testTickets = getTestTickets(10);
        $expectedDiscount = 0;
        $discount = $this->threeForOneThursdays->calculateDiscount($testTickets);
        $this->assertEquals($discount, $expectedDiscount);
    }

    public function testCalculateDiscountShouldReturnZeroIfNoFreeTickets(): void
    {
        $this->threeForOneThursdays->shouldReceive('isTodayThursday')->andReturn(true);
        $testTickets = getTestTickets(2);
        $expectedDiscount = 0;
        $discount = $this->threeForOneThursdays->calculateDiscount($testTickets);
        $this->assertEquals($discount, $expectedDiscount);
    }

    public function testCalculateDiscountShouldReturnTheCostOfTwoCheapestTicketsIfDiscountApplied(): void
    {
        $this->threeForOneThursdays->shouldReceive('isTodayThursday')->andReturn(true);
        $testTickets = getTestTickets(10);
        $expectedDiscount = 610;
        $discount = $this->threeForOneThursdays->calculateDiscount($testTickets);
        $this->assertEquals($discount, $expectedDiscount);
    }
}
