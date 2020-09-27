# Orders
The Orders API is used to create a ticketing solution for a cinema

This API uses PHP 7.4 and utilises Symfony 5.1 with Doctrine to interact with a MySQL database.
For testing PHPUnit and Mockery have been used.

To run the API the database must be brought up from its docker container and migrations ran. Once this has been performed the server can be started.

From within the base directory run the following commands:
```
> docker-compose up
> php bin/console doctrine:migrations:migrate
> symfony serve
```

# Methods
```GET /order```

This endpoint will return all the orders, including their names, total costs, any discounts applied and an array of tickets for each order.

```GET /order/<orderId>```

This endpoint will return the order denoted by <orderId>, including their names, total costs, any discounts applied and an array of tickets for each order.

```POST /order```

This endpoint allows a new order to be created with the following JSON post body:
```
{
  "name": "<name>",
  "tickets": [
    {
      "type": <ticketTypeId>,
      "addOnType": <addOnTypeId>
    },
    ...
  ]
}
```

```POST /order/<orderId>/tickets```

This endpoint allows new tickets to be created with the following JSON post body:
```
[
    {
      "type": <ticketTypeId>,
      "addOnType": <addOnTypeId>
    },
    ...
]
```



# Notes
I have attempted to make this solution extendable and changeable via the database design and the implementation of offers. 

The database design lends itself to additions of different ticket types and add on types very well as the relationships have been defined to allow easy addition.

The Offers system uses a factory to return the offer that the cinema currently has active. In the database, new offers can be added and existing ones can be turned on and off by toggling the `active` field. To add a new offer, a new class can be made which extends the AbstractOffer class and must implement a single abstract function to calculate the discount. The factory should then be updated to return this new class based on the name defined in the database. This pattern allows new offers to be easily defined without any further code changes elsewhere in the product.


# Assumptions
I have assumed that there is a one-to-one relation between tickets and add-ons and that the cheapest tickets will be discounted first when the Three For One Thursday offer is applied.

I have also assumed only one offer can be active at any moment in time.

# Improvements
Error handling and robustness would be my next priority before deploying this solution into production. More extensive testing would also be required before the solution could be releasable.


