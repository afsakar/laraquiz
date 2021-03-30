<x-app-layout>
    <x-slot name="header">
        {{ __('question.editQuestion') }}
    </x-slot>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('question.editQuestion') }} ({{ $question->question }})
                <a href="{{ route('questions.index', $question->quiz_id) }}" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
            </h5>
            <form action="{{ route('questions.update', [$question->quiz_id, $question->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="question">{{ __('question.question') }}</label>
                    <textarea class="form-control @error('question') is-invalid @enderror" name="question" id="question" cols="3">{{ old('question') ?? $question->question }}</textarea>
                    @error('question')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">{{ __('general.image') }}</label>
                    @if($question->image != "")
                        <div class="w-25 mb-4">
                            <a href="{{ asset($question->image) }}" class="popup">
                                <img src="{{ asset($question->image) }}" class="img-fluid" alt="">
                            </a>
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('question') is-invalid @enderror" id="image" name="image">
                    @error('image')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="answer1">{{ __('question.answer') }}-1</label>
                            <textarea class="form-control @error('answer1') is-invalid @enderror" name="answer1" id="answer1" cols="3">{{ old('answer1') ?? $question->answer1 }}</textarea>
                            @error('answer1')
                            <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="answer2">{{ __('question.answer') }}-2</label>
                            <textarea class="form-control @error('answer2') is-invalid @enderror" name="answer2" id="answer2" cols="3">{{ old('answer2') ?? $question->answer2 }}</textarea>
                            @error('answer2')
                            <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="answer3">{{ __('question.answer') }}-3</label>
                            <textarea class="form-control @error('answer3') is-invalid @enderror" name="answer3" id="answer3" cols="3">{{ old('answer3') ?? $question->answer3 }}</textarea>
                            @error('answer3')
                            <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="answer4">{{ __('question.answer') }}-4</label>
                            <textarea class="form-control @error('answer4') is-invalid @enderror" name="answer4" id="answer4" cols="3">{{ old('answer4') ?? $question->answer4 }}</textarea>
                            @error('answer4')
                            <div class="text-danger"> {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="correct_answer">{{ __('question.correctAnswer') }}</label>
                    <select class="form-control" name="correct_answer" id="correct_answer">
                        <option value="answer1" @if(old('correct_answer')){{ old('correct_answer') == "answer1" ? "selected" : "" }}@else{{ $question->correct_answer == "answer1" ? "selected" : "" }}@endif>{{ __('question.answer') }}-1</option>
                        <option value="answer2" @if(old('correct_answer')){{ old('correct_answer') == "answer2" ? "selected" : "" }}@else{{ $question->correct_answer == "answer2" ? "selected" : "" }}@endif>{{ __('question.answer') }}-2</option>
                        <option value="answer3" @if(old('correct_answer')){{ old('correct_answer') == "answer3" ? "selected" : "" }}@else{{ $question->correct_answer == "answer3" ? "selected" : "" }}@endif>{{ __('question.answer') }}-3</option>
                        <option value="answer4" @if(old('correct_answer')){{ old('correct_answer') == "answer4" ? "selected" : "" }}@else{{ $question->correct_answer == "answer4" ? "selected" : "" }}@endif>{{ __('question.answer') }}-4</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><i class="fa fa-check"></i> {{ __('general.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
