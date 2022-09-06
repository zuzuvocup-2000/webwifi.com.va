<?php $customer = get_slide(['keyword' => 'customer' , 'language' => $language, ]); ?>
<?php $partner = get_slide(['keyword' => 'partner' , 'language' => $language, ]); ?>

<section class="customer-panel">
    <div class="uk-container uk-container-center">
        <?php if(isset($customer) && is_array($customer) && count($customer)){ ?>
            <div class="customer-top-panel mb60">
                <header class="top-header">
                    <h1 class="heading">
                        <?php echo $customer[0]['cat_title'] ?>
                    </h1>
                </header>
                <div class="customer-top-body">
                    <div class="uk-grid uk-grid-collapse uk-grid-match">
                        <?php foreach ($customer as $value) { ?>
                            <div class="uk-width-1-3 uk-width-medium-1-4 uk-width-large-1-6">
                                <div class="the-logo">
                                    <a  class="img img-scaledown">
                                        <?php echo render_img(['src' => $value['image']]) ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if(isset($partner) && is_array($partner) && count($partner)){ ?>
            <div class="customer-top-panel">
                <header class="top-header">
                    <h1 class="heading">
                        <?php echo $partner[0]['cat_title'] ?>
                    </h1>
                </header>
                <div class="customer-top-body">
                    <div class="uk-grid uk-grid-collapse uk-grid-match">
                        <?php foreach ($partner as $value) { ?>
                            <div class="uk-width-1-3 uk-width-medium-1-4 uk-width-large-1-6">
                                <div class="the-logo">
                                    <a  class="img img-scaledown">
                                        <?php echo render_img(['src' => $value['image']]) ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>