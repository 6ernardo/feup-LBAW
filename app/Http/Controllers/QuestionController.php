<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller{

    public function create(){
        $this->authorize('show_create', Question::class);

        return view('pages.createQuestion');
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

}
