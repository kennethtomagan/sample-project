<?php

namespace App\Services\Ticket;

use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Support\Facades\DB;

class TicketService
{
    /**
     * @var TicketRepository
     */
    private TicketRepository $ticketRepository;

    /**
     * TicketService constructor.
     *
     * @param TicketRepository $ticketRepository
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Create a new ticket.
     *
     * @param array $data
     * @param string $creatorId - UUID string value
     * @return Ticket 
     */
    public function createTicket(array $data, string $creatorId): Ticket
    {
        $data['creator_id'] = $creatorId;
        return $this->ticketRepository->create($data);
    }

    /**
     * Get a ticket by its ID with relationships.
     *
     * @param string $ticketId
     * @return Ticket
     */
    public function getTicketWithRelations(string $ticketId): Ticket
    {
        return $this->ticketRepository->findWithRelations($ticketId);
    }

    /**
     * Update a ticket.
     *
     * @param Ticket $ticket
     * @param array $data
     * @return Ticket
     */
    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        $this->ticketRepository->update($ticket, $data);
        return $ticket;
    }

    /**
     * Delete a ticket.
     *
     * @param Ticket $ticket
     * @return bool|null
     */
    public function deleteTicket(Ticket $ticket): ?bool
    {
        return $this->ticketRepository->delete($ticket);
    }

    /**
     * Assign users to a ticket.
     *
     * @param Ticket $ticket
     * @param array $userEmails
     * @return Ticket
     */
    public function assignUsersToTicket(Ticket $ticket, array $userEmails): Ticket
    {
        $users = User::whereIn('email', $userEmails)->pluck('id')->toArray();
        $this->ticketRepository->syncMembers($ticket, $users);

        // Here you can add logic to send emails to users who are not signed up

        return $ticket;
    }

    /**
     * Move a ticket to a different board or rank.
     *
     * @param array $data
     * @param Ticket $ticket
     * @return Ticket
     * @throws \Exception
     */
    public function moveTicket(array $data, Ticket $ticket): Ticket
    {
        $currentBoardId = $ticket->board_id;
        $newBoardId = $data['board_id'] ?? null;
        $newRank = $data['rank'];

        try {
            DB::beginTransaction();

            $isSameBoard = ($currentBoardId == $newBoardId) || !$newBoardId;

            if ($isSameBoard && $ticket->rank < $newRank) {
                $this->ticketRepository->decrementRanks($ticket->board_id, $ticket->rank + 1, $newRank);
            } elseif ($isSameBoard && $ticket->rank > $newRank) {
                $this->ticketRepository->incrementRanks($ticket->board_id, $newRank, $ticket->rank - 1);
            } elseif (!$isSameBoard) {
                // Adjust ranks in the old board
                $this->ticketRepository->decrementRanks($currentBoardId, $ticket->rank + 1, PHP_INT_MAX);

                // Adjust ranks in the new board
                $this->ticketRepository->incrementRanks($newBoardId, $newRank, PHP_INT_MAX);
            }

            $ticket = $this->ticketRepository->updateBoardAndRank($ticket, $newBoardId, $newRank);

            DB::commit();
            return $ticket;
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
