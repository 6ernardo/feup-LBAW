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
}
