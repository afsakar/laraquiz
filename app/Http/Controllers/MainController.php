<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $quizzes = Quiz::where('status', 'published')->where(function ($query){
            $query->whereNull('finished_at')->orWhere('finished_at', '>', now());
        })->withCount('questions')->paginate('5');
        $results = Auth::user()->results;

        return view('dashboard', compact('quizzes','results'));
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function quizDetail($slug)
    {
        $quiz = Quiz::where('slug', $slug)->with('myResult', 'topTen.user')->withCount('questions')->first() ?? abort('404', __('quiz.notFound'));
        return view('pages.quiz_detail', compact('quiz'));
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function quizJoin($slug)
    {

        $quiz = Quiz::where('slug', $slug)->with('questions', 'myResult')->first() ?? abort('404', __('quiz.notFound'));

        if($quiz->myResult){
            return view('pages.quiz_result', compact('quiz'));
        }

        if($quiz->finished_at && $quiz->finished_at > now()){
           return redirect()->route('quiz.detail', $slug)->withDanger("Quiz ".date('d/m/Y', strtotime($quiz->created_at))." tarihinde sonlandı.");
        }

        return view('pages.quiz_join', compact('quiz'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return mixed
     */
    public function quizResult(Request $request, $slug)
    {
        $quiz = Quiz::with('questions')->where('slug', $slug)->first() ?? abort('404', __('quiz.notFound'));

        $correct = 0;
        $wrong = 0;
        $score = 0;

        if($quiz->myResult){
            abort('404', __("Bu Quiz'e daha önce katıldınız!"));
        }

        foreach ($quiz->questions as $question) {
            Answer::create([
                'user_id' => Auth::user()->id,
                'question_id' => $question->id,
                'answer' => $request->post($question->id),
            ]);

            if ($question->correct_answer === $request->post($question->id)) {
                $correct = $correct + 1;
            } else {
                $wrong = $wrong + 1;
            }
        }

        $score = round((100 / count($quiz->questions)) * $correct);

        Result::create([
            'user_id' => Auth::user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'correct' => $correct,
            'wrong' => $wrong,
        ]);

        return redirect()->route('quiz.detail', $slug)->withSuccess(__('quiz.thankYou'));
    }
}
