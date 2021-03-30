<x-app-layout>
    <x-slot name="header">
        {{ $quiz->title }}
    </x-slot>


    <div class="row">
        <div class="col-md-9 mt-2 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $quiz->title }}
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm float-md-right"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
                    </h5>
                    <div class="row">
                        <div class="col-md-4 my-2">
                            <ul class="list-group">

                                @if($quiz->finished_at)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>{{ Emoji::calendar() }} Son Katılım Tarihi</b>
                                        <span class="font-weight-bolder" title="{{ $quiz->finished_at }}">
                                        {{ $quiz->finished_at ? $quiz->finished_at->diffForHumans() : "-" }}
                                    </span>
                                    </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::redQuestionMark() }} Soru Sayısı</b>
                                    <span class="font-weight-bolder">{{ $quiz->questions_count }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::bustsInSilhouette() }} Katılımcı Sayısı</b>
                                    <span class="font-weight-bolder">{{ $quiz->details['joiner_count'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::bullseye() }} Ortalama Puan</b>
                                    <span class="font-weight-bolder">{{ $quiz->details['average'] }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8 my-2">
                            <p class="card-text">{{ $quiz->description }}</p>
                            @if($quiz->myResult)
                                <div class="alert alert-info text-center">
                                    {{ Emoji::clappingHands() }} Quiz'i <b>{{ date('d/m/Y', strtotime($quiz->myResult->created_at)) }}</b> tarihinde tamamladınız.
                                </div>
                                <a href="{{ route('quiz.join', $quiz->slug) }}" class="btn btn-success btn-block">{{ Emoji::pageFacingUp() }} Cevaplarınızı görmek için tıklayın</a>
                            @elseif($quiz->finished_at && $quiz->finished_at > now())
                                <div class="alert alert-info text-center">
                                    {{ Emoji::stopwatch() }} Quiz <b>{{ date('d/m/Y', strtotime($quiz->created_at)) }}</b> tarihinde sonlandı.
                                </div>
                            @else
                                <a href="{{ route('quiz.join', $quiz->slug) }}" class="btn btn-primary btn-block">Join the Quiz</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ Auth::user()->profile_photo_url }}" class="h-50 w-50 rounded-full object-cover shadow" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="text-center mt-4">
                        <h4>{{ Auth::user()->name }}</h4>
                    </div>
                    <div class="mt-4">
                        @if($quiz->myResult)
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::star() }} Puanınız</b>
                                    <span class="font-weight-bolder">{{ $quiz->myResult->score }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::checkMark() }} Doğru Sayısı</b>
                                    <span class="font-weight-bolder">{{ $quiz->myResult->correct }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>{{ Emoji::crossMark() }} Yanlış Sayısı</b>
                                    <span class="font-weight-bolder">{{ $quiz->myResult->wrong }}</span>
                                </li>
                            </ul>
                        @endif
                    </div>
                    @if(count($quiz->topTen) > 0)
                        <div class="mt-4">
                            <span class="font-weight-bold">{{ Emoji::crown() }} İlk 10</span>
                            <ul class="list-group mt-2">
                                @if($quiz->myRank)
                                    <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bolder">
                                            {{ '#' . $quiz->myRank }}
                                            <img src="{{ Auth::user()->profile_photo_url }}" class="h-6 w-6 rounded-full object-cover d-inline" alt="{{ Auth::user()->name }}">
                                            {{ __('Siz') }}
                                        </span>
                                        <span class="font-weight-bolder">{{ $quiz->myResult->score }}</span>
                                    </li>
                                @endif
                                @foreach($quiz->topTen as $topTen)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span @if($loop->first) class="font-weight-bolder" @endif>
                                            {{ '#' . $loop->iteration }}
                                            <img src="{{ $topTen->user->profile_photo_url }}" class="h-6 w-6 rounded-full object-cover d-inline" alt="{{ $topTen->user->name }}">
                                            {{ $topTen->user->id == Auth::user()->id ? "Siz" : $topTen->user->name }}
                                        </span>
                                        <span @if($loop->first) class="font-weight-bolder" @endif>{{ $topTen->score }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
