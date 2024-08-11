<?php

namespace App\Repositories\Board;

use App\Models\Board;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BoardRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Load relationships for the specified board.
     *
     * @param Board $board
     * @param array $relations
     * @return Board
     */
    public function loadRelations(Board $board, array $relations): Board;
}
