<section class="contact-panel">
  <div class="uk-container uk-container-center">
     <div class="uk-flex uk-flex-right">
        <div class="uk-flex uk-flex-middle">
           <div class="contact-item mail mr20">
              <?php echo $general['contact_email'] ?>
           </div>
           <div class="contact-item phone">
              HOTLINE <?php echo $general['contact_hotline'] ?>
           </div>
        </div>
     </div>
  </div>
</section>
<div class="service-menus">
    <div class="menu-service-container">
        <ul id="menu-service" class="menu">
            <?php if(isset($child) && is_array($child) && count($child)){
                foreach ($child as $key => $value) {
            ?>
                <li id="menu-item-1829" class="menu-item menu-item-type-taxonomy menu-item-object-service_cat <?php echo ($_SERVER['REQUEST_URI'] == '/'.$value['canonical'].HTSUFFIX) ? 'current-menu-item' : '' ?> menu-item-1829"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" ><?php echo $value['title'] ?></a></li>
            <?php }} ?>
        </ul>
    </div>
</div>
<div class="list-img-gallery-panel text-center">
    <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-clearfix">
        <?php if(isset($this->data['object']['album']) && is_array($this->data['object']['album']) && count($this->data['object']['album'])){
        foreach ($this->data['object']['album'] as $key => $value) {
         ?>
            <div class="gallery-img-panel">
                <div class="gallery-lightbox">
                    <a href="<?php echo $value ?>" class="img-cover" data-uk-lightbox="{group:'my-group'}">
                        <img src="<?php echo $value ?>" alt="<?php echo $value ?>">
                        <div class="icon-open-lightbox">
                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
        <?php }} ?>
    </div>
</div>