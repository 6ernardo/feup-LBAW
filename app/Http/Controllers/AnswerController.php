<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\UserVoteAnswer;

class AnswerController extends Controller
{
    public function create(int $id, Request $request){

        $answer = new Answer();

        $this->authorize('create', $answer);
        
        $request->validate([
            'description' => 'required'
        ]);

        $answer->author_id = Auth::user()->user_id;
        $answer->question_id = $id;
        $answer->description = $request->input('description');

        $answer->save();

        return redirect('questions/'.$id);
        
    }

    public function delete(int $id){

        $answer = Answer::find($id);

        $this->authorize('delete', $answer);

        //delete comments under answer

        $question_id = $answer->question_id;

        $answer->delete();

        return redirect('questions/'.$question_id);
    }

    public function showEdit(int $id){

        $answer = Answer::find($id);

        $this->authorize('edit', $answer);

        return view('pages.editAnswer', ['answer' => $answer]);
    }

    public function edit(int $id, Request $request){

        $answer = Answer::find($id);

        $this->authorize('edit', $answer);

        $request->validate([
            'description' => 'string'
        ]);

        $answer->description = $request->input('description');

        $answer->save();

        return redirect('questions/'.$answer->question_id);
    }

    public function vote(Request $request) {
        $validatedData = $request->validate([
            'answer_id' => 'required|exists:answer,answer_id',
            'vote' => 'required|integer'
        ]);
    
        $userId = Auth::id();
        $answerId = $validatedData['answer_id'];
        $voteValue = (int) $validatedData['vote'];

        
        $voteValue = $voteValue === 1 ? 1 : -1;
        
        UserVoteAnswer::updateOrCreate(
            ['user_id' => $userId, 'answer_id' => $answerId],
            ['vote' => $voteValue]
        );
        
        return response('Voto registrado com sucesso', 200);
    }

    public function RemoveVote(Request $request){
        $validatedData = $request->validate([
            'answer_id' => 'required|exists:answer,answer_id',
        ]);
    
        $userId = Auth::id();
        $answerId = $validatedData['answer_id'];
    
        // Encontrar e remover o voto
        UserVoteAnswer::where('user_id', $userId)->where('answer_id', $answerId)->delete();
    
        return response('Voto removido com sucesso', 200);
    }


}

    
