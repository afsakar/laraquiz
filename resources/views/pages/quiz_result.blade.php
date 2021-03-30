<x-app-layout>
    <x-slot name="header">
        {{ $quiz->title }} Sonucu
    </x-slot>


    <div class="row">
        <div class="col-md-9 mt-2 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">{{ $quiz->title }}
                        <a href="{{ route('quiz.detail', $quiz->slug) }}" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
                    </h5>

                    <div class="alert alert-info text-center">{{ Emoji::bullseye() }} Bu Quiz için puanınız: <span class="h5 font-weight-bolder">{{ $quiz->myResult->score }}</span></div>

                    @foreach($quiz->questions as $question)
                        <div class="font-weight-bold">
                            @if($question->myAnswer->answer === $question->correct_answer) {{ Emoji::checkMark() }} @else {{ Emoji::crossMark() }} @endif
                            {{ __('question.question')."-".$loop->iteration.")" }} {{ $question->question }}
                        </div>
                        @if($question->image)
                            <div class="d-flex justify-content-center my-3">
                                <a href="{{ asset($question->image) }}" class="popup">
                                    <img src="{{ asset($question->image) }}" class="img-fluid" width="500" alt="">
                                </a>
                            </div>
                        @endif
                        <div class="mb-4 mt-2 ">
                            <ul class="list-group-flush">
                                <li class="list-group-item border-0">
                                    <input class="form-check-input" name="{{ $question->id }}" id="answer{{ $question->id }}1" type="radio" value="answer1" aria-label="{{ $question->answer1 }}" required @if($question->myAnswer->answer === "answer1") checked @else disabled @endif>
                                    <label class="form-check-label ml-3 @if($question->correct_answer === "answer1" || $question->myAnswer->answer === $question->correct_answer && $question->myAnswer->answer === "answer1") font-weight-bold text-success @else text-danger @endif" for="answer{{ $question->id }}1">{{ $question->answer1 }}</label>
                                </li>
                                <li class="list-group-item border-0">
                                    <input class="form-check-input" name="{{ $question->id }}" id="answer{{ $question->id }}2" type="radio" value="answer2" aria-label="{{ $question->answer2 }}" required @if($question->myAnswer->answer === "answer2") checked @else disabled @endif>
                                    <label class="form-check-label ml-3 @if($question->correct_answer === "answer2" || $question->myAnswer->answer === $question->correct_answer && $question->myAnswer->answer === "answer2") font-weight-bold text-success @else text-danger @endif" for="answer{{ $question->id }}2">{{ $question->answer2 }}</label>
                                </li>
                                <li class="list-group-item border-0">
                                    <input class="form-check-input" name="{{ $question->id }}" id="answer{{ $question->id }}3" type="radio" value="answer3" aria-label="{{ $question->answer3 }}" required @if($question->myAnswer->answer === "answer3") checked @else disabled @endif>
                                    <label class="form-check-label ml-3 @if($question->correct_answer === "answer3" || $question->myAnswer->answer === $question->correct_answer && $question->myAnswer->answer === "answer3") font-weight-bold text-success @else text-danger @endif" for="answer{{ $question->id }}3">{{ $question->answer3 }}</label>
                                </li>
                                <li class="list-group-item border-0">
                                    <input class="form-check-input" name="{{ $question->id }}" id="answer{{ $question->id }}4" type="radio" value="answer4" aria-label="{{ $question->answer4 }}" required @if($question->myAnswer->answer === "answer4") checked @else disabled @endif>
                                    <label class="form-check-label ml-3 @if($question->correct_answer === "answer4" || $question->myAnswer->answer === $question->correct_answer && $question->myAnswer->answer === "answer4") font-weight-bold text-success @else text-danger @endif" for="answer{{ $question->id }}4">{{ $question->answer4 }}</label>
                                </li>
                            </ul>
                            <small class="font-italic text-muted">Katılımcılar bu soruyu <b>%{{ $question->true_percent }}</b> oranında doğru cevapladı.</small>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-md-3 mt-2 d-md-block d-xl-block d-none">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ Auth::user()->profile_photo_url }}" class="h-50 w-50 rounded-full object-cover shadow" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="text-center mt-4">
                        <h4>{{ Auth::user()->name }}</h4>
                    </div>
                    @if(Auth::user()->results)
                        <ul class="list-group mt-4">
                            <li class="list-group-item text-center bg-light">
                                <b>{{ Emoji::memo() }} {{ __('Katıldığım Quizler') }}</b>
                            </li>
                            @foreach(Auth::user()->results as $result)
                                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-sm" href="{{ route('quiz.join', $result->quiz->slug) }}">
                                    <b>{{ $result->quiz->title }}</b>
                                    <span class="font-weight-bolder">{{ Emoji::bullseye() }} {{ $result->score }}</span>
                                </a>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
