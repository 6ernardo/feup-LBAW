<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tag;

class FeedController extends Controller{
    public function index(){
    	$topQuestions = Question::orderBy('score','desc')->take(2)->get();
        $newQuestions = Question::orderBy('timestamp', 'desc')->take(2)->get();

        /*$questionId = 1; 
        $newScore = 7; 

        $question = Question::find($questionId);
        if ($question) {
            $question->score = $newScore;
            $question->save();
        }
        */
        if (Auth::check()) {
            $id = Auth::id();
            $user = User::find($id);

            $followed_tags = $user->followed_tags()->get();
            $followed_tag_questions = collect();
                foreach ($followed_tags as $tag) {
                     $followed_tag_questions = $followed_tag_questions->merge($tag->questions);
                }
            
            $followed_questions = $user->followed_questions()->get();

            $followed = $followed_tag_questions->merge($followed_questions);
            
            return view('pages.feed', [
                'topQuestions' => $topQuestions,
                'newQuestions' => $newQuestions,
                'followedQuestions' => $followed
            ]);
        }
        else{
            return view('pages.feed', [
                'topQuestions' => $topQuestions,
                'newQuestions' => $newQuestions
            ]);
        }
    }
}
