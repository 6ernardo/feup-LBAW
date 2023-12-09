<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function show($id){
        $tag = Tag::find($id);
        
        return view('pages.showTag', [
            'tag' => $tag
        ]);
    }

    public function list(){
        $tags = Tag::all();

        return view('pages.tagList', [
            'tags' => $tags
        ]);
    }

    public function showEdit(int $id){
        $tag = Tag::find($id);


        return view('pages.editTag', ['tag' => $tag]);
    }

    public function editTag(int $id, Request $request){
        $tag = Tag::find($id);
    
        if($request->has('name')){
            $request->validate([
                'name' => 'string|max:255',
            ]);
            $tag->name = $request->input('name');
        }
    
        if($request->has('description')){
            $request->validate([
                'description' => 'string',
            ]);
            $tag->description = $request->input('description');
        }
    
            $tag->save();
            return redirect('tags/'.$tag->tag_id)->with('success', 'Tag updated successfully.');
    }

    public function showCreateTag(){
        //policy

        return view('pages.createTag');
    }

    public function createTag(Request $request){
        //policy

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('tags/'.$tag->tag_id);
    }

    public function deleteTag(int $id){

        $tag = Tag::find($id);
        $tag->delete();

        return redirect('/tags');
    }
}
