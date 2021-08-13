<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
    	return Category::all();
    }

    public function show($category_id)
    {
    	return Category::find($category_id);
    }

    public function store(Request $request) {        
        $validator = $this->storeValidator($request->all());
        if($validator->fails()){
              return  $validator->messages();
        }
        $category = Category::create([
            'category_name_th' => $request->category_name_th,
            'category_name_en' => $request->category_name_en,
            'category_description' => $request->category_description,
            'category_status' => $request->category_status,
        ]);
    	return $category;
    }

    public function update(Request $request, $category_id) {        
        $category = Category::where('id', $category_id)
                    ->update([
                        'category_name_th' => $request->category_name_th,
                        'category_name_en' => $request->category_name_en,
                        'category_description' => $request->category_description,
                        'category_status' => $request->category_status,
                    ]);
        return $category;
    }

    public function delete($category_id)
    {
        $category = Category::where('id', $category_id)
                    ->delete();
        return $category;
    }

    public function storeValidator($data)
    {
        $messages = [
            'category_name_th.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'category_name_th.unique' => 'มีชื่อหมวดหมู่นี้แล้ว',
        ];

        $validator = Validator::make($data, [
          'category_name_th' => 'required|unique:categories',
        ], $messages);

        return $validator;
    }


}
