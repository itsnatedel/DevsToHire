@extends('layouts.app')

@section('content')
<!-- Wrapper -->
<div id="wrapper">
    <!-- Titlebar
    ================================================== -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Log In</h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('homepage') }}">Home</a></li>
                            <li>Log In</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-xl-5 offset-xl-3">
                <div class="login-register-page">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>We're glad to see you again!</h3>
                        <span>Don't have an account? <a href="{{ route('register') }}">Sign Up</a> !</span>
                    </div>

                    @if(count($errors) > 0)
                        <div style="color:red">
                            @foreach ($errors->all() as $message)
                                <ul>
                                    <li>{{$message}}</li>
                                </ul>
                            @endforeach
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="post" id="login-main-form" action="{{ route('login') }}">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border" name="email" id="email_form" placeholder="Email Address" required/>
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                        </div>

                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10 margin-bottom-10" type="submit" form="login-main-form">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
                    </form>

                    <a href="#" class="forgot-password" style="margin-top: 20px">Forgot Password?</a>

                    <!-- Social Login -->
                    <div class="social-login-separator"><span>or</span></div>
                    <div class="social-login-buttons">
                        <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
                        <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->
</div>
<!-- Wrapper / End -->
@endsection