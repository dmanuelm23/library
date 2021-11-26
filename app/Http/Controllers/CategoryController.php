<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\UpdateCategoryPut;

class CategoryController extends Controller
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
        return view('categories.index');
    }

    /**
     * Function create new resource in storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param StoreCategoryPost $request
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function store(StoreCategoryPost $request)
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
     * Function update the specified resource in storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param UpdateCategoryPut $request $id
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function update(UpdateCategoryPut $request, $id)
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

    /**  Remove the specified resource from storage.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Function to Display a listing of the resource.
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
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

    /** Function change the status Active o Inactive
     * @author Luis Daniel Manuel Martínez | luisdaniel_23@hotmail.com
     * @created 25/11/2021
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function banned($id)
    {
        $category = Category::findOrFail($id);
        $category->toggleStatus();
        return response()->json('ok');
    }
}
