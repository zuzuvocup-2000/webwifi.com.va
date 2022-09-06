<?php 
$model = new App\Models\AutoloadModel();
    $list = $model->_get_where([
        'select' => 'tb1.id,tb1.viewed, tb1.image,tb4.title as cat_title,tb1.catalogue, tb4.canonical as cat_canonical, tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description,tb3.icon, tb3.viewed, tb3.description, tb3.content, tb1.created_at',
        'table' => 'article as tb1',
        'where' => [
            'tb1.deleted_at' => 0,
            'tb1.publish' => 1
        ],
        'where_in' => $catalogue['where_in'],
        'where_in_field' => $catalogue['where_in_field'],
        'join' => [
            [
                'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "article" ', 'inner'
            ],
            [
                'article_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "article" AND tb3.language = \''.$language.'\' ','inner'
            ],
            [
                'article_translate as tb4','tb4.module = "article_catalogue" AND tb4.objectid = tb1.catalogueid AND tb3.language = \''.$language.'\'', 'inner'
            ]
        ],
        'order_by'=> 'tb1.order desc, tb1.id desc',
        'group_by' => 'tb1.id'
    ], TRUE);
 ?>
<?php if(isset($list) && is_array($list) && count($list)){ ?>
  <div class="wrap-service-panel uk-visible-large">
    <div class="uk-grid uk-grid-collapse uk-clearfix">
      <div class="uk-width-large-1-2">
        <div id="sync1" class="owl-carousel owl-theme">
          <?php foreach ($list as $value) { ?>
            <div class="item">
              <div class="img-cover">
                <img src="<?php echo $value['image'] ?>" alt="">
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="uk-width-large-1-2">
        <div id="sync2" class="owl-carousel owl-theme sub-service-text-panel">
          <?php foreach ($list as $value) { ?>
            <div class="item">
              <div class="wrap-content-service">
                <h2><?php echo $value['title'] ?></h2>
                <div class="desc">
                  <?php echo base64_decode($value['description']) ?>
                  <?php echo base64_decode($value['content']) ?>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="content-art-detail uk-hidden-large">
    <div class="uk-container uk-container-center">
      <?php foreach ($list as $value) { ?>
        <div class="art-img-full">
          <div class="img-cover">
            <img src="<?php echo $value['image'] ?>" alt="">
          </div>
          <div class="title-art-detail"><?php echo $value['title'] ?></div>
          <div class="art-detail-mobile">
            <?php echo base64_decode($value['description']) ?>
            <?php echo base64_decode($value['content']) ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<script>
$(document).ready(function() {

  

  var sync1 = $("#sync1");
  var sync2 = $("#sync2");
  var slidesPerPage = 1; //globaly define number of elements per page
  var syncedSecondary = true;
  sync1.owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: false,
    autoplay: false,
    mouseDrag: false,
    touchDrag: false,
    dots: false,
    loop: false,
    responsiveRefreshRate: 200,
    navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
  }).on('changed.owl.carousel', syncPosition);

  sync2.on('initialized.owl.carousel', function() {
    sync2.find(".owl-item").eq(0).addClass("current");
  }).owlCarousel({
    items: slidesPerPage,
    dots: false,
    nav: true,
    animateOut:'slideOutUp',
    animateIn:'slideInUp',
    mouseDrag: false,
    touchDrag: false,
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
    responsiveRefreshRate: 100
  }).on('changed.owl.carousel', syncPosition2);
  let next = sync2.find('.owl-item.active').next().find('.wrap-content-service>h2').html()
  if(next == undefined){
    next = '';
  }
  $('#sync2.owl-theme .owl-nav .owl-next').html('<span class="va-btn-service">'+next+'</span>')
  function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    var current = el.item.index;
    //if you disable loop you have to comment this block
    // var count = el.item.count - 1;
    // var current = Math.round(el.item.index - (el.item.count / 2) - .5);
    // if (current < 0) {
    // current = count;
    // }
    // if (current > count) {
    // current = 0;
    // }
    //end block
    sync2.find(".owl-item").removeClass("current").eq(current).addClass("current");
    var onscreen = sync2.find('.owl-item.active').length - 1;
    var start = sync2.find('.owl-item.active').first().index();
    var end = sync2.find('.owl-item.active').last().index();
    if (current > end) {
      sync2.data('owl.carousel').to(current, 100, true);
    }
    if (current < start) {
      sync2.data('owl.carousel').to(current - onscreen, 100, true);
    }
    let prev = sync2.find('.owl-item.active').prev().find('.wrap-content-service>h2').html()
    let next = sync2.find('.owl-item.active').next().find('.wrap-content-service>h2').html()
    if(prev == undefined){
      prev = '';
    }
    if(next == undefined){
      next = '';
    }
    $('#sync2.owl-theme .owl-nav .owl-prev').html('<span class="va-btn-service">'+prev+'</span>')
    $('#sync2.owl-theme .owl-nav .owl-next').html('<span class="va-btn-service">'+next+'</span>')
    // $('head').append('<style>#sync2.owl-theme .owl-nav .owl-prev:before{content: "'+prev+'";}</style>');
    // $('head').append('<style>#sync2.owl-theme .owl-nav .owl-next:before{content: "'+next+'";}</style>');
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      sync1.data('owl.carousel').to(number, 100, true);
    }
  }
  sync2.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    sync1.data('owl.carousel').to(number, 300, true);
  });
});

var owl = $('#sync2');
owl.on('mousewheel', '.owl-stage', function (e) {
  if(e.originalEvent.wheelDelta > 0) {
     owl.trigger('prev.owl');
  }
  else{
      owl.trigger('next.owl');
  }
  e.preventDefault();
});

var owl1 = $('#sync1');
owl1.on('mousewheel', '.owl-stage', function (e) {
  if(e.originalEvent.wheelDelta > 0) {
     owl1.trigger('prev.owl');
  }
  else{
      owl1.trigger('next.owl');
  }


  e.preventDefault();
});
</script>
<?php } ?>