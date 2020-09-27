<?php


namespace App\Service\Offer;


abstract class AbstractOffer
{
    abstract public function calculateDiscount(Array $tickets);

}