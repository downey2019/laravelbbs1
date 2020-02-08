<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request)
    {
        $topics = Topic::withOrder($request->order)->with('user','category')->where('category_id',$category->id)->paginate(15);

        return view('topics.index',compact('topics','category'));
    }
}
