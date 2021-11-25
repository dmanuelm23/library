<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = 1;
        $category->save();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data successfully saved',
            'id' => $category->id,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data successfully modified',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'statusCode'=>200,
            'message' =>'Data deleted successfully'
        ]); 
    }

    public function listCategoryFilter(Request $request)
    {
        $name = $request->name;
        $description = $request->description;
        $categories =  Category::select([
            'categories.id as id',
            'categories.name as name',
            'categories.description as description',
            'categories.status as status',
            'categories.created_at as created_at'
        ])
        ->when( $name, function($query) use ( $name){
            return $query->where('categories.name', 'like', '%'. $name.'%');
        })
        ->when($description, function($query) use ($description){
            return $query->orWhere('categories.description', 'like', '%'.$description.'%');
        })
        ->latest()
        ->paginate(12);

        return [
            'pagination' =>  [
                'total'         =>  $categories->total(),
                'current_page'  =>  $categories->currentPage(),
                'per_page'      =>  $categories->perPage(),
                'last_page'     =>  $categories->lastPage(),
                'from'          =>  $categories->firstItem(),
                'to'            =>  $categories->lastPage(),
            ],
            'categories' => $categories
        ];
        
    }

    public function banned($id)
    {
        $category = Category::findOrFail($id);
        $category->toggleStatus();
        return response()->json('ok');
    }
}
