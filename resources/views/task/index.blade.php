@extends('layouts.app')
@section('content')
    <div id="wrapper">
        <!-- Spacer -->
        <div class="margin-top-60"></div>
        <!-- Spacer / End-->

        <!-- Page Content
        ================================================== -->
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="sidebar-container">
                        <form action="{{ route('task.search') }}" method="get">
                        @csrf
                        <!-- Location -->
                            <div class="sidebar-widget">

                                <h3>Location</h3>
                                <div class="bootstrap-select" style="margin-bottom: 15px; max-height: 15px">
                                    <select class="form-control selectpicker with-border" id="select-country"
                                            data-live-search="true" title="Search for a country" name="task_country"
                                            aria-expanded="false">
                                        <option disabled>Countries</option>
                                        @foreach($locations as $location)
                                            <option data-tokens="{{ $location->country_name }}"
                                                    value="{{ $location->id }}">
                                                {{ $location->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="sidebar-widget">
                                <h3>Category</h3>
                                <select class="form-control selectpicker with-border" data-live-search="true"
                                        name="task_category"
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

                            <!-- Keywords -->
                            <div class="sidebar-widget">
                                <h3>Skills</h3>
                                <select class="form-control selectpicker with-border" multiple name="skills[]" data-live-search="true">
                                    @foreach($skills as $skill)
                                        <option data-tokens="{{ $skill->skill }}" value="{{ $skill->skill }}">
                                            {{ $skill->skill }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <!-- Budget -->
                            <div class="sidebar-widget">
                                <h3>Fixed Price</h3>
                                <div class="margin-top-55"></div>
                                <!-- Range Slider -->
                                <input class="range-slider" type="text" name="fixed_price" value=""
                                       data-slider-currency="€"
                                       data-slider-min="{{ $fixedRates->min_rate }}"
                                       data-slider-max="{{ $fixedRates->max_rate }}" data-slider-step="10"
                                       data-slider-value="[{{ $fixedRates->min_rate }}, {{ $fixedRates->max_rate }}]"/>
                            </div>

                            <!-- Hourly Rate -->
                            <div class="sidebar-widget">
                                <h3>Hourly Rate</h3>
                                <div class="margin-top-55"></div>
                                <!-- Range Slider -->
                                <input class="range-slider" type="text" name="hourly_rate" value=""
                                       data-slider-currency="€"
                                       data-slider-min="{{ $hourlyRates->min_rate }}"
                                       data-slider-max="{{ $hourlyRates->max_rate }}" data-slider-step="5"
                                       data-slider-value="[{{ $hourlyRates->min_rate }}, {{ $hourlyRates->max_rate }}]"
                                />
                            </div>

                            <button class="button ripple-effect button-sliding-icon" type="submit"
                                    style="float:right; margin-bottom: 20px">
                                Search
                                <i class="icon-material-outline-search"></i>
                            </button>
                        </form>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 content-left-offset">

                <h3 class="page-title">Search Results - {{ $tasks->total() }} tasks found.</h3>

                <div class="notify-box margin-top-15">
                    <a href="{{ route('task.index') }}" class="button gray ripple-effect button-sliding-icon"
                       style="margin: -10px 0; padding: 5px; transform: translateY(3px)">
                        Reset Search
                        <i class="icon-material-outline-autorenew"></i>
                    </a>

                    <div class="sort-by">
                        <span>Sort by:</span>
                        <form action="{{ route('task.search') }}" method="get">
                            <select class="selectpicker hide-tick" name="sortBy" onchange="this.form.submit()">
                                <option selected disabled>Method</option>
                                <option value="newest">Newest</option>
                                <option value="oldest">Oldest</option>
                                <option value="soon">End Date - Soon</option>
                                <option value="later">End Date - Later</option>
                                <option value="remunHigh">Remuneration - Highest</option>
                                <option value="remunLow">Remuneration - Lowest</option>
                                <option value="random">Randomize</option>
                            </select>
                        </form>
                    </div>
                </div>
                <!-- TODO: Fix select inputs taking height space -->
                <div class="tasks-list-container margin-top-35">
                @forelse($tasks as $task)
                    <!-- Task -->
                        <a href="{{ route('task.show', [$task->id, Str::slug($task->name)]) }}"
                           class="task-listing">
                            <!-- Job Listing Details -->
                            <div class="task-listing-details">
                                <!-- Details -->
                                <div class="task-listing-description">
                                    <h3 class="task-listing-title">{{ ucFirst($task->name) }}</h3>
                                    <ul class="task-icons">
                                        <li>
                                            <i class="icon-material-outline-location-on"></i>{{ $task->location->country_name }}
                                        </li>
                                        <li><i class="icon-material-outline-access-time"></i> {{ $task->due_date }}
                                            days ago
                                        </li>
                                        <li><i class="icon-material-outline-access-time"></i> Closes
                                            in {{ $task->end_date }}
                                            @if ($task->end_date > 1) days @else day @endif</li>
                                    </ul>
                                    <p class="task-listing-text">
                                        {{ $task->description }}
                                    </p>
                                    <div class="task-tags">
                                        <span>iOS</span>
                                        <span>Android</span>
                                        <span>mobile apps</span>
                                        <span>design</span>
                                    </div>
                                </div>

                            </div>

                            <div class="task-listing-bid">
                                <div class="task-listing-bid-inner">
                                    <div class="task-offers">
                                        <strong>{{ $task->budget_min . ' € - ' . $task->budget_max . ' €' }}</strong>
                                        <span>{{ $task->type }} Rate</span>
                                    </div>
                                    <span class="button button-sliding-icon ripple-effect">Learn more <i
                                            class="icon-material-outline-arrow-right-alt"></i></span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div>
                            <p>No task found, come back later or broaden your search criterias !</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tasks Container / End -->
                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Pagination -->
                        <div class="pagination-container margin-top-30 margin-bottom-60">
                            <nav class="pagination">
                                {{ $tasks->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Pagination / End -->
            </div>
        </div>
    </div>
    </div>
@endsection
