@extends('layouts.app')
@section('content')

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Content
        ================================================== -->
        <div id="titlebar" class="gradient"></div>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="order-confirmation-page">
                        <div class="breathing-icon"><i class="icon-feather-check"></i></div>
                        <h2 class="margin-top-30">Thank you for your order!</h2>
                        <p>Your payment has been processed successfully.</p>
                        <a href="pages-invoice-template.html"
                           class="button ripple-effect-dark button-sliding-icon margin-top-30">View Invoice <i
                                class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container / End -->
    </div>
    <!-- Wrapper / End -->
@endsection
