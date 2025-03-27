<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::all();
        return response()->json($interviews);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:interviews,slug|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|string|max:255',
        ]);

        $interview = Interview::create($validated);

        return response()->json($interview, 201);
    }

    public function update(Request $request, $id)
    {
        $interview = Interview::findOrFail($id);

        $validated = $request->validate([
            'slug' => 'sometimes|string|unique:interviews,slug,' . $id . '|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'level' => 'sometimes|string|max:255',
        ]);

        $interview->update($validated);

        return response()->json($interview);
    }

    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);

        $interview->delete();

        return response()->json(null, 204);
    }
}