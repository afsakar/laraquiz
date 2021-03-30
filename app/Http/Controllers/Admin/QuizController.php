<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Quiz\QuizCreateRequest;
use App\Http\Requests\Quiz\QuizUpdateRequest;
use App\Models\Quiz;

class QuizController extends Controller
{
    protected $table = "quizzes";

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $quizzes = Quiz::withCount('questions');

        if(request()->get('title')){
            $quizzes = $quizzes->where('title', 'LIKE', "%".request()->get('title')."%");
        }

        if(request()->get('status')){
            $quizzes = $quizzes->where('status', request()->get('status'));
        }

        $quizzes = $quizzes->paginate('5');

        return view('admin/quiz/list', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuizCreateRequest $request
     * @return RedirectResponse
     */
    public function store(QuizCreateRequest $request)
    {
        Quiz::create($request->post());
        return redirect()->route('quizzes.index')->withCreate(__('general.successfulCreate'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $quiz = Quiz::where('id', $id)->with('results.user', 'topTen.user')->withCount('questions')->first() ?? abort('404', __('quiz.notFound'));

        return view('admin.quiz.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $data['quiz'] = Quiz::withCount('questions')->find($id) ?? abort(404, __('quiz.notFound'));
        return view('admin.quiz.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuizUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(QuizUpdateRequest $request, $id)
    {
        $data['quiz'] = Quiz::find($id) ?? abort(404, __('quiz.notFound'));
        Quiz::where('id', $id)->first()->update($request->except(['_method', '_token', 'quiz_id', 'isFinished']));
        return redirect()->route('quizzes.index')->withUpdate(__('general.successfulUpdate'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $data['quiz'] = Quiz::find($id) ?? abort(404, __('quiz.notFound'));
        $data['quiz']->delete();
        return redirect()->route('quizzes.index')->withDelete(__('general.successfulDelete'));
    }
}
