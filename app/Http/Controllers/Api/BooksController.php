<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Exception;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Books::paginate(25);
            // $total = $books->count();
            return response()->json([
              "status_code" => 200,
              "total_data" => $books -> total(),
              "data_per_page" => $books -> perPage(), 
              "last_page" => $books -> lastPage(),
              "success" => true,
              "message" => "Success Fetching Book Data",
              "next_page" => $books -> nextPageUrl(), 
              "current_page" => $books -> currentPage(), 
              "prev_page" => $books->previousPageUrl(),
              "data" => $books -> items()
            ], 200);
        } catch (Exception $error) {
            return response()->json([
              "status_code" => 500,
              "data" => null,
              "success" => false,
              "message" => "$error"
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
              "title" => "required|string|min:5|max:255",
              "description" => "required|string|min:50",
              "author" => "required|string|min:4|max:255",
            ],[
              "title.required" => "Title Cannot Be Empty",
              "title.string" => "Title Must Be A String",
              "title.min" => "Title Must Have At Least 5 Characters",
              "title.max" => "Title Must Have A Maksimum Of 255 Characters",

              "description.required" => "Description Cannot Be Empty",
              "description.string" => "Description Must Be A String",
              "description.min" => "Description Must Have At Least 50 Characters",

              "author.required" => "Author Cannot Be Empty",
              "author.string" => "Author Must Be A String",
              "author.min" => "Author Must Have At Least 4 Characters",
              "author.max" => "Author Must Have A Maksimum Of 255 Characters",
            ]);

            Books::create([
              "title" => $request->title,
              "description" => $request->description,
              "author" => $request->author,
            ]);

            return response()->json([
              "code" => 201,
              "success" => true,
              "message" => "Berhasil Menambahkan Data Post!"
            ], 201);

        } catch (Exception $error) {
            return response()->json([
              "status_code" => 422,
              "data" => null,
              "success" => false,
              "message" => "$error"
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
