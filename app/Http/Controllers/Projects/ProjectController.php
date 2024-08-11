<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Services\Ticket\Project\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    private ProjectService $projectService;

    /**
     * ProjectController constructor.
     *
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the user's projects.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $projects = $this->projectService->getUserProjects($request->user()->id);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project.
     *
     * @param ProjectCreateRequest $request
     * @return ProjectResource
     */
    public function store(ProjectCreateRequest $request): ProjectResource
    {
        $data = $request->validated();

        $project = $this->projectService->createUserProject($request->user()->id, $data);

        return new ProjectResource($project);
    }

    /**
     * Display the specified project.
     *
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        $projectWithRelations = $this->projectService->getProjectWithRelations($project);

        return new ProjectResource($projectWithRelations);
    }

    /**
     * Update the specified project.
     *
     * @param Project $project
     * @param ProjectCreateRequest $request
     * @return ProjectResource
     */
    public function update(Project $project, ProjectCreateRequest $request): ProjectResource
    {
        $data = $request->validated();

        $updatedProject = $this->projectService->updateProject($project, $request->user()->id, $data);

        return new ProjectResource($updatedProject);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Project $project, Request $request)
    {
        $this->projectService->deleteProject($project, $request->user()->id);

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}
