<?php

namespace App\Http\Traits;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;

trait GetNoteItemTrait
{
    public function getItem($noteablType, $noteablId)
    {

        switch ($noteablType) {
            case 'App\Models\Department':
                $department = Department::findOrFail($noteablId);
                return ['item_type' => 'Department',new DepartmentResource($department)];
                break;
            case 'App\Models\Employee':
                $employee= Employee::findOrFail($noteablId);
                return ['item_type' => 'Employee',new EmployeeResource($employee)];
                break;
            default:
                return 'Not Found!';
                break;
        }
    }
}
