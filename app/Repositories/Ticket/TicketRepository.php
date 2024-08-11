<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket;
use App\Repositories\BaseRepository;
use App\Repositories\Ticket\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository extends BaseRepository implements TicketRepositoryInterface
{

    /**
     * TicketRepository constructor.
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        parent::__construct($ticket);
        $this->model = $ticket;
    }

    /**
     * Get a ticket by its ID with relationships.
     *
     * @param string $ticketId - UUID string value
     * @return Ticket|null
     */
    public function findWithRelations(string $ticketId): ?Ticket
    {
        return Ticket::with('creator', 'members')->find($ticketId);
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
     * @param string $boardId - UUID string value
     * @param int $startRank
     * @param int $endRank
     * @return void
     */
    public function decrementRanks(string $boardId, int $startRank, int $endRank): void
    {
        Ticket::where('board_id', $boardId)
            ->whereBetween('rank', [$startRank, $endRank])
            ->decrement('rank');
    }

    /**
     * Increment ranks for tickets within a specified range.
     *
     * @param string $boardId - UUID string value
     * @param int $startRank
     * @param int $endRank
     * @return void
     */
    public function incrementRanks(string $boardId, int $startRank, int $endRank): void
    {
        Ticket::where('board_id', $boardId)
            ->whereBetween('rank', [$startRank, $endRank])
            ->increment('rank');
    }

    /**
     * Update ticket's board and rank.
     *
     * @param Ticket $ticket
     * @param string|null $boardId - UUID string value
     * @param int $rank
     * @return Ticket
     */
    public function updateBoardAndRank(Ticket $ticket, ?string $boardId, int $rank): Ticket
    {
        $ticket->board_id = $boardId ?? $ticket->board_id;
        $ticket->rank = $rank;
        $ticket->save();

        return $ticket;
    }
}
