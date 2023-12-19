<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;
use App\Models\Tag;
use App\Models\UserVoteQuestion;

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
        $tags = Tag::all();

        $this->authorize('edit', $question);

        return view('pages.editQuestion', [
            'question' => $question,
            'tags' => $tags
        ]);
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

        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            $question->tags()->sync($tagIds);
        }

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
        
        $input = $request->input('search_query');
        $questions = Question::select('question.question_id', 'question.title', 'question.description')
                    ->whereRaw("tsvectors @@ to_tsquery(?)", [$input])
                    ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) ASC", [$input])
                    ->get();
 
        return response()->json($questions);
        
    }

    public function vote(Request $request){
        $validatedData = $request->validate([
            'question_id' => 'required|exists:question,question_id',
            'vote' => 'required|integer'
        ]);

        $userId = Auth::id();
        $questionId = $validatedData['question_id'];
        $voteValue = (int) $validatedData['vote'];

        $voteValue = $voteValue === 1 ? 1 : -1;

        UserVoteQuestion::updateOrCreate(
            ['user_id' => $userId ,'question_id' => $questionId],
            ['vote' => $voteValue]
        );

        return response('Voto registrado com sucesso', 200);
    }

    public function RemoveVote(Request $request){
        $validatedData = $request->validate([
            'question_id' => 'required|exists:question,question_id',
        ]);
    
        $userId = Auth::id();
        $questionId = $validatedData['question_id'];
    
        UserVoteQuestion::where('user_id', $userId)->where('question_id', $questionId)->delete();
    
        return response('Voto removido com sucesso', 200);
    }

}

