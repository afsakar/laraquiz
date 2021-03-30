<x-app-layout>
    <x-slot name="header">
        {{ __('question.questionList') }}
    </x-slot>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('question.questionList') }} ({{ $quiz->title }})
                <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-primary float-right btn-sm"><i class="fa fa-plus"></i> {{ __('question.createQuestion') }}</a>
            </h5>
            @if(count($quiz->questions) != 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('question.question') }}</th>
                            <th scope="col">{{ __('question.answer') }}-1</th>
                            <th scope="col">{{ __('question.answer') }}-2</th>
                            <th scope="col">{{ __('question.answer') }}-3</th>
                            <th scope="col">{{ __('question.answer') }}-4</th>
                            <th scope="col">{{ __('question.correctAnswer') }}</th>
                            <th class="text-center" scope="col">{{ __('question.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($quiz->questions as $question)
                            <tr>
                                <td>{{ $question->id }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->answer1 }}</td>
                                <td>{{ $question->answer2 }}</td>
                                <td>{{ $question->answer3 }}</td>
                                <td>{{ $question->answer4 }}</td>
                                <td class="font-weight-bold">{{ $question->{$question->correct_answer} }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if($question->image)
                                            <a title="Delete Image" data-url="{{ route('questions.deleteImage', [$quiz->id, $question->id]) }}" class="btn btn-warning btn-sm delete-confirm"><i class="fa fa-ban"></i></a>
                                        @endif
                                        <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a data-url="{{ route('questions.destroy', [$quiz->id, $question->id]) }}" class="btn btn-danger btn-sm delete-confirm"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $quiz['questions']->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-warning text-center mt-4"><i class="fa fa-info-circle"></i> {{ __('general.noContentAdded') }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
