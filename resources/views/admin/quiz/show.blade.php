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
                        <a href="{{ route('quizzes.index') }}" class="btn btn-primary btn-sm float-md-right"><i class="fa fa-arrow-left"></i> {{ __('general.goBack') }}</a>
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
                            @if(count($quiz->topTen) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover border-top-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="100">Profil Fotoğrafı</th>
                                                <th class="text-center">İsim soyisim</th>
                                                <th class="text-center">Puan</th>
                                                <th class="text-center">Doğru</th>
                                                <th class="text-center">Yanlış</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($quiz->results as $topTen)
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{{ $topTen->user->profile_photo_url }}" class="h-10 w-10 rounded-full object-cover d-inline" alt="{{ $topTen->user->name }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="font-weight-bolder">{{ $topTen->user->name }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="font-weight-bolder">{{ $topTen->score }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="font-weight-bolder">{{ $topTen->correct }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="font-weight-bolder">{{ $topTen->wrong }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning text-center">{{ Emoji::thinkingFace() }} Henüz bu Quiz'e kimse katılmadı.</div>
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
                    @if(count($quiz->topTen) > 0)
                        <div class="mt-4">
                            <span class="font-weight-bold">{{ Emoji::crown() }} Sıralamam</span>
                            <ul class="list-group mt-2">
                                <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bolder">
                                        {{ '#' . $quiz->myRank }}
                                        <img src="{{ Auth::user()->profile_photo_url }}" class="h-6 w-6 rounded-full object-cover d-inline" alt="{{ Auth::user()->name }}">
                                        {{ __('Siz') }}
                                    </span>
                                    <span class="font-weight-bolder">{{ $quiz->myResult->score }}</span>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
