<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * @param string $userId - UUID string value
     * @return Collection
     */
    public function getUserProjects(string $userId): Collection;

    /**
     * @param Project $project
     * @return Project
     */
    public function getProjectWithRelations(Project $project): Project;
}
