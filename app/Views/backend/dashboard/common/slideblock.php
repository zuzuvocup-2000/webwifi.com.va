<?php 
if(isset($data) && is_array($data) && count($data)){
    foreach ($data as $key => $value) {
        $json = base64_encode(json_encode($value));
?>
<?php 
    $explode = explode('mp4', $value['image']);
?>
<li class="ui-state-default select_img__update_<?php echo $value['id'] ?>">
    <div class="thumb">
        <span class="image img-scaledown">
            <?php if(isset($explode) && is_array($explode) && count($explode) > 1){ ?>
                <video>
                    <source src="<?php echo $value['image'] ?>" type="video/mp4">
                </video>
            <?php }else{ ?>
                <img src="<?php echo $value['image'] ?>" alt="">
            <?php } ?>
            <input type="hidden" value="<?php echo $value['image'] ?>" class="value-img-banner" name="album[]">
            <input type="hidden" value="<?php echo $json ?>" class="value-data-banner" name="data[]">
        </span>
        <div class="overlay"></div>
        <div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div>
        <div class="show-image" data-class=".select_img__update_<?php echo $value['id'] ?>"  data-toggle="modal" data-target="#show_detail_image" ><i class="fa fa-search-plus" aria-hidden="true"></i></div>
    </div>
</li>

<?php }} ?>