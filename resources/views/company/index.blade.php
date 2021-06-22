@extends('layouts.app')
@section('content')
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Titlebar -->
        <div id="titlebar" class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Browse Companies</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('job.index') }}">Find Work</a></li>
                                <li>Browse Companies</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="letters-list">
                        @foreach(range('a', 'z') as $v)
                            <a href="{{ route('company.search', $v) }}"
                               @if((isset($letter) && $letter === $v)
                                    || (!isset($letter) && $loop->first))
                               class="current"
                                @endif>
                                {{ strtoupper($v) }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="companies-list">
                        @if(count($companies) > 0)
                            @foreach($companies as $company)
                                <a href="{{ route('company.show', [$company->id, $company->slug]) }}" class="company">
                                    <div class="company-inner-alignment">
                                        <span class="company-logo"><img
                                                src="{{ asset('images/companies/' . $company->pic_url) }}"
                                                alt=""></span>
                                        <h4>{{ $company->name }}</h4>
                                        @if($company->verified)
                                            <span class="verified-badge"
                                                  title="Verified Employer"
                                                  data-tippy-placement="top">
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="notification notice closeable">
                                <p>No companies were found, <a href="{{ route('company.index') }}">click
                                        here to reset.</a></p>
                                <a class="close"></a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Pagination -->
                        <div class="pagination-container margin-top-30 margin-bottom-60" id="company-pagination">
                            <nav class="pagination">
                                {{ $companies->links() }}
                            </nav>
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
