<!-- Make an Offer Popup
    ================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab">Make an Offer</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Login -->
            <div class="popup-tab-content" id="loginn">
                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Discuss your project with {{ $freelancer->firstname }}</h3>
                </div>

                <!-- Form -->
                <form method="post" action="{{ route('make.offer', [$freelancer->id, Auth::id()]) }}" id="make-an-offer-form" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="userId" value="{{ Auth::id() }}">
                    <div class="input-with-icon-left">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text with-border" name="name" id="name"
                               placeholder="First and Last Name"
                               value="{{ old('name')
                                    ?? ucfirst(Auth::user()->firstname) . ' ' . ucfirst(Auth::user()->lastname) }}"
                               required/>
                    </div>

                    <div class="input-with-icon-left">
                        <i class="icon-material-baseline-mail-outline"></i>
                        <input type="text" class="input-text with-border" name="email" id="email"
                               placeholder="Email Address" value="{{ old('email') ?? Auth::user()->email }}" required/>
                    </div>

                    <textarea name="message" cols="10" placeholder="Message" class="with-border"></textarea>

                    <div class="uploadButton margin-top-25">
                        <input class="uploadButton-input" name="offerFile" type="file" accept="application/pdf"
                               id="upload-cv" />
                        <label class="uploadButton-button" for="upload-cv">Add Attachments</label>
                        <span class="uploadButton-file-name">Allowed file types: pdf <br> Max. files size: 50 MB.</span>
                    </div>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit"
                            form="make-an-offer-form">Make an Offer
                        <i class="icon-material-outline-arrow-right-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Make an Offer Popup / End -->