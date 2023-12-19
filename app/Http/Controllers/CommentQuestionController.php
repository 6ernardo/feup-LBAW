<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\CommentQuestion;
use Illuminate\Http\Request;
use App\Models\UserVoteCommentQuestion;

use Illuminate\Support\Facades\Auth;

class CommentQuestionController extends Controller
{
    public function create(int $id, Request $request){
        $comment = new CommentQuestion();

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
        $user = User::find($comment->author_id);

        $question_id = $comment->question_id;

        $comment->delete();

        return redirect('questions/'.$question_id);
    }

    public function showEdit(int $id){

        $comment = CommentQuestion::find($id);
        $user = User::find($comment->author_id);

        return view('pages.editComment', ['comment' => $comment, 'type' => 'question']);
    }

    public function edit(int $id, Request $request){

        $comment = CommentQuestion::find($id);
        $user = User::find($comment->author_id);

        $request->validate([
            'content' => 'string'
        ]);

        $comment->content = $request->input('content');

        $comment->save();

        return redirect('questions/'.$comment->question_id);
    }

    public function vote(Request $request) {
        $validatedData = $request->validate([
            'comment_id' => 'required|exists:comment_question,comment_id',
            'vote' => 'required|integer'
        ]);
    
        $userId = Auth::id();
        $commentId = $validatedData['comment_id'];
        $voteValue = (int) $validatedData['vote'];

        
        $voteValue = $voteValue === 1 ? 1 : -1;
        
        UserVoteCommentQuestion::updateOrCreate(
            ['user_id' => $userId, 'comment_id' => $commentId],
            ['vote' => $voteValue]
        );
        
        return response('Voto registrado com sucesso', 200);
    }

    public function RemoveVote(Request $request){
        $validatedData = $request->validate([
            'comment_id' => 'required|exists:comment_question,comment_id',
        ]);
    
        $userId = Auth::id();
        $commentId = $validatedData['comment_id'];
    
        // Encontrar e remover o voto
        UserVoteCommentQuestion::where('user_id', $userId)->where('comment_id', $commentId)->delete();
    
        return response('Voto removido com sucesso', 200);
    }
}
