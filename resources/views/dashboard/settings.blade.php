@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Dashboard Container -->
        <div class="dashboard-container">
        @include('layouts.dashboard.sidebar')

        <!-- Dashboard Content
            ================================================== -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>Settings</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Settings</li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Row -->
                    <div class="row-cols-xl-6">
                        @if($errors->any())
                            <div class="alert alert-success">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(Session::has('fail'))
                            <div class="notification error closeable">
                                <p>{{ Session::get('fail') }}</p>
                                <a class="close"></a>
                            </div>
                        @endif
                        <form action="{{ route('dashboard.settings.update') }}" autocomplete="off" method="post"
                              enctype="multipart/form-data">
                        @csrf
                        <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box margin-top-0">

                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-material-outline-account-circle"></i> My Account</h3>
                                    </div>
                                    <div class="content with-padding padding-bottom-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="avatar-wrapper" data-tippy-placement="bottom"
                                                     title="Change Avatar">
                                                    @if(!is_null($user->dir_url))
                                                        <img class="profile-pic"
                                                             src="{{ asset('images/user/' . $user->dir_url . '/avatar/' . $user->pic_url) }}"
                                                             alt="Profile Picture"/>
                                                    @else
                                                        <img class="profile-pic"
                                                             src="{{ asset('images/user/' . $user->pic_url) }}"
                                                             alt="Profile Picture"/>
                                                    @endif

                                                    <div class="upload-button"></div>
                                                    <input name="profilePic" class="file-upload" type="file"
                                                           accept="image/*"/>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            <h5>First Name</h5>
                                                            <input name="firstname" type="text" class="with-border"
                                                                   placeholder="{{ $user->firstname }}"
                                                                   value="{{ old('firstname') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            <h5>Last Name</h5>
                                                            <input name="lastname" type="text" class="with-border"
                                                                   placeholder="{{ $user->lastname }}"
                                                                   value="{{ old('lastname') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <!-- Account Type -->
                                                        <div class="submit-field">
                                                            <h5>Account Type</h5>
                                                            <div class="account-type">
                                                                @if($user->role_id === 2)
                                                                    <div>
                                                                        <input type="radio"
                                                                               id="freelancer-radio"
                                                                               class="account-type-radio"
                                                                               @if($user->role_id === 2) checked @endif />
                                                                        <label for="freelancer-radio"
                                                                               class="ripple-effect-dark"><i
                                                                                    class="icon-material-outline-account-circle"></i>
                                                                            Freelancer</label>
                                                                    </div>
                                                                @endif

                                                                @if($user->role_id === 3)
                                                                    <div>
                                                                        <input type="radio"
                                                                               id="employer-radio"
                                                                               class="account-type-radio"
                                                                               @if($user->role_id === 3) checked @endif />
                                                                        <label for="employer-radio"
                                                                               class="ripple-effect-dark"><i
                                                                                    class="icon-material-outline-business-center"></i>
                                                                            Employer</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            <h5>Email</h5>
                                                            <input name="email" type="text" class="with-border"
                                                                   placeholder="{{ $user->email }}"
                                                                   value="{{ old('email') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box">
                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-material-outline-face"></i> My Profile</h3>
                                    </div>
                                    <div class="content">
                                        <ul class="fields-ul">
                                            <li>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <div class="bidding-widget">
                                                                <!-- Headline -->
                                                                @if (Auth::user()->role_id === 2)
                                                                    <span
                                                                            class="bidding-detail">Set your <strong>minimal hourly rate</strong></span>
                                                                    <!-- Slider -->
                                                                    <div class="bidding-value margin-bottom-10">€<span
                                                                                id="biddingVal"></span></div>
                                                                    <input name="sliderHourlyRate"
                                                                           class="bidding-slider" type="text"
                                                                           value="{{ old('sliderHourlyRate') }}"
                                                                           data-slider-handle="custom"
                                                                           data-slider-currency="€"
                                                                           data-slider-min="5" data-slider-max="150"
                                                                           data-slider-value="{{ $user->stats->hourly_rate }}"
                                                                           data-slider-step="1"
                                                                           data-slider-tooltip="hide"/>
                                                                @endif

                                                                @if (Auth::user()->role_id === 3)
                                                                    <h5>Nationality</h5>
                                                                    <select class="form-control selectpicker with-border"
                                                                            id="select-country"
                                                                            data-live-search="true"
                                                                            title="Search for a country" name="country"
                                                                            aria-expanded="false" data-size="7">
                                                                        <option disabled>Countries</option>
                                                                        @foreach($countries as $country)
                                                                            <option data-tokens="{{ $country->country_name }}"
                                                                                    value="{{ $country->id }}"
                                                                                    @if($user->location_id === $country->id) selected @endif >
                                                                                {{ $country->country_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Skills
                                                                <i class="help-icon" data-tippy-placement="right"
                                                                   title="Add up to 10 skills">
                                                                </i>
                                                            </h5>

                                                            <!-- Skills List -->
                                                            <div class="keywords-container">
                                                                <div class="keyword-input-container">
                                                                    <input name="skills" type="text"
                                                                           class="keyword-input with-border"
                                                                           placeholder="e.g. Angular, Laravel"
                                                                           data-tippy-placement="top"
                                                                           title="Separate different skills with a comma"
                                                                           value="{{ old('skills') }}"
                                                                    />
                                                                </div>
                                                                <div class="keywords-list" data-tippy-placement="bottom"
                                                                     title="Your skills">
                                                                    @if(!empty($user->skills))
                                                                        @foreach($user->skills as $skill)
                                                                            <span class="keyword">
                                                                            <span style="margin: 5px; padding: 5px"
                                                                                  class="keyword-text">{{ $skill }}</span>
                                                                        </span>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Attachments</h5>
                                                            <!-- Attachments -->
                                                            @if(Auth::user()->role_id === 2)
                                                                <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                    <div class="attachment-box ripple-effect">
                                                                        <span>Curriculum Vitae</span>
                                                                        <i>PDF @if(is_null($user->stats->CV_url)) - None
                                                                            uploaded @endif</i>
                                                                    </div>
                                                                    @endif

                                                                    @if(Auth::user()->role_id === 3)
                                                                        <div class="attachment-box ripple-effect">
                                                                            <span>Contract</span>
                                                                            <i>PDF</i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="clearfix"></div>

                                                                <!-- Upload Button -->
                                                                <div class="uploadButton margin-top-0">
                                                                    <input name="attachmentUpload"
                                                                           class="uploadButton-input" type="file"
                                                                           accept="application/pdf" id="upload"/>
                                                                    <label class="uploadButton-button ripple-effect"
                                                                           for="upload">Upload File</label>
                                                                    <span class="uploadButton-file-name">Maximum file size: 20 MB</span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-xl-2">
                                                        <div class="submit-field">
                                                            @if(Auth::user()->role_id === 2)
                                                                <h5>Your Speciality</h5>
                                                                <select class="form-control selectpicker with-border"
                                                                        data-live-search="true"
                                                                        name="category"
                                                                        title="Search a category">
                                                                    <option disabled>Categories</option>
                                                                    @foreach($categories as $category)
                                                                        <option data-tokens="{{ $category->name }}"
                                                                                value="{{ $category->id }}"
                                                                                @if($user->stats->specialization === $category->name) selected @endif>
                                                                            {{ $category->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @elseif(Auth::user()->role_id === 3)
                                                                <h5>Your Company's name</h5>
                                                                <input type="text" name="companyName"
                                                                       value="{{ old('companyName') }}"
                                                                       placeholder="{{ $user->company->name }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            @if(Auth::user()->role_id === 2)

                                                                <h5>Nationality</h5>
                                                                <select class="form-control selectpicker with-border"
                                                                        id="select-country"
                                                                        data-live-search="true"
                                                                        title="Search for a country" name="country"
                                                                        aria-expanded="false" data-size="7">
                                                                    <option disabled>Countries</option>
                                                                    @foreach($countries as $country)
                                                                        <option data-tokens="{{ $country->country_name }}"
                                                                                value="{{ $country->id }}"
                                                                                @if($user->location_id === $country->id) selected @endif >
                                                                            {{ $country->country_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @elseif(Auth::user()->role_id === 3)
                                                                <h5>Your Company's tagline</h5>
                                                                <input type="text" name="speciality"
                                                                       placeholder="{{ $user->company->speciality ?? 'i.e. Specialized in tutoring new developers' }}"
                                                                       value="{{ old('speciality') }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="submit-field">
                                                            <h5>
                                                                Introduce {{ Auth::user()->role_id === 3 ? 'your company' : 'yourself' }}</h5>
                                                            <textarea name="description" id=""
                                                                      class=" with-border">@if(Auth::user()->role_id === 2){{ $user->stats->description }}@elseif(Auth::user()->role_id === 3){{ $user->company->description }}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div id="test1" class="dashboard-box">
                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
                                    </div>
                                    <div class="content with-padding">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Current Password</h5>
                                                    <input autocomplete="off" name="currentPassword" type="password"
                                                           class="with-border"
                                                           value="">
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>New Password</h5>
                                                    <input name="newPassword" type="password" class="with-border"
                                                           data-tippy-placement="bottom"
                                                           title="Min. 8 characters, 1 uppercase & 1 digit"
                                                            {{ $errors->has('newPassword') ? 'is-invalid' : '' }}>
                                                    @if($errors->has('newPassword'))
                                                        <div class="invalid-feedback">{{ implode(',', $errors->get('newPassword')) }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Repeat New Password</h5>
                                                    <input name="newPasswordConf" type="password" class="with-border">
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="two-step" checked>
                                                    <label for="two-step"><span class="checkbox-icon"></span> Enable
                                                        Confirmation via Email</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="col-xl-12">
                                <button type="submit" class="button ripple-effect big margin-top-30">Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Row / End -->

                    @include('layouts.dashboard.footer')

                </div>
            </div>
            <!-- Dashboard Content / End -->
        </div>
        <!-- Dashboard Container / End -->

    </div>
    <!-- Wrapper / End -->
@endsection