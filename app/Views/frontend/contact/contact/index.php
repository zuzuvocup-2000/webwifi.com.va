<section class="contact-body">
    <div class="site-map">
        <?php echo $general['contact_map'] ?>
    </div>
    <div class="uk-container-center uk-container">
        <div class="contact-form">
            <div class="contact-company">
                <h2><?php echo $general['homepage_company'] ?></h2>
            </div>
            <form action="frontend/contact/contact/index" method="post" class="uk-form form form-contact">
                <div class="uk-grid  uk-grid-width-small-1-1 uk-grid-width-large-1-2">
                    <div class="form-row mb20">
                        <input type="text" name="fullname" class="uk-width-1-1 input-text" placeholder="Họ &amp; tên *">
                    </div>
                    <div class="form-row mb20">
                        <input type="text" name="email" class="uk-width-1-1 input-text" placeholder="Email *">
                    </div>
                    <div class="form-row mb20">
                        <input type="text" name="phone" class="uk-width-1-1 input-text" placeholder="Phone *">
                    </div>
                    <div class="form-row mb20">
                        <input type="text" name="address" class="uk-width-1-1 input-text" placeholder="Địa chỉ *">
                    </div>
                </div><!-- .uk-grid -->
                <div class="form-row mb20">
                    <textarea name="message" class="uk-width-1-1 form-textarea" placeholder="Nội dung *"></textarea>
                </div>
                <div class="form-row ">
                    <input type="submit" name="create" class="btn-submit" value="Gửi đi">
                </div>
            </form><!-- .form -->
        </div><!-- .contact-form -->
    </div>
</section>