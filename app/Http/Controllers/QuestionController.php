<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller{

    public function create(){
        $this->authorize('show_create', Question::class);
        $tags = Tag::all();

        return view('pages.createQuestion',  ['tags' => $tags]);
    }

    public function store(Request $request){

        $question = new Question();

        $this->authorize('create', $question);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $question->author_id = Auth::user()->user_id;
        $question->title = $request->input('title');
        $question->description = $request->input('description');
        $question->save();
        
        
        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            Log::info('Tag IDs:', ['tagIds' => $tagIds]);
            $question->tags()->sync($tagIds);
        }

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
        $user = User::find($question->author_id);

        $this->authorize('edit', $question);

        return view('pages.editQuestion', ['question' => $question]);
    }

    public function editQuestion(int $id, Request $request){
        $question = Question::find($id);
        $user = User::find($question->author_id);

        $this->authorize('edit', $question);

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
        $user = User::find($question->author_id);

        $this->authorize('delete', $question);

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
        $question = Question::select('questions.title', 'questions.description')
            ->whereRaw("questions.tsvectors @@ to_tsquery(?)", [$input])
            ->orderByRaw("ts_rank(questions.tsvectors, to_tsquery(?)) ASC", [$input])
            ->get();

            return response()->json(['questions' => $questions]);
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

