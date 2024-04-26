<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ProjectResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        $data = EmployeeResource::collection($employees);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $employee = Employee::create([
                'department_id' => $request->department_id,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'position'      => $request->position,
            ]);
            $data = new EmployeeResource($employee);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed To Create', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $data['employee'] = new EmployeeResource($employee);
        $data['projects'] = ProjectResource::collection($employee->projects);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->department_id = $request->input('department_id') ?? $employee->department_id;
            $employee->first_name = $request->input('first_name') ?? $employee->first_name;
            $employee->last_name = $request->input('last_name') ?? $employee->last_name;
            $employee->email = $request->input('email') ?? $employee->email;
            $employee->position = $request->input('position') ?? $employee->position;

            $employee->save();
            $data = new EmployeeResource($employee);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return $this->customeResponse('', 'Employee Deleted', 200);
    }

    /**
     * Display a list of deleted employees.
     *
     * This method retrieves a list of employees that have been soft deleted.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDeleted()
    {
        $employees = Employee::onlyTrashed()->get();
        $data = EmployeeResource::collection($employees);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Restore a deleted employee.
     *
     * This method restores a previously deleted employee.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeRestore(string $id)
    {
        try {
            $employee = Employee::withTrashed()->findOrFail($id);
            $employee->restore();
            $data = new EmployeeResource($employee);
            return $this->customeResponse($data, 'done!', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Something Error...!",500);
        }
    }

    /**
     * Permanently delete a employee.
     *
     * This method permanently deletes a employee from the database.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(string $id)
    {
        try {
            $employee = Employee::withTrashed()->findOrFail($id);
            $employee->forceDelete();
            return $this->customeResponse('', 'Employee Deleted Permanently', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Something Error...!",500);
        }
    }
}
