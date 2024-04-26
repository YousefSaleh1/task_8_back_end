<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ProjectResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        $data = ProjectResource::collection($projects);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            DB::beginTransaction();
            $project = Project::create([
                'name'        => $request->name,
            ]);
            if ($request->has('employee_ids')) {
                $project->employees()->attach($request->employee_ids);
            }
            DB::commit();
            $data = new ProjectResource($project);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return $this->customeResponse(null, 'Failed To Create', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $data['projrct'] = new ProjectResource($project);
        $data['employees'] = EmployeeResource::collection($project->employees);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();
            $project->name = $request->input('name') ?? $project->name;
            if ($request->has('employee_ids')) {
                $project->employees()->sync($request->employee_ids);
            }

            DB::commit();
            $project->save();
            $data = new ProjectResource($project);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return $this->customeResponse('', 'Project Deleted', 200);
    }
}
