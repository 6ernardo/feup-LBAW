<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller{

    public function create(){
        return view('pages.createQuestion');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $question = new Question();

        $question->author_id = Auth::user()->user_id;
        $question->title = $request->input('title');
        $question->description = $request->input('description');

        $question->save();

        return redirect('questions/'.$question->question_id);
    }

    public function show($id){
        $question = Question::find($id);
        
        return view('pages.showQuestion', [
            'question' => $question
        ]);
    }

    public function showEdit(int $id){
        $question = Question::find($id);

        //policy

        return view('pages.editQuestion', ['question' => $question]);
    }

    public function editQuestion(int $id, Request $request){
        $question = Question::find($id);

        //policy

        if($request->title){
            $request->validate([
                'title' => 'string|max:255',
            ]);
            $question->title = $request->input('title');
        }

        if($request->description){
            $request->validate([
                'description' => 'string',
            ]);
            $question->description = $request->input('description');
        }

        $question->save();
        return redirect('questions/'.$question->question_id);
    }

    public function deleteQuestion(int $id){

        $question = Question::find($id);

        //policy

        //delete answers and comments under question

        $question->delete();

        return redirect('/feed');
    }

    public function searchForm()
    {
        return view('pages.searchQuestionForm');
    }

    public function searchList(Request $request)
    {
        $input = $request->get('search') ? $request->get('search').':' : "";
        $questions = Question::select('question.title', 'question.description')
            ->whereRaw("question.tsvectors @@ to_tsquery(?)", [$input])
            ->orderByRaw("ts_rank(question.tsvectors, to_tsquery(?)) ASC", [$input])
            ->get();

        return response()->json($questions);
    }


    /*
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
    */

}

