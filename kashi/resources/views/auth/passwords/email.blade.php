@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">               
      <div class="container">
       @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <div class="row justify-content-center">
          <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img src="{{asset('/images/icons/lolj.png')}}" width="90px" height="74px" alt="payM logo">
            <!-- Register Form-->
            <div class="register-form mt-5 px-4">
             <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                <div class="form-group text-left mb-4"><span> Enter Register Email</span>
                  <label for="email"><i class="lni lni-envelope"></i></label>
                 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
               <button type="submit" class="btn btn-warning">
                                    {{ __('Send Password Reset Link') }}
                                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
