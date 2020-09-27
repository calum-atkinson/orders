<?php

use App\Entity\AddOn;
use App\Entity\AddOnType;
use App\Entity\Ticket;
use App\Entity\TicketType;

function getTestTickets(int $numberOfTickets): Array
{
    $standardTicketType = new TicketType();
    $standardTicketType->setPrice(100);
    $addOnType = new AddOnType();
    $addOnType->setPrice(10);


    $standardTicket = new Ticket();
    $standardTicket->setTicketType($standardTicketType);

    $real3DTicket = new Ticket();
    $real3DTicket->setTicketType($standardTicketType);
    $real3DAddOn = new AddOn();
    $real3DAddOn->setAddOnType($addOnType);
    $real3DTicket->setAddOn($real3DAddOn);

    $tickets = array();
    for ($i = 0; $i < $numberOfTickets; $i++) {
        if ($i % 2 == 0) {
            $tickets[] = $standardTicket;
        } else {
            $tickets[] = $real3DTicket;
        }
    }

    return $tickets;
}