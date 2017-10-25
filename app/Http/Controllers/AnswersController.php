<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function add(Request $request)
    {
        if($request->parent_id) {
            $answer = Answer::find($request->parent_id);
            $answer->answers()->create([
               'answer' => $request->answer,
                'question_id' => $request->question_id
            ]);

            return back();
        }

        $question = Question::find($request->question_id);
        $question->answers()->create([
           'answer' => $request->answer,
            'parent_id' => 0
        ]);

        return back();
    }
}
