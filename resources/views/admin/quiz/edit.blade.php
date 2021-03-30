<x-app-layout>
    <x-slot name="header">
        {{ __('quiz.editQuiz')." (".$quiz->title.")" }}
    </x-slot>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('quiz.editQuiz') }}
                <a href="{{ route('quizzes.index') }}" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
            </h5>
            <form action="{{ route('quizzes.update', $quiz->id) }}" method="post">
                @method('PUT')
                @csrf
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                <div class="form-group">
                    <label for="title">{{ __('quiz.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') ?? $quiz->title }}">
                    @error('title')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">{{ __('quiz.description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('description') ?? $quiz->description }}</textarea>
                    @error('description')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('quiz.finished_at') }}</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input isFinished" type="radio" name="isFinished" id="isFinished1" {{ old('isFinished') ? (old('isFinished') == "yes" ? "checked" : "") : ($quiz->finished_at != "" ? "checked" : "") }} value="yes">
                            <label class="form-check-label" for="isFinished1">{{ __('general.available') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input isFinished" type="radio" name="isFinished" {{ old('isFinished') ? (old('isFinished') == "no" ? "checked" : "") : ($quiz->finished_at == "" ? "checked" : "") }} id="isFinished2" value="no">
                            <label class="form-check-label" for="isFinished2">{{ __('general.unavailable') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group {{old('isFinished') ? ( old('isFinished') == "yes" ? "d-block" : "d-none" ) : ($quiz->finished_at === null ? "d-none" : "d-block")}}" id="finish_date">
                    <label for="finished_at">Bitiş Tarihi</label>
                    <input type="datetime-local" class="form-control @error('finished_at') is-invalid @enderror" name="finished_at" id="finished_at" value="{{ old('finished_at') ? old('finished_at') : ($quiz->finished_at != null ? date('Y-m-d\TH:i', strtotime($quiz->finished_at)) : "") }}">
                    @error('finished_at')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">{{ __('quiz.status') }}</label>
                    <select class="form-control" name="status" id="status">
                        <option @if($quiz->questions_count < 4) disabled @endif value="published" @if(old('status')){{ old('status') == "published" ? "selected" : "" }}@else{{ $quiz->status == "published" ? "selected" : "" }}@endif>{{ __('quiz.published') }}</option>
                        <option value="unpublished" @if(old('status')){{ old('status') == "unpublished" ? "selected" : "" }}@else{{ $quiz->status == "unpublished" ? "selected" : "" }}@endif>{{ __('quiz.unpublished') }}</option>
                        <option value="draft" @if(old('status')){{ old('status') == "draft" ? "selected" : "" }}@else{{ $quiz->status == "draft" ? "selected" : "" }}@endif>{{ __('quiz.draft') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><i class="fa fa-check"></i> {{ __('general.update') }}</button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="js">
        <script>
            $(document).ready(function() {
                $('.isFinished').change(function () {
                    const isFinished = $(this).attr('value');
                    const finish_date = $('#finish_date');

                    if(isFinished === "yes"){
                        finish_date.removeClass("d-none");
                        finish_date.addClass("d-block");
                    }else{
                        finish_date.removeClass("d-block");
                        finish_date.addClass("d-none");
                    }
                })
            })
        </script>
    </x-slot>
</x-app-layout>
