<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::with('ratings')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => required,
            'author' => required,
            'description' => required
        ]);

        $book = new Book();
        $book->user_id = $request->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->save();

        return new BookResource($book);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::whereId($id)->get();

        return response()->json(['data' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // check if currently authenticated user is the owner of the book

      if ($request->user()->id !== $book->user_id) {
        return response()->json(['error' => 'You can only edit your own books.'], 403);
      }

      $book->update($request->only(['title','author', 'description']));

      return new BookResource($book);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Book $book)
    {
        if($request->user()->id != $book->user_id){
            return response()->json(['error' => 'You can only delete your own books.',
             'user_id' =>$request->user()->id,
             'book_user_id' =>$book->user_id], 403);
          }
            $book ->delete();
            return response()->json(null,204);
    }
}
