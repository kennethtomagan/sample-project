<?php

namespace App\Repositories\Board;

use App\Models\Board;
use App\Repositories\BaseRepository;
use App\Repositories\Board\BoardRepositoryInterface;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{

    /**
     * BoardRepository constructor.
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        parent::__construct($board);
        $this->model = $board;
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
