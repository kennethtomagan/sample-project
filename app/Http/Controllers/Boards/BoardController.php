<?php

namespace App\Http\Controllers\Boards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Board\BoardCreateRequest;
use App\Http\Resources\Board\BoardResource;
use App\Models\Board;
use App\Services\Ticket\Board\BoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * @var BoardService
     */
    private BoardService $boardService;

    /**
     * BoardController constructor.
     *
     * @param BoardService $boardService
     */
    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    /**
     * Store a new board.
     *
     * @param BoardCreateRequest $request
     * @return BoardResource
     */
    public function store(BoardCreateRequest $request): BoardResource
    {
        $data = $request->validated();

        $board = $this->boardService->createBoard($data);

        return new BoardResource($board);
    }

    /**
     * Update the specified board.
     *
     * @param Board $board
     * @param BoardCreateRequest $request
     * @return BoardResource
     */
    public function update(Board $board, BoardCreateRequest $request): BoardResource
    {
        $updatedBoard = $this->boardService->updateBoard($board, $request->validated());

        return new BoardResource($updatedBoard);
    }

    /**
     * Delete the specified board.
     *
     * @param Board $board
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Board $board, Request $request)
    {
        $this->boardService->deleteBoard($board, $request->user()->id);

        return response()->json(['message' => 'Board deleted successfully']);
    }
}
