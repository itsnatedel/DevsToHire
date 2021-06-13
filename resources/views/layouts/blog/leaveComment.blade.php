<!-- Leave a Comment -->
<div class="row">
    <div class="col-xl-12">
        <h3 class="margin-top-35 margin-bottom-30">Add Comment</h3>
        <!-- Form -->
        <form method="post" id="add-comment">

            <div class="row">
                <div class="col-xl-6">
                    <div class="input-with-icon-left no-border">
                        <i class="icon-material-outline-account-circle"></i>
                        <input type="text" class="input-text" name="commentname" id="namecomment" placeholder="Name"
                               required/>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="input-with-icon-left no-border">
                        <i class="icon-material-baseline-mail-outline"></i>
                        <input type="text" class="input-text" name="emailaddress" id="emailaddress"
                               placeholder="Email Address" required/>
                    </div>
                </div>
            </div>
            <textarea name="comment-content" cols="30" rows="5" placeholder="Comment"></textarea>
        </form>
        <!-- Button -->
        <button class="button button-sliding-icon ripple-effect margin-bottom-40" type="submit" form="add-comment">Add
            Comment <i class="icon-material-outline-arrow-right-alt"></i></button>
    </div>
</div>
<!-- Leave a Comment / End -->
