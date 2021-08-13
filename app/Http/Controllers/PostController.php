<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
    	return Post::all();
    }

    public function show($post_id)
    {
    	return Post::find($post_id);
    }

    public function store(Request $request)
    {
    	$validator = $this->storeValidator($request->all());
    	if($validator->fails()){
            return  $validator->messages();
        }
    	$file_name = $this->uploadFile($request);
    	$post = Post::create([
    		'post_name_th' => $request->post_name_th,
	    	'post_name_en' => $request->post_name_en,
	    	'post_description' => $request->post_description,
	    	'image' => $file_name,
	    	'category_id' => $request->category_id,
    	]);
    	return $post;
    }

    public function update(Request $request, $post_id)
    {
    	$post = Post::find($post_id);
    	if($request->hasfile('image')) {
    		$file_name = $this->uploadFile($request);
    		if ($post->image != '') {
	            @unlink(public_path().'/images/posts/'. $post->image);
	        }
    	} else {
    		$file_name = $post->image;
    	}
    	$postUpdate = Post::where('id', $post_id)
    			->update([
    				'post_name_th' => $request->post_name_th,
			    	'post_name_en' => $request->post_name_en,
			    	'post_description' => $request->post_description,
			    	'image' => $file_name,
			    	'category_id' => $request->category_id,
    			]);
    	return $postUpdate;
    }

    public function delete($post_id)
    {
    	$post = Post::where('id', $post_id)->delete();
    	if(!$post) {
    		return response()->json(['data' => 'เกิดข้อผิดพลาดระหว่างลบข้อมูล'], 404);
    	}
    	return response()->json(['data' => 'ลบข้อมูลเรียบร้อยแล้ว'], 201);;
    }

    public function uploadFile($request)
    {
    	if($request->hasfile('image')) {
            $file = $request->file('image');
    		$exe = $file->getClientOriginalExtension();
            $file_name = md5(time()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/posts/'), $file_name);

    	} else {
    		$file_name = '';
    	}
    	return $file_name;
    }

    public function storeValidator($data)
    {
        $messages = [
            'post_name_th.required' => 'กรุณากรอกชื่อ',
            'post_name_th.unique' => 'มีชื่อนี้แล้ว',
            'category_id.exists' => 'ไม่พบหมวดหมู่ที่ต้องการ',
        ];

        $validator = Validator::make($data, [
          'post_name_th' => 'required|unique:posts',
          'category_id' => 'required|exists:categories,id',
          'image' =>  'mimes:jpeg,jpg,png|required'
        ], $messages);

        return $validator;
    }
}
