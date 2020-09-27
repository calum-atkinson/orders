<?php


namespace App\Service\Offer;


use App\Service\Offer\AbstractOffer;
use App\Service\Offer\ThreeForOneThursdays;
use Exception;

class OfferFactory
{

    public function getOffer(string $name): AbstractOffer
    {
        switch ($name) {
            case "ThreeForOneThursdays":
                return new ThreeForOneThursdays();
                break;
            default:
                throw new Exception("No offer with name '$name' found");
        }
    }

}