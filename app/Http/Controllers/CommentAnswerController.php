<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answer;

use App\Models\CommentAnswer;

use Illuminate\Support\Facades\Auth;

class CommentAnswerController extends Controller
{
    public function create(int $question_id, int $answer_id, Request $request){
        $comment = new CommentAnswer();

        $this->authorize('create', $comment);

        $request->validate([
            'content' => 'required'
        ]);

        $comment->author_id = Auth::user()->user_id;
        $comment->answer_id = $answer_id;
        $comment->content = $request->input('content');

        $comment->save();

        return redirect('questions/'.$question_id);

    }

    public function delete(int $id){

        $comment = CommentAnswer::find($id);

        $this->authorize('delete', $comment);;

        $answer = Answer::find($comment->answer_id);

        $comment->delete();

        return redirect('questions/'.$answer->question_id);
    }

    public function showEdit(int $id){

        $comment = CommentAnswer::find($id);
        
        $this->authorize('edit', $comment);

        return view('pages.editComment', ['comment' => $comment, 'type' => 'answer']);
    }

    public function edit(int $id, Request $request){

        $comment = CommentAnswer::find($id);
        
        $this->authorize('edit', $comment);

        $request->validate([
            'content' => 'string'
        ]);

        $comment->content = $request->input('content');

        $comment->save();

        $answer = Answer::find($comment->answer_id);

        return redirect('questions/'.$answer->question_id);
    }
}
