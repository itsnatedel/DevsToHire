@extends('layouts.app')
<!-- Wrapper -->
<div id="wrapper">

@section('content')
    <!-- Titlebar
================================================== -->
        <div id="titlebar" class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <h2>Contact</h2>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li>Contact Us</li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="contact-location-info margin-bottom-50">
                        <div class="contact-address">
                            <ul>
                                <li class="contact-address-headline">Our Office</li>
                                <li>25 Rue de Mons, 7090 Braine-Le-Comte</li>
                                <li>Belgium</li>
                                <li>Phone (+32) 474 41 51 49</li>
                                <li><a href="mailto:contact@devstohire.com">contact@devstohire.com</a></li>
                            </ul>
                        </div>
                        <div id="single-job-map-container">
                            <div style="text-decoration:none; overflow:hidden;max-width:100%;width:500px;height:500px;">
                                <div id="embeddedmap-canvas" style="height:100%; width:100%;max-width:100%;">
                                    <iframe style="height:100%;width:100%;border:0;"
                                            src="https://www.google.com/maps/embed/v1/place?q=25+Rue+de+Mons,+7090+Braine-Le-Comte&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('errors'))
                    <ul>
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if(Session::has('success'))
                        <p>{{ Session::get('success') }}</p>
                @endif
                <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">
                    <section id="contact" class="margin-bottom-60">
                        <h3 class="headline margin-top-15 margin-bottom-35">Any questions ? Feel free to contact us !</h3>
                        <form method="post" action="{{ route('sendContactForm') }}" name="contactform" id="contactform" autocomplete="on" >
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="name" type="text" id="name"
                                               placeholder="Your Name" required="required"
                                               @if (Auth::check())
                                                   value="{{ Auth::user()->firstname
                                                        . ' '
                                                        . Auth::user()->lastname
                                                   }}"
                                               @endif
                                        />
                                        <i class="icon-material-outline-account-circle"></i>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-with-icon-left">
                                        <input class="with-border" name="email" type="email" id="email"
                                               placeholder="Email Address"
                                               pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$"
                                               required="required"
                                               @if (Auth::check())
                                               value="{{ Auth::user()->email }}"
                                                @endif/>
                                        <i class="icon-material-outline-email"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="input-with-icon-left">
                                <input class="with-border" name="subject" type="text" id="subject" placeholder="Subject"
                                       required="required"/>
                                <i class="icon-material-outline-assignment"></i>
                            </div>

                            <div>
                                <textarea name="message" class="with-border" name="comments" cols="40" rows="5" id="comments"
                                          placeholder="Message" spellcheck="true" required="required"></textarea>
                            </div>

                            <input type="submit" class="submit button margin-top-15" id="submit"
                                   value="Submit Message"/>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <!-- Container / End -->
@endsection