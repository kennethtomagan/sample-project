<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketCreateRequest;
use App\Http\Resources\Ticket\TicketResource;
use App\Models\Ticket;
use App\Services\Ticket\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * @var TicketService
     */
    private TicketService $ticketService;

    /**
     * TicketController constructor.
     *
     * @param TicketService $ticketService
     */
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Store a new ticket.
     *
     * @param TicketCreateRequest $request
     * @return TicketResource
     */
    public function store(TicketCreateRequest $request): TicketResource
    {
        $data = $request->validated();

        $ticket = $this->ticketService->createTicket($data, $request->user()->id);

        return new TicketResource($ticket);
    }

    /**
     * Show a ticket.
     *
     * @param string $ticketId - UUID string value
     * @return TicketResource
     */
    public function show(string $ticketId): TicketResource
    {
        $ticket = $this->ticketService->getTicketWithRelations($ticketId);

        return new TicketResource($ticket);
    }

    /**
     * Update a ticket.
     *
     * @param Ticket $ticket
     * @param TicketCreateRequest $request
     * @return TicketResource
     */
    public function update(Ticket $ticket, TicketCreateRequest $request): TicketResource
    {
        $updatedTicket = $this->ticketService->updateTicket($ticket, $request->validated());

        return new TicketResource($updatedTicket);
    }

    /**
     * Delete a ticket.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ticket $ticket)
    {
        $this->ticketService->deleteTicket($ticket);

        return response()->json([
            'message' => 'Ticket deleted successfully'
        ]);
    }

    /**
     * Assign users to a ticket.
     *
     * @param Ticket $ticket
     * @param Request $request
     * @return TicketResource
     */
    public function assign(Ticket $ticket, Request $request): TicketResource
    {
        $data = $request->validate([
            'users' => ['required', 'array'],
        ]);

        $updatedTicket = $this->ticketService->assignUsersToTicket($ticket, $data['users']);

        return new TicketResource($updatedTicket);
    }

    /**
     * Move a ticket to a different board or rank.
     *
     * @param Ticket $ticket
     * @param Request $request
     * @return TicketResource
     */
    public function move(Ticket $ticket, Request $request): TicketResource
    {
        $data = $request->validate([
            'board_id' => ['nullable', 'exists:boards,id'],
            'rank' => ['required', 'integer'],
        ]);

        $movedTicket = $this->ticketService->moveTicket($data, $ticket);

        return new TicketResource($movedTicket);
    }
}
