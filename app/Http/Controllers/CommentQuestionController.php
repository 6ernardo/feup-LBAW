<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\CommentQuestion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CommentQuestionController extends Controller
{
    public function create(int $id, Request $request){
        $comment = new CommentQuestion();

        $this->authorize('create', $comment);

        $request->validate([
            'content' => 'required'
        ]);

        $comment->author_id = Auth::user()->user_id;
        $comment->question_id = $id;
        $comment->content = $request->input('content');

        $comment->save();

        return redirect('questions/'.$id);

    }

    public function delete(int $id){

        $comment = CommentQuestion::find($id);
        
        $this->authorize('delete', $comment);;

        $question_id = $comment->question_id;

        $comment->delete();

        return redirect('questions/'.$question_id);
    }

    public function showEdit(int $id){

        $comment = CommentQuestion::find($id);
        
        $this->authorize('edit', $comment);

        return view('pages.editComment', ['comment' => $comment, 'type' => 'question']);
    }

    public function edit(int $id, Request $request){

        $comment = CommentQuestion::find($id);

        $this->authorize('edit', $comment);

        $request->validate([
            'content' => 'string'
        ]);

        $comment->content = $request->input('content');

        $comment->save();

        return redirect('questions/'.$comment->question_id);
    }
}
