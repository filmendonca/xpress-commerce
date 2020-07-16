@extends('layout.app', ['class' => 'bg-default'])

@section('content')


    <div class="container my-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <h3>{{ __('Verify Your Email Address') }}</h3>
                        </div>
                        <div>
                            
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            
                            @if (Route::has('verification.resend'))
                                {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection