<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Repositories\Project\ProjectRepository;
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
     * @param string $userId - UUID string value
     * @return Collection
     */
    public function getUserProjects(string $userId): Collection
    {
        return $this->projectRepository->getUserProjects($userId);
    }

    /**
     * Create a new project for a user.
     *
     * @param string $userId - UUID string value
     * @param array $data
     * @return Project
     */
    public function createUserProject(string $userId, array $data): Project
    {
        $values = [
            ...$data,
            'user_id' => $userId,
        ];

        return $this->projectRepository->create($values);
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
     * @param string $userId - UUID string value
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, string $userId, array $data): Project
    {
        if ($project->user_id !== $userId) {
            abort(403, "You are not allowed to update this project");
        }

        $this->projectRepository->update($project, $data);
        return $project;
    }

    /**
     * Delete the specified project.
     *
     * @param Project $project
     * @param string $userId - UUID string value
     * @return bool|null
     */
    public function deleteProject(Project $project, string $userId): ?bool
    {
        if ($project->user_id !== $userId) {
            abort(403, "You are not allowed to delete this project");
        }

        return $this->projectRepository->delete($project);
    }
}
