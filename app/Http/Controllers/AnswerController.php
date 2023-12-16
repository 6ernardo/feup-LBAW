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
}
