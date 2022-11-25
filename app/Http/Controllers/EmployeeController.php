<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Returns array of employees
    public function list() {
        return ['status' => true, 'data' => Employee::with(['employeeTitle', 'employeeFunction'])->get()];
    }

    // Returns a single employee based on ID
    public function get(Request $request, $employeeId) {
        $employee = Employee::where('id', $employeeId)->with(['employeeTitle', 'employeeFunction'])->first();

        if (!$employee) {
            return ['status' => false, 'errors' => ['Employee not found']];
        }

        return ['status' => true, 'data' => $employee];
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'function_id' => 'required|exists:employee_functions,id',
            'title_id' => 'required|exists:employee_titles,id',
            'workshop_id' => 'required|exists:workshops,id',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:employees,email|max:350',
        ]);

        // Validate user has right to add
        
        if ($validator->fails()) {
            return ['status' => false, 'errors' => $validator->errors()];
        }

        try {
            $employee = Employee::create($request->all());
            $employee->function_id = $request->input('function_id');
            $employee->title_id = $request->input('title_id');
            $employee->save();

            return ['status' => true];
        } catch (\Throwable $t) {
            return ['status' => false, 'error' => $t->getMessage()];
        }

        
    }

    public function update(Request $request, $employeeId) {
        $employee = Employee::where('id', $employeeId)->first();

        if (!$employee) {
            return ['status' => false, 'errors' => ['Employee not found']];
        }
        $validator = Validator::make($request->all(), [
            'function_id' => 'exists:employee_functions,id',
            'title_id' => 'exists:employee_titles,id',
            'workshop_id' => 'exists:workshops,id',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'email|unique:employees,email|max:350',
        ]);

        // Validate user has right to change
        try {
            if ($validator->fails()) {
                return ['status' => false, 'errors' => $validator->errors()];
            }

            $employee->fill($request->all());

            return ['status' => $employee->save()];

        } catch (\Throwable $t) {
            return ['status' => false, 'error' => $t->getMessage()];
        }
    }

    public function delete(Request $request) {
        $employee = Employee::where('id', $employeeId)->first();

        if (!$employee) {
            return ['status' => false, 'errors' => ['Employee not found']];
        }

        // Validate user has right to delete

        return ['status' => $employee->delete()];
    }
}
