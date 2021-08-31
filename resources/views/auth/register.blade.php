@extends('layouts.app')

@section('content')
    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Titlebar -->
        <div id="titlebar" class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Register</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>Register</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-xl-5 offset-xl-3">
                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h3 style="font-size: 26px;">Let's create your account !</h3>
                            <span>Already have an account? <a href="{{ route('login') }}">Log In !</a></span>
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
                        <form method="post" id="register-account-form-main" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Account Type -->
                            <div class="account-type">
                                <div id="freelancer-account">
                                    <input type="radio" name="account-type" id="freelancer-radio"
                                           class="account-type-radio" value="freelancer" checked/>
                                    <label for="freelancer-radio" class="ripple-effect-dark"><i
                                            class="icon-material-outline-account-circle"></i> Freelancer</label>
                                </div>

                                <div id="company-account">
                                    <input type="radio" name="account-type" id="company-radio"
                                           class="account-type-radio" value="company"/>
                                    <label for="company-radio" class="ripple-effect-dark"><i
                                            class="icon-material-outline-business-center"></i> Company</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <h4 style="margin-bottom: 10px">Profile Picture</h4>
                                    <div class="avatar-wrapper" data-tippy-placement="bottom"
                                         title="Change Profile Picture (optional)">
                                        <img class="profile-pic" src="{{ asset('images/user/user-avatar-placeholder.png') }}"
                                             alt="Picture"/>
                                        <div class="upload-button"></div>
                                        <input name="avatar-upload" id="avatar-upload" class="file-upload" type="file" accept="image/*"/>
                                    </div>
                                </div>
                                <div class="col-8" style="margin-top: 35px">
                                    <div class="input-with-icon-left">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" id="firstname" name="firstname" class="input-text with-border"
                                               placeholder="Firstname">
                                    </div>

                                    <div class="input-with-icon-left" style="margin-top: 55px">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" id="lastname" name="lastname" class="input-text with-border"
                                               placeholder="Lastname">
                                    </div>
                                </div>
                            </div>
                            <div class="input-with-icon-left">
                                <i class="icon-material-baseline-mail-outline"></i>
                                <input type="text" class="input-text with-border" name="email"
                                       id="email-register" placeholder="Email Address" required/>
                            </div>

                            <div class="bootstrap-select" style="margin-bottom: 15px;">
                                <!-- TODO: Fix select taking extra space below page -->
                                <select class="form-control selectpicker with-border" id="select-country"
                                        data-live-search="true" aria-expanded="false" name="country" data-size="5">
                                    <option disabled selected>Your Country</option>
                                    @foreach($countries as $country)
                                        <option data-tokens="{{ $country->name }}"
                                                value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="input-with-icon-left col-6" title="Should be at least 8 characters long"
                                     data-tippy-placement="bottom">
                                    <i class="icon-material-outline-lock"></i>
                                    <input type="password" class="input-text with-border" name="password"
                                           id="password-register-form" placeholder="Password" required/>
                                </div>

                                <div class="input-with-icon-left col-6">
                                    <i class="icon-material-outline-lock"></i>
                                    <input type="password" class="input-text with-border" name="password_confirmation"
                                           id="password-repeat-register-form" placeholder="Conf. password"/>
                                </div>
                            </div>
                            <div class="form-group" id="description-field">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="5"
                                          placeholder="Write something about yourself..."></textarea>
                            </div>

                            <div class="freelancer-fields" id="freelancer-fields">
                                <label for="hourlyRate">Desired Hourly Rate (in €)</label>
                                <input id="hourlyRate" name="hourlyRate" class="range-slider-single" type="text" data-slider-min="1" data-slider-max="100" data-slider-step="1"
                                       data-slider-value="50" data-value="50" value="50" style="display: none;">
                            </div>

                            <div class="company-fields" id="company-fields" style="display: none">
                                <div class="row">
                                    <div class="input-with-icon-left col-12">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" id="company-name" name="company-name" class="input-text with-border"
                                               placeholder="Company name">
                                    </div>

                                    <div class="input-with-icon-left col-12">
                                        <i class="icon-feather-user"></i>
                                        <input type="text" id="company-speciality" name="company-speciality" class="input-text with-border"
                                               placeholder="Company Speciality (e.g. Dynamic WebApps)">
                                    </div>
                                    <div class="form-group col-12" id="description-field">
                                        <label for="company-description">Company's description</label>
                                        <textarea name="company-description" class="form-control" id="company-description" rows="5"
                                                  placeholder="Write something about your company..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->
                            <button class="button full-width button-sliding-icon ripple-effect margin-top-10"
                                    type="submit"
                                    form="register-account-form-main">Register <i
                                    class="icon-material-outline-arrow-right-alt"></i>
                            </button>
                        </form>


                        <!-- Social Login -->
                        <div class="social-login-separator"><span>or</span></div>
                        <div class="social-login-buttons">
                            <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register
                                via
                                Facebook
                            </button>
                            <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register
                                via
                                Google+
                            </button>
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
    <script src="{{ asset('js/auth/register/addFieldsRegistration.js') }}"></script>
@endsection
