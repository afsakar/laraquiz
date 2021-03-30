<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionCreateRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QuestionController extends Controller
{
    protected $table = "questions";

    /**
     * Display a listing of the resource.
     *
     * @param int $quiz_id
     * @return Application|Factory|View
     */
    public function index($quiz_id)
    {
        $quiz = Quiz::whereId($quiz_id)->first() ?? abort('404', __('question.notFound'));
        $quiz->setRelation('questions', $quiz->questions()->paginate(10));
        return view('admin.question.list', compact('quiz'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        return view('admin.question.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionCreateRequest $request
     * @param $quiz_id
     * @return array
     */
    public function store(QuestionCreateRequest $request, $quiz_id)
    {
        if($request->hasFile('image')){
            $fileName = Str::slug($request->question).'.'.$request->image->extension();
            $fileNameUploadPath = 'uploads/'.$fileName;

            $request->image->move(public_path('uploads'), $fileName);

            $request->merge([
                'image' => $fileNameUploadPath,
            ]);
        }
        Quiz::find($quiz_id)->questions()->create($request->post());
        return redirect()->route('questions.index', $quiz_id)->withCreate(__('general.successfulCreate'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $quiz_id
     * @param int $id
     * @return void
     */
    public function show($quiz_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $quiz_id
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($quiz_id, $id)
    {
        $question = Quiz::find($quiz_id)->questions()->whereId($id)->first() ?? abort(404, __('general.title404'));
        return view('admin.question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionUpdateRequest $request
     * @param int $quiz_id
     * @param int $id
     * @return void
     */
    public function update(QuestionUpdateRequest $request, $quiz_id, $id)
    {
        $question = Quiz::find($quiz_id)->questions()->whereId($id)->first() ?? abort(404, __('general.title404'));
        if($request->hasFile('image')){
            /* Delete old image */
            File::delete(public_path($question->image));

            /* Upload new image */
            $fileName = Str::slug($request->question).'.'.$request->image->extension();
            $fileNameUploadPath = 'uploads/'.$fileName;

            $request->image->move(public_path('uploads'), $fileName);

            $request->merge([
                'image' => $fileNameUploadPath,
            ]);
        }
        $question->update($request->post());
        return redirect()->route('questions.index', $quiz_id)->withUpdate(__('general.successfulUpdate'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $quiz_id
     * @param int $id
     * @return void
     */
    public function destroy($quiz_id, $id)
    {
        $question = Quiz::find($quiz_id)->questions()->whereId($id)->first() ?? abort(404, __('general.title404'));
        if($question->image != ""){
            File::delete(public_path($question->image));
        }
        $question->delete();
        return redirect()->route('questions.index', $quiz_id)->withDelete(__('general.successfulDelete'));
    }

    public function deleteImage($quiz_id, $id)
    {
        $question = Quiz::find($quiz_id)->questions()->whereId($id)->first() ?? abort(404, __('general.title404'));
        if($question->image != ""){
            File::delete(public_path($question->image));
        }
        $question->update(array('image' => ""));
        return redirect()->route('questions.index', $quiz_id)->withDelete(__('general.successfulDelete'));
    }
}
