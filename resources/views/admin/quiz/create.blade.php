<x-app-layout>
    <x-slot name="header">
        {{ __('quiz.createQuiz') }}
    </x-slot>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __('quiz.createQuiz') }}
                <a href="{{ route('quizzes.index') }}" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
            </h5>
            <form action="{{ route('quizzes.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="title">{{ __('quiz.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}">
                    @error('title')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">{{ __('quiz.description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5">{{ old('title') }}</textarea>
                    @error('description')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ __('quiz.finished_at') }}</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input isFinished" type="radio" name="isFinished" id="isFinished1" {{ old('isFinished') == "yes" ? "checked" : "" }} value="yes">
                            <label class="form-check-label" for="isFinished1">{{ __('general.available') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input isFinished" type="radio" name="isFinished" {{ old('isFinished') == "no" ? "checked" : "" }} id="isFinished2" value="no">
                            <label class="form-check-label" for="isFinished2">{{ __('general.unavailable') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group {{ old('isFinished') == "yes" ? "d-block" : "d-none" }}" id="finish_date">
                    <label for="finished_at">Bitiş Tarihi</label>
                    <input type="datetime-local" class="form-control @error('finished_at') is-invalid @enderror" name="finished_at" id="finished_at" value="{{ old('finished_at') }}">
                    @error('finished_at')
                    <div class="text-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><i class="fa fa-check"></i> {{ __('general.create') }}</button>
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
