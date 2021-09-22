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
                        <h3>Post a Job</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Post a Job</li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Row -->
                    <div class="row">

                        <!-- Dashboard Box -->
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-feather-folder-plus"></i>Job Submission Form</h3>
                                </div>
                                <form action="{{ route('dashboard.job.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="employerId" value="{{ Auth::user()->company_id }}">
                                    <div class="content with-padding padding-bottom-10">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Job Title</h5>
                                                    <input name="jobTitle" type="text" class="with-border" value="{{ old('jobTitle') }}" placeholder="Senior Laravel Developer">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Job Type</h5>
                                                    <select name="jobType" class="selectpicker with-border" data-size="5"
                                                            title="Select Job Type">
                                                        <option disabled>Job Type</option>
                                                        @foreach($types as $type)
                                                            <option data-tokens="{{ $type->type }}"
                                                                    value="{{ $type->type }}">
                                                                {{ $type->type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Job Field</h5>
                                                    <select class="form-control selectpicker with-border"
                                                            data-live-search="true"
                                                            name="category" data-size="5"
                                                            title="Search a category">
                                                        <option disabled>Categories</option>
                                                        @foreach($categories as $category)
                                                            <option data-tokens="{{ $category->name }}"
                                                                    value="{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Job Location</h5>
                                                    <div class="input-with-icon">
                                                        <div id="autocomplete-container">
                                                            <select class="form-control selectpicker with-border"
                                                                    id="select-country" data-size="5"
                                                                    data-live-search="true" title="Search for a country"
                                                                    name="country" aria-expanded="false">
                                                                <option disabled>Countries</option>
                                                                @foreach($countries as $country)
                                                                    <option data-tokens="{{ $country->country_name }}"
                                                                            {{ $country->id === Auth::user()->location_id ? 'selected' : '' }}
                                                                            value="{{ $country->id }}">
                                                                        {{ $country->country_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <i class="icon-material-outline-location-on"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Yearly Salary</h5>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="input-with-icon">
                                                                <input name="salary_min" class="with-border" type="text"
                                                                       value="{{ old('salary_min') }}" placeholder="Min">
                                                                <i class="currency">EUR</i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="input-with-icon">
                                                                <input name="salary_max" class="with-border" type="text"
                                                                       value="{{ old('salary_max') }}" placeholder="Max">
                                                                <i class="currency">EUR</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Tags <span>(optional)</span>
                                                        <i class="help-icon"
                                                            data-tippy-placement="right"
                                                            title="Maximum of 10 tags">
                                                        </i>
                                                    </h5>
                                                    <div class="keywords-container">
                                                        <div class="keyword-input-container">
                                                            <input name="skills" type="text"
                                                                   class="keyword-input with-border"
                                                                   value="{{ old('skills') }}"
                                                                   placeholder="e.g. Senior PHP, Junior Laravel"
                                                                   data-tippy-placement="top"
                                                                   title="Separate different skills with a comma">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Work remotely ?</h5>
                                                    <select class="form-control selectpicker with-border"
                                                            data-live-search="true"
                                                            name="remote" data-size="5"
                                                            title="Select a work environment">
                                                        <option disabled>Remote Work</option>
                                                        @foreach($remotes as $remote)
                                                            <option data-tokens="{{ $remote->remote }}"
                                                                    value="{{ $remote->remote }}">
                                                                {{ $remote->remote }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-8">
                                                <div class="submit-field">
                                                    <h5>Job Requirements</h5>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="locally" name="locally">
                                                        <label for="locally" title="Leave unchecked if you want your job offer to be available internationally" data-tippy-placement="bottom">
                                                            <span class="checkbox-icon"></span>
                                                            I want my job offer to be restricted to the chosen job location
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5>Job Description</h5>
                                                    <textarea name="description" value="{{ old('description') }}" cols="30" rows="5" class="with-border"></textarea>
                                                    <div class="uploadButton margin-top-30">
                                                        <input name="projectFile" class="uploadButton-input" type="file"
                                                               accept="application/pdf" id="upload"/>
                                                        <label class="uploadButton-button ripple-effect" for="upload">
                                                            Upload Project File</label>
                                                        <span class="uploadButton-file-name">Document that might be helpful in describing your job offer</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="button ripple-effect big margin-top-30"><i
                                                    class="icon-feather-plus"></i> Post a Job Offer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Row / End -->
                    @include('layouts.dashboard.footer')
                </div>
            </div>
            <!-- Dashboard Content / End -->

        </div>
        <!-- Dashboard Container / End -->
    </div>
@endsection