<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function create(int $id, Request $request){
        
        $request->validate([
            'description' => 'required'
        ]);

        $answer = new Answer();

        $answer->author_id = Auth::user()->user_id;
        $answer->question_id = $id;
        $answer->description = $request->input('description');

        $answer->save();

        return redirect('questions/'.$id);
        
    }

    public function delete(int $id){

        $answer = Answer::find($id);

        //policy

        //delete comments under answer

        $question_id = $answer->question_id;

        $answer->delete();

        return redirect('questions/'.$question_id);
    }

    public function showEdit(int $id){
        $answer = Answer::find($id);

        //policy

        return view('pages.editAnswer', ['answer' => $answer]);
    }

    public function edit(int $id, Request $request){
        $answer = Answer::find($id);

        //policy

        $request->validate([
            'description' => 'string'
        ]);

        $answer->description = $request->input('description');

        $answer->save();

        return redirect('questions/'.$answer->question_id);
    }
}
