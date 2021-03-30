<x-app-layout>
    <x-slot name="header">
        {{ __('general.homepage') }}
    </x-slot>

    <div class="row">
        <div class="col-md-8 mt-2 mb-2">
            <div class="list-group">
                @foreach($quizzes as $quiz)
                    <a href="{{ route('quiz.detail', $quiz->slug) }}" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $quiz->title }}</h5>
                            <small class="font-weight-bold" title="{{ $quiz->finished_at }}">{{ $quiz->finished_at ? __('quiz.finished_at') . ': ' . $quiz->finished_at->diffForHumans() : "" }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($quiz->description, 200) }}</p>
                        <small>{{ __('quiz.questionCount').": ".$quiz->questions_count }} | {{ __('Katılımcı Sayısı: ')  }}{{ $quiz->details['joiner_count'] }}
                            @if($quiz->myResult) <span class="float-right fa-2x">{{ Emoji::checkMark() }}</span> @endif
                        </small>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 mt-2 d-lg-block d-md-block d-none">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ Auth::user()->profile_photo_url }}" class="h-50 w-50 rounded-full object-cover shadow" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="text-center mt-4">
                        <h4>{{ Auth::user()->name }}</h4>
                    </div>
                    @if($results)
                        <ul class="list-group mt-4">
                            <li class="list-group-item text-center bg-light">
                                <b>{{ Emoji::memo() }} {{ __('Katıldığım Quizler') }}</b>
                            </li>
                            @foreach($results as $result)
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
