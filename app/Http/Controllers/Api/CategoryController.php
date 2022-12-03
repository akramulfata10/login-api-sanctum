<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $category = Category::latest()->get();
        return response()->json([
            'data' => CategoryResource::collection($category),
            'message' => 'Post all View',
            'success' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|max:155',
        ]);

        // jek apabila error
        if ($validateData->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validateData->errors(),
                'success' => false,
            ]);
        }

        $category = Category::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
        ]);

        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'added successfully',
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'category all View',
            'success' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) {

        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|max:155',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validateData->errors(),
                'success' => false,
            ]);
        }

        $category->update([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
        ]);

        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'updated successfully',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        $category->delete();
        return response()->json([
            'data' => [],
            'message' => 'deleted successfully',
            'success' => true,
        ]);
    }
}