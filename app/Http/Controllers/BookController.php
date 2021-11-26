<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookPost;
use App\Http\Requests\UpdateBookPut;

class BookController extends Controller
{
    /**
    * Function make a contruct
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @created 25/11/2021
    * @param 
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
    * Function to display view index.
    * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
    * @created 25/11/2021
    * @param 
    * @return \Illuminate\View\View
    */
    public function index()
    {
        return view('books.index');
    }

    /**
     * Function create new resource in storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param StoreBookPost $request
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function store(StoreBookPost $request)
    {
        $book = new Book;
        $book->name = $request->name;
        $book->author = $request->author;
        $book->publication_date = $request->publication_date;
        $book->category_id = $request->category_id;
        $book->status = 1;
        $book->save();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data successfully saved',
            'id' => $book->id,
        ]);
    }

    /**
     * Function update the specified resource in storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param UpdateBookPut $request $id
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function update(UpdateBookPut $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->name = $request->name;
        $book->author = $request->author;
        $book->publication_date = $request->publication_date;
        $book->category_id = $request->category_id;
        $book->save();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data successfully modified',
        ]);
    }

    /**  Remove the specified resource from storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
    */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data deleted successfully'
        ]); 
    }

    /**
     * Function to Display a listing of the resource.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listBookFilter(Request $request)
    {
        $categories=Category::select(['id as id', 'name as text'])->where('status', 1)->get();
        $users=User::select(['id as id', 'name as text'])->get();
        $name = $request->name;
        $author = $request->author;
        $publication_date = $request->publication_date;
        $category_id = $request->category_id;
        $books =  Book::select([
            'books.id as id',
            'books.name as name',
            'books.author as author',
            'books.publication_date as publication_date',
            'books.category_id as category_id',
            'books.status as status',
            'books.created_at as created_at',
            'categories.id as category_id',
            'categories.name as category_name'
        ])
        ->join('categories', 'categories.id', 'books.category_id')
        ->when( $name, function($query) use ( $name){
            return $query->where('books.name', 'like', '%'. $name.'%');
        })
        ->when($author, function($query) use ($author){
            return $query->orWhere('books.author', 'like', '%'.$author.'%');
        })
        ->when($publication_date, function($query) use ($publication_date){
            return $query->orWhere('books.publication_date', 'like', '%'.$publication_date.'%');
        })
        ->when($category_id, function($query) use ($category_id){
            return $query->orWhere('books.category_id', $category_id);
        })
        ->with('booksUsers')
        ->latest()
        ->paginate(12);
        return [
            'pagination' =>  [
                'total'         =>  $books->total(),
                'current_page'  =>  $books->currentPage(),
                'per_page'      =>  $books->perPage(),
                'last_page'     =>  $books->lastPage(),
                'from'          =>  $books->firstItem(),
                'to'            =>  $books->lastPage(),
            ],
            'books' => $books,
            'categories' => $categories,
            'users' => $users,
        ];
        
    }

    /** Function change the status Active o Inactive
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function banned($id)
    {
        $book = Book::findOrFail($id);
        $book->toggleStatus();
        return response()->json('ok');
    }

    /** Function change the status and add register in pivot table
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow(Request $request)
    {
        $book = Book::findOrFail($request->book_id);
        $book->status = 2;
        $book->save();
        
        $book->booksUsers()->attach($request->user_id);
        return response()->json([
            'statusCode'=>200,
            'message' =>'Book borrowed successfully'
        ]); ;
    }

    /** Function change the status and remove register in pivot table
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnBook($id)
    {
        $book = Book::findOrFail($id);
        $book->status = 1;
        $book->save();
        $book->booksUsers()->detach();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Book borrowed successfully'
        ]); ;

    }
}
