<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;


class SearchQuestionController extends Controller{
    public function questionForm()
    {
        return view('pages.searchQuestionForm');
    }
    public function list(Request $request)
    {
        /*-if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');
        }-*/
        
        $questionsQuery = Question::orderBy('question_id');

        $searchQuery = $request->input('search');
        if ($searchQuery !== null) {
            // If a search query is provided, filter the cards
            $questionsQuery->where('title', 'like', "%$searchQuery%");
        }

        $questions = $questionsQuery->get();

        return view('pages.searchQuestionResults', [
            'questions' => $questions,
            'searchQuery' => $searchQuery,
        ]);
    }
    

}