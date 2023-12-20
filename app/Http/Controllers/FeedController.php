<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class FeedController extends Controller{
    public function index(){
    	$topQuestions = Question::orderBy('score','desc')->get();
        $newQuestions = Question::orderBy('timestamp', 'desc')->get();

        /*$questionId = 1; 
        $newScore = 7; 

        $question = Question::find($questionId);
        if ($question) {
            $question->score = $newScore;
            $question->save();
        }
        */

        return view('pages.feed', [
            'topQuestions' => $topQuestions,
            'newQuestions' => $newQuestions
        ]);
    }
}
