<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket;
use App\Repositories\BaseRepositoryInterface;

interface TicketRepositoryInterface extends BaseRepositoryInterface
{

    public function findWithRelations(string $ticketId) : ?Ticket;

}
