<x-app-layout>
    <x-slot name="header">
        {{ __('quiz.quizList') }}
    </x-slot>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <div class="row my-2">
                    <div class="col-md-8">
                        <form method="get">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control mt-2" name="title" placeholder="Quiz" value="{{ request()->get('title') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="status" onchange="this.form.submit()" class="form-control mt-2">
                                        <option value="">Durum seçiniz</option>
                                        <option value="draft" @if(request()->get('status') == "draft") selected @endif>{{ __('quiz.draft') }}</option>
                                        <option value="published" @if(request()->get('status') == "published") selected @endif>{{ __('quiz.published') }}</option>
                                        <option value="unpublished" @if(request()->get('status') == "unpublished") selected @endif>{{ __('quiz.unpublished') }}</option>
                                    </select>
                                </div>
                                @if(request()->get('title') || request()->get('status'))
                                    <div class="col-md-4 d-flex justify-content-start">
                                        <a href="{{ route('quizzes.index') }}" class="btn btn-dark float-right btn-sm my-2">
                                            {{ __('quiz.clearForm') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('quizzes.create') }}" class="btn btn-primary float-right btn-sm my-2">
                            <i class="fa fa-plus"></i> {{ __('quiz.createQuiz') }}
                        </a>
                    </div>
                </div>
            </h5>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quiz</th>
                        <th class="text-center" scope="col">{{ __('quiz.questionCount') }}</th>
                        <th class="text-center" scope="col">{{ __('quiz.status') }}</th>
                        <th class="text-center" scope="col">{{ __('quiz.finished_at') }}</th>
                        <th class="text-center" scope="col">{{ __('quiz.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($quizzes) != 0)

                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->id }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td class="text-center">{{ $quiz->questions_count }}</td>
                                <td class="text-center">
                                    @if($quiz->finished_at)
                                        @if($quiz->finished_at < now())
                                            <span class="font-weight-bolder text-danger">Süresi doldu</span>
                                        @else
                                            <span class="font-weight-bolder">{{ __("quiz.$quiz->status")  }}</span>
                                        @endif
                                    @else
                                        <span class="font-weight-bolder">{{ __("quiz.$quiz->status")  }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span title="{{ $quiz->finished_at }}">
                                        {{ $quiz->finished_at ? $quiz->finished_at->diffForHumans() : "-" }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('quizzes.detail', $quiz->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-question"></i>
                                        </a>
                                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-url="{{ route('quizzes.destroy', $quiz->id) }}" class="btn btn-danger btn-sm delete-confirm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr aria-colspan="6">
                            <div class="alert alert-warning text-center mt-4">
                                <i class="fa fa-info-circle"></i> {{ __('general.noContentAdded') }}
                            </div>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $quizzes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
