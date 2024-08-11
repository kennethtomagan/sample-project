<?php

namespace App\Repositories\User\Ticket;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository
{
    /**
     * Create a new ticket.
     *
     * @param array $data
     * @return Ticket
     */
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    /**
     * Get a ticket by its ID with relationships.
     *
     * @param string $ticketId
     * @return Ticket|null
     */
    public function findWithRelations(string $ticketId): ?Ticket
    {
        return Ticket::with('creator', 'members')->find($ticketId);
    }

    /**
     * Update a ticket.
     *
     * @param Ticket $ticket
     * @param array $data
     * @return bool
     */
    public function update(Ticket $ticket, array $data): bool
    {
        return $ticket->update($data);
    }

    /**
     * Delete a ticket.
     *
     * @param Ticket $ticket
     * @return bool|null
     */
    public function delete(Ticket $ticket): ?bool
    {
        return $ticket->delete();
    }

    /**
     * Sync ticket members.
     *
     * @param Ticket $ticket
     * @param array $userIds
     * @return void
     */
    public function syncMembers(Ticket $ticket, array $userIds): void
    {
        $ticket->members()->sync($userIds);
    }


    /**
     * Decrement ranks for tickets within a specified range.
     *
     * @param int $boardId
     * @param int $startRank
     * @param int $endRank
     * @return void
     */
    public function decrementRanks(int $boardId, int $startRank, int $endRank): void
    {
        Ticket::where('board_id', $boardId)
            ->whereBetween('rank', [$startRank, $endRank])
            ->decrement('rank');
    }

    /**
     * Increment ranks for tickets within a specified range.
     *
     * @param int $boardId
     * @param int $startRank
     * @param int $endRank
     * @return void
     */
    public function incrementRanks(int $boardId, int $startRank, int $endRank): void
    {
        Ticket::where('board_id', $boardId)
            ->whereBetween('rank', [$startRank, $endRank])
            ->increment('rank');
    }

    /**
     * Update ticket's board and rank.
     *
     * @param Ticket $ticket
     * @param int|null $boardId
     * @param int $rank
     * @return Ticket
     */
    public function updateBoardAndRank(Ticket $ticket, ?int $boardId, int $rank): Ticket
    {
        $ticket->board_id = $boardId ?? $ticket->board_id;
        $ticket->rank = $rank;
        $ticket->save();

        return $ticket;
    }
}
