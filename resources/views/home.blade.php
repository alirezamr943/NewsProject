@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <br>
                    <br>
                    <br>
                    @if ($user->id_admin)
                    <a href="{{route('dispatchSaveNews')}}" class="btn btn-xs btn-info pull-right">Save some NEWS</a>
                    {{cache('save_news')}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
