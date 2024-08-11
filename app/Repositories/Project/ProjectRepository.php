<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
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
     * Create a new project for a user.
     *
     * @param string $userId - UUID string value
     * @param array $data
     * @return Project
     */
    public function createUserProject(string $userId, array $data): Project
    {
        return Project::create(array_merge($data, ['user_id' => $userId]));
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

    /**
     * Update the specified project.
     *
     * @param Project $project
     * @param array $data
     * @return bool
     */
    public function updateProject(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    /**
     * Delete the specified project.
     *
     * @param Project $project
     * @return bool|null
     */
    public function deleteProject(Project $project): ?bool
    {
        return $project->delete();
    }
}
