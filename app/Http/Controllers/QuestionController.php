<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller{

    public function create(){
    return view('questions.create');
}

public function store(Request $request){
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
    ]);

    Question::create([
        'author_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect('/feed')->with('success', 'Pergunta criada com sucesso!');

    }
}
