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
                        <h3>Post a Task</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>Post a Task</li>
                            </ul>
                        </nav>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-success">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <!-- Row -->
                    <div class="row">
                        <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Dashboard Box -->
                            <div class="col-xl-12">
                                <div class="dashboard-box margin-top-0">
                                    <!-- Headline -->
                                    <div class="headline">
                                        <h3><i class="icon-feather-folder-plus"></i> Task Submission Form</h3>
                                    </div>
                                    <div class="content with-padding padding-bottom-10">
                                        <div class="row">

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Project Name</h5>
                                                    <input name="taskTitle" type="text" class="with-border"
                                                           placeholder="e.g. build me a website">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Category</h5>
                                                    <select name="category" class="selectpicker with-border" data-size="4"
                                                            title="Select Category">
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>Location <i class="help-icon" data-tippy-placement="right"
                                                                    title="Leave blank if it's an online job"></i></h5>
                                                    <select class="form-control selectpicker with-border" id="select-country"
                                                            data-live-search="true" data-size="5" title="Search by country" name="location"
                                                            aria-expanded="false">
                                                        <option disabled>Countries</option>
                                                        @foreach($locations as $location)
                                                            <option data-tokens="{{ $location->country_name }}"
                                                                    {{ $location->id === Auth::user()->location_id ? 'selected' : '' }}
                                                                    value="{{ $location->id }}">
                                                                {{ $location->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="submit-field">
                                                    <h5>What is your estimated budget?</h5>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="input-with-icon">
                                                                <input name="budget_min" class="with-border"
                                                                       min="0"
                                                                       type="number"
                                                                       placeholder="Minimum">
                                                                <i class="currency">EUR</i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="input-with-icon">
                                                                <input name="budget_max" class="with-border" type="number"
                                                                       max="99999"
                                                                       placeholder="Maximum">
                                                                <i class="currency">EUR</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="submit-field">
                                                    <h5>What skills are required?
                                                        <i class="help-icon"
                                                           data-tippy-placement="right"
                                                           title="Up to 5 skills that best describe your project">
                                                        </i>
                                                    </h5>
                                                    <div class="keyword-input-container">
                                                        <input name="skills" type="text" class="keyword-input with-border"
                                                               placeholder="e.g. Angular, Laravel"
                                                               data-tippy-placement="top"
                                                               title="Separate different skills with a comma"
                                                        />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="submit-field">
                                                    <h5>How will the project be paid ?</h5>
                                                    <div class="radio">
                                                        <input type="radio" id="fixed" name="radio" value="fixed"
                                                               checked="">
                                                        <label for="fixed"><span class="radio-label"></span> Fixed Price
                                                            Project</label>
                                                    </div>
                                                    <br>
                                                    <div class="radio">
                                                        <input type="radio" id="hourly" name="radio" value="hourly" checked="">
                                                        <label for="hourly"><span class="radio-label"></span> Hourly Paid
                                                            Project</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 bidding-fields">
                                                <div class="submit-field">
                                                    <h5>How fast do you want your project to be done ?</h5>
                                                    <div class="bidding-widget">
                                                        <!-- Fields -->
                                                        <div class="bidding-fields">
                                                            <div class="bidding-field">
                                                                <!-- Quantity Buttons -->
                                                                <div class="qtyButtons">
                                                                    <div class="qtyDec"></div>
                                                                    <input type="number" name="qtyInput" min="1" value="1">
                                                                    <div class="qtyInc"></div>
                                                                </div>
                                                            </div>
                                                            <div class="bidding-field">
                                                                <div class="btn-group bootstrap-select default">
                                                                    <select name="taskDuration" class="selectpicker default">
                                                                        <option value="days" selected>Days</option>
                                                                        <option value="months">Months</option>
                                                                    </select></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="submit-field">
                                                <h5>Describe Your Project</h5>
                                                <textarea name="description" cols="30" rows="5" class="with-border" placeholder="Tell us more..."></textarea>

                                                <div class="uploadButton margin-top-30">
                                                    <input name="files" class="uploadButton-input" type="file"
                                                           accept="image/*, application/pdf" id="upload" multiple/>
                                                    <label class="uploadButton-button ripple-effect" for="upload">Upload
                                                        Files</label>
                                                    <span class="uploadButton-file-name">Images or documents that might be helpful in describing your project</span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" id="submitButton" class="button ripple-effect big margin-top-30">
                                    <i class="icon-feather-plus"></i>
                                    Post a Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Row / End -->
                @include('layouts.dashboard.footer')
            </div>
        </div>
        <!-- Dashboard Content / End -->
    </div>
    <!-- Dashboard Container / End -->
    <!-- Wrapper / End -->

@endsection