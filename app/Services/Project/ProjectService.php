<?php

namespace App\Services\Ticket\Project;

use App\Models\Project;
use App\Repositories\User\Ticket\Project\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * ProjectService constructor.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Get all projects for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserProjects(int $userId): Collection
    {
        return $this->projectRepository->getUserProjects($userId);
    }

    /**
     * Create a new project for a user.
     *
     * @param int $userId
     * @param array $data
     * @return Project
     */
    public function createUserProject(int $userId, array $data): Project
    {
        return $this->projectRepository->createUserProject($userId, $data);
    }

    /**
     * Get a specific project with its related boards and tickets.
     *
     * @param Project $project
     * @return Project
     */
    public function getProjectWithRelations(Project $project): Project
    {
        return $this->projectRepository->getProjectWithRelations($project);
    }

    /**
     * Update the specified project.
     *
     * @param Project $project
     * @param int $userId
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, int $userId, array $data): Project
    {
        if ($project->user_id !== $userId) {
            abort(403, "You are not allowed to update this project");
        }

        $this->projectRepository->updateProject($project, $data);
        return $project;
    }

    /**
     * Delete the specified project.
     *
     * @param Project $project
     * @param int $userId
     * @return bool|null
     */
    public function deleteProject(Project $project, int $userId): ?bool
    {
        if ($project->user_id !== $userId) {
            abort(403, "You are not allowed to delete this project");
        }

        return $this->projectRepository->deleteProject($project);
    }
}
