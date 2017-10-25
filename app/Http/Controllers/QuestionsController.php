<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('questions.index',compact('questions'));
    }

    public function index1()
    {
        $questions = Question::all();
        return view('questions.index1',compact('questions'));
    }

    public function add(Request $request)
    {
        Question::create([
            'question' => $request->question
        ]);

        return back();
    }
}
