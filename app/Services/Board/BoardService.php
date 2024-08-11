<?php

namespace App\Services\Board;

use App\Models\Board;
use App\Repositories\Board\BoardRepository;

class BoardService
{
    /**
     * @var BoardRepository
     */
    private BoardRepository $boardRepository;

    /**
     * BoardService constructor.
     *
     * @param BoardRepository $boardRepository
     */
    public function __construct(BoardRepository $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * Create a new board.
     *
     * @param array $data
     * @return Board
     */
    public function createBoard(array $data): Board
    {
        return $this->boardRepository->create($data);
    }

    /**
     * Update the specified board.
     *
     * @param Board $board
     * @param array $data
     * @return Board
     */
    public function updateBoard(Board $board, array $data): Board
    {
        $this->boardRepository->update($board, $data);
        return $board;
    }

    /**
     * Delete the specified board.
     *
     * @param Board $board
     * @param string $userId - UUID string value
     * @return bool|null
     */
    public function deleteBoard(Board $board, string $userId): ?bool
    {
        $board = $this->boardRepository->loadRelations($board, ['project']);
        if ($board->project->user_id !== $userId) {
            abort(403, 'You are not allowed to delete this board');
        }

        return $this->boardRepository->delete($board);
    }
}
