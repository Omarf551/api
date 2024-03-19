<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        $list = [];
    
        foreach($categories as $category)
        {
            $object = 
            [
                "id" => $category->id,
                "id_game" => $category->id_game,
                "genre" => $category->Genere,
                "created_at"=> $category->created_at,
                "updated_at" => $category->updated_at,
            ];
            array_push($list, $object);
        }
    
        return response()->json($list);
    
    }

    public function categoryId($id)
    {
        $category = Category::where('id', '=', $id)->first();
        $object = null;
    
        if ($category) {
            $object = [
                "id" => $category->id,
                "id_game" => $category->id_game,
                "genre" => $category->genre,
                "created_at" => $category->created_at,
                "updated_at" => $category->updated_at,
            ];
        }
    
        return response()->json($object);
    }

}
