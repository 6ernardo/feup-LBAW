<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function show($id){
        $tag = Tag::find($id);

        $this->authorize('show', $tag);
        
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

        $this->authorize('edit', $tag);

        return view('pages.editTag', ['tag' => $tag]);
    }

    public function editTag(int $id, Request $request){
        $tag = Tag::find($id);

        $this->authorize('edit', $tag);

        if($request->name){
            $request->validate([
                'name' => 'string|max:255',
            ]);
            $tag->name = $request->input('name');
        }

        if($request->description){
            $request->validate([
                'description' => 'string',
            ]);
            $tag->description = $request->input('description');
        }
    
        $tag->save();
        return redirect('admindashboard');
    }

    public function showCreateTag(){
        $this->authorize('create', Tag::class);

        return view('pages.createTag');
    }

    public function createTag(Request $request){
        $this->authorize('create', Tag::class);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('admindashboard');
    }

    public function deleteTag(int $id){
        $tag = Tag::find($id);

        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect('admindashboard');
    }
}
