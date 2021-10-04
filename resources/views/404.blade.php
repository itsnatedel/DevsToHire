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
                        <h2>404 Not Found</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>404 Not Found</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content
        ================================================== -->
        <!-- Container -->
        <div class="container">

            <div class="row">
                <div class="col-xl-12">
                    <section id="not-found" class="center margin-top-50 margin-bottom-25">
                        <h2>404 <i class="icon-line-awesome-question-circle"></i></h2>
                        <p>We're sorry, but the page you were looking for doesn't exist</p>
                        @if (Session::has('message'))
                            <p><b>{{ Session::get('message') }}</b></p>
                        @endif
                    </section>
                </div>
            </div>
        </div>
        <!-- Container / End -->
        <!-- Spacer -->
        <div class="margin-top-100"></div>
        <!-- Spacer / End-->

    </div>
    <!-- Wrapper / End -->
@endsection