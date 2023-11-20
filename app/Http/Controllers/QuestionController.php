<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller{

    public function create(){
        return view('pages.createQuestion');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $question = Question::create([
            'author_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

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

}
