<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
        $user = User::find($answer->author_id);

        $this->authorize('delete', $answer);

        //delete comments under answer

        $question_id = $answer->question_id;

        $answer->delete();

        return redirect('questions/'.$question_id);
    }

    public function showEdit(int $id){

        $answer = Answer::find($id);
        $user = User::find($answer->author_id);

        $this->authorize('edit', $answer);

        return view('pages.editAnswer', ['answer' => $answer]);
    }

    public function edit(int $id, Request $request){

        $answer = Answer::find($id);
        $user = User::find($answer->author_id);

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
            'answer_id' => 'required|exists:answers,id',
            'vote' => 'required|in:up,down'
        ]);

        $answerId = $validatedData['answer_id'];
        $voteType = $validatedData['vote'] === 'up' ? 1 : -1;
        $userId = Auth::id();

        // Verificar se o usuário já votou na resposta
        $existingVote = UserVoteAnswer::where('user_id', $userId)->where('answer_id', $answerId)->first();
        if ($existingVote && $existingVote->vote === $voteType) {
            return response()->json(['message' => 'Você já votou dessa maneira nesta resposta.'], 409); // Código de status 409 - Conflito
        }

        // Atualizar ou criar o voto
        UserVoteAnswer::updateOrCreate(
            ['user_id' => $userId, 'answer_id' => $answerId],
            ['vote' => $voteType]
        );

        $answer = Answer::find($answerId);
        $newVoteCount = $answer->getVoteCount();

        //  nova contagem
        return response()->json(['newVoteCount' => $newVoteCount]);
    }
}

    
