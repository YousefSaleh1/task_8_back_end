<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::all();
        $data = NoteResource::collection($notes);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a new note for the employee.
     *
     * This method creates a new note for the specified employee, using the provided request data.
     *
     * @param  StoreNoteRequest  $request
     * @param  Employee  $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeeStore(StoreNoteRequest $request, Employee $employee)
    {
        try {
            $note = $employee->notes()->create([
                'title' => $request->title,
                'body' => $request->body
            ]);
            $data = new NoteResource($note);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed To Create', 500);
        }
    }

    /**
     * Store a new note for the department.
     *
     * This method creates a new note for the specified department, using the provided request data.
     *
     * @param  StoreNoteRequest  $request
     * @param  Department  $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function departmentStore(StoreNoteRequest $request, Department $department)
    {
        try {
            $note = $department->notes()->create([
                'title' => $request->title,
                'body' => $request->body
            ]);
            $data = new NoteResource($note);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Failed To Create', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $data = new NoteResource($note);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        try {
            $note->title = $request->input('title') ?? $note->title;
            $note->body = $request->input('body') ?? $note->body;

            $note->save();
            $data = new NoteResource($note);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return $this->customeResponse('', 'Note Deleted', 200);
    }
}
