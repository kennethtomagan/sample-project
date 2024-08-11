<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\BaseRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    /**
     * ProjectRepository constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        parent::__construct($project);
        $this->model = $project;
    }

    /**
     * Get all projects for a user.
     *
     * @param string $userId - UUID string value
     * @return Collection
     */
    public function getUserProjects(string $userId): Collection
    {
        return Project::where('user_id', $userId)->get();
    }

    /**
     * Get a specific project with its related boards and tickets.
     *
     * @param Project $project
     * @return Project
     */
    public function getProjectWithRelations(Project $project): Project
    {
        return $project->load(['boards', 'boards.tickets']);
    }
}
