<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Workshop;

class WorkshopController extends Controller
{
    // Returns array of workshops
    public function list() {
        return ['status' => true, 'data' => Workshop::get()];
    }

    // Returns a single workshop based on ID
    public function get(Request $request, $workshopId) {
        $workshop = Workshop::where('id', $workshopId)->first();

        if (!$workshop) {
            return ['status' => false, 'errors' => ['Workshop not found']];
        }

        return ['status' => true, 'data' => $workshop];
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'street' => 'max:255',
            'street_no' => 'max:20',
            'zipcode' => 'max:20',
            'country_code' => 'max:2',
        ]);

        // Validate user has right to add
        
        if ($validator->fails()) {
            return ['status' => false, 'errors' => $validator->errors()];
        }

        try {
            $workshop = Workshop::create($request->all());
            $workshop->function_id = $request->input('function_id');
            $workshop->title_id = $request->input('title_id');
            $workshop->save();

            return ['status' => true];
        } catch (\Throwable $t) {
            return ['status' => false, 'error' => $t->getMessage()];
        }

        
    }

    public function update(Request $request, $workshopId) {
        $workshop = Workshop::where('id', $workshopId)->first();

        if (!$workshop) {
            return ['status' => false, 'errors' => ['Workshop not found']];
        }
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'street' => 'max:255',
            'street_no' => 'max:20',
            'zipcode' => 'max:20',
            'country_code' => 'max:2',
        ]);

        // Validate user has right to change
        try {
            if ($validator->fails()) {
                return ['status' => false, 'errors' => $validator->errors()];
            }

            $workshop->fill($request->all());

            return ['status' => $workshop->save()];

        } catch (\Throwable $t) {
            return ['status' => false, 'error' => $t->getMessage()];
        }
    }

    public function delete(Request $request) {
        $workshop = Workshop::where('id', $workshopId)->first();

        if (!$workshop) {
            return ['status' => false, 'errors' => ['Employee not found']];
        }

        // Validate user has right to delete

        return ['status' => $workshop->delete()];
    }
}
