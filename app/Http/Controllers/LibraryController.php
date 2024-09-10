<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::all();
        return response()->json($libraries);
    }

    public function show($id)
    {
        $library = Library::find($id);
        if ($library) {
            return response()->json($library);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bn' => 'required|integer',
            'name' => 'required|string',
            'book' => 'required|string',
            'status' => 'required|in:On Loan,Returned',
            'borrow_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $library = Library::create($request->all());
        return response()->json($library, 201);
    }

    public function update(Request $request, $id)
    {
        $library = Library::find($id);
        if (!$library) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'bn' => 'sometimes|required|integer',
            'name' => 'sometimes|required|string',
            'book' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:On Loan,Returned',
            'borrow_date' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $library->update($request->all());
        return response()->json($library);
    }

    public function destroy($id)
    {
        $library = Library::find($id);
        if (!$library) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $library->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
