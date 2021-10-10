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
                        <h2 class="margin-top-100">Oops... Seems like something went wrong !</h2>
                        <p><b>Your payment was not successful.</b></p>
                        <a href="{{ route('premium.index') }}"
                           class="button ripple-effect-dark button-sliding-icon margin-top-30">Go back to the pricing plans <i
                                class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="margin-bottom-100"></div>
        <!-- Container / End -->
    </div>
    <!-- Wrapper / End -->
@endsection