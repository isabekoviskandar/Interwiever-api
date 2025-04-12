<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;


class InterviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/interviews",
     *     summary="Get all interviews",
     *     tags={"Interviews"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all interviews",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="slug", type="string", example="javascript-basics"),
     *                 @OA\Property(property="title", type="string", example="JavaScript Basics Interview"),
     *                 @OA\Property(property="description", type="string", example="Basic JavaScript interview questions and answers"),
     *                 @OA\Property(property="category_id", type="integer", example=2),
     *                 @OA\Property(property="level", type="string", example="Beginner"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $interviews = Interview::all();
        return response()->json($interviews);
    }

    /**
     * @OA\Post(
     *     path="/api/interviews",
     *     summary="Create a new interview",
     *     tags={"Interviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"slug", "title", "description", "category_id", "level"},
     *             @OA\Property(property="slug", type="string", example="javascript-basics"),
     *             @OA\Property(property="title", type="string", example="JavaScript Basics Interview"),
     *             @OA\Property(property="description", type="string", example="Basic JavaScript interview questions and answers"),
     *             @OA\Property(property="category_id", type="integer", example=2),
     *             @OA\Property(property="level", type="string", example="Beginner")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Interview created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="slug", type="string", example="javascript-basics"),
     *             @OA\Property(property="title", type="string", example="JavaScript Basics Interview"),
     *             @OA\Property(property="description", type="string", example="Basic JavaScript interview questions and answers"),
     *             @OA\Property(property="category_id", type="integer", example=2),
     *             @OA\Property(property="level", type="string", example="Beginner"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="slug",
     *                     type="array",
     *                     @OA\Items(type="string", example="The slug has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/interviews/{id}",
     *     summary="Update an existing interview",
     *     tags={"Interviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Interview ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="slug", type="string", example="updated-javascript-basics"),
     *             @OA\Property(property="title", type="string", example="Updated JavaScript Basics Interview"),
     *             @OA\Property(property="description", type="string", example="Updated JavaScript interview questions and answers"),
     *             @OA\Property(property="category_id", type="integer", example=3),
     *             @OA\Property(property="level", type="string", example="Intermediate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interview updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="slug", type="string", example="updated-javascript-basics"),
     *             @OA\Property(property="title", type="string", example="Updated JavaScript Basics Interview"),
     *             @OA\Property(property="description", type="string", example="Updated JavaScript interview questions and answers"),
     *             @OA\Property(property="category_id", type="integer", example=3),
     *             @OA\Property(property="level", type="string", example="Intermediate"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interview not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Interview] 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="slug",
     *                     type="array",
     *                     @OA\Items(type="string", example="The slug has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/interviews/{id}",
     *     summary="Delete an interview",
     *     tags={"Interviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Interview ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Interview deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interview not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Interview] 1")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);

        $interview->delete();

        return response()->json(null, 204);
    }
}