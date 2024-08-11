<?php

namespace App\Repositories\User\Ticket\Project\Board;

use App\Models\Board;

class BoardRepository
{
    /**
     * Create a new board.
     *
     * @param array $data
     * @return Board
     */
    public function create(array $data): Board
    {
        return Board::create($data);
    }

    /**
     * Update the specified board.
     *
     * @param Board $board
     * @param array $data
     * @return bool
     */
    public function update(Board $board, array $data): bool
    {
        return $board->update($data);
    }

    /**
     * Delete the specified board.
     *
     * @param Board $board
     * @return bool|null
     */
    public function delete(Board $board): ?bool
    {
        return $board->delete();
    }

    /**
     * Load relationships for the specified board.
     *
     * @param Board $board
     * @param array $relations
     * @return Board
     */
    public function loadRelations(Board $board, array $relations): Board
    {
        return $board->load($relations);
    }
}
