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
                    <p style="font-size: 24px">a. Term of Agreement. The initial term of this Agreement will commence as of the Effective Date
                        and will continue for a period of one (1) year. The initial term will automatically renew for
                        successive one (1) year terms unless either Party notifies the other in writing, not less than
                        thirty (30) days prior to the expiration of the current term, of its intention not to renew.
                        Both the initial term and any renewal term are subject to earlier termination as otherwise
                        provided for by this Agreement. Either Party may choose not to renew this Agreement without
                        cause for any reason.</p>
                    <p style="font-size: 24px">b. The Subscriber hereby delivers to the Company (i) two (2) duly signed copies of this
                        Subscription Agreement, and (ii) a check made payable to DevsToHire, LLC in the aggregate
                        amount of $[Dollar Amount]. Such payment by the Subscriber represents payment in full for the
                        Membership Interests being offered by the Company and subscribed for by the undersigned, in
                        accordance with the terms and conditions of the Memorandum and this Subscription Agreement.</p>
                    <p style="font-size: 24px">c. The Subscriber certifies and acknowledges the Subscriber received and reviewed the
                        Memorandum, dated [date], and all supplements attached to it. The Subscriber acknowledges that
                        they are familiar with the terms and provisions of the Memorandum.</p>
                    <p style="font-size: 24px">d. The Subscriber hereby acknowledges and agrees that no Membership Interests shall be sold or
                        issued, or deemed sold or issued, by the Company to the Subscriber and that the Subscriber shall
                        in no way be considered a Member of the Company until (i) the Subscriber has satisfied all
                        requirements of section 1.1 above, and (ii) the Company has countersigned this Subscription
                        Agreement and deposited any amounts delivered by the Subscriber in the Company’s bank account.
                        If the offering of any Membership Interests is terminated by the Company (in its sole and
                        absolute discretion) without accepting the Subscriber’s subscription, or if the Company rejects
                        the amounts, in whole or in part, the Company will cause the amounts, or the unaccepted portion
                        thereof, to be returned in full to the Subscriber.</p>
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