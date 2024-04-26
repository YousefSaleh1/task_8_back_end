<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\NoteResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class DepartmentController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        $data = DepartmentResource::collection($departments);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            $department = Department::create([
                'name'        => $request->name,
                'description' => $request->description
            ]);
            $data = new DepartmentResource($department);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed To Create', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $data['depatment'] = new DepartmentResource($department);
        $data['employees'] = EmployeeResource::collection($department->employees);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        try {
            $department->name = $request->input('name') ?? $department->name;
            $department->description = $request->input('description') ?? $department->description;

            $department->save();
            $data = new DepartmentResource($department);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return $this->customeResponse('', 'Department Deleted', 200);
    }

    /**
     * Display a list of deleted departments.
     *
     * This method retrieves a list of departments that have been soft deleted.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDeleted()
    {
        $departments = Department::onlyTrashed()->get();
        $data = DepartmentResource::collection($departments);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Restore a deleted department.
     *
     * This method restores a previously deleted department.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function departmentRestore(string $id)
    {
        try {
            $department = Department::withTrashed()->findOrFail($id);
            $department->restore();
            $data = new DepartmentResource($department);
            return $this->customeResponse($data, 'done!', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Something Error...!",500);
        }
    }

    /**
     * Permanently delete a department.
     *
     * This method permanently deletes a department from the database.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(string $id)
    {
        try {
            $department = Department::withTrashed()->findOrFail($id);
            $department->forceDelete();
            return $this->customeResponse('', 'Department Deleted Permanently', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Something Error...!",500);
        }
    }
}
