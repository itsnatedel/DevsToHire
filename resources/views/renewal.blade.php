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
                        <h2>Automatic Renewal Terms</h2>
                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>Automatic Renewal Terms</li>
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
                    <p>a. Term of Agreement. The initial term of this Agreement will commence as of the Effective Date
                        and will continue for a period of one (1) year. The initial term will automatically renew for
                        successive one (1) year terms unless either Party notifies the other in writing, not less than
                        thirty (30) days prior to the expiration of the current term, of its intention not to renew.
                        Both the initial term and any renewal term are subject to earlier termination as otherwise
                        provided for by this Agreement. Either Party may choose not to renew this Agreement without
                        cause for any reason.</p>
                </div>
            </div>
        </div>
        <!-- Container / End -->
        <!-- Spacer -->
        <div class="margin-top-70"></div>
        <!-- Spacer / End-->
    </div>
    <!-- Wrapper / End -->
@endsection