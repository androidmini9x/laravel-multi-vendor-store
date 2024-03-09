<x-front-layout title="2FA Challenge">
<!-- Start Account Login Area -->
<div class="account-login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                <form class="card login-form" method="post" action="{{ route('two-factor.login') }}">
                    @csrf
                    <div class="card-body">
                        <div class="title">
                            <h3>2FA Challenge</h3>
                            <p>Enter your 2fa challenge code.</p>
                        </div>
                        @if($errors->has('code'))
                        <div class="alert alert-danger">
                            {{ $errors->first('code') }}
                        </div>
                        @endif
                        <div class="form-group input-group">
                            <label for="reg-fn">2FA Code</label>
                            <input class="form-control" type="text" name="code" id="reg-code">
                        </div>
                        <div class="alt-option">
                            <span>Or</span>
                        </div>
                        <div class="form-group input-group">
                            <label for="reg-fn">Recovery Code</label>
                            <input class="form-control" type="text" name="recovery_code" id="reg-code">
                        </div>
                        <div class="button">
                            <button class="btn" type="submit">Submit</button>
                        </div>
                        @if(Route::has('register'))
                        <p class="outer-link">Don't have an account? <a href="{{ route('register')}}">Register here </a>
                        </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Account Login Area -->
</x-front-layout>