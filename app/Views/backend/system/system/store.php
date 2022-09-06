<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $AutoloadModel = new App\Models\AutoloadModel();
    $languageList = get_full_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý đường dẫn Hệ thống</h2>
        <ol class="breadcrumb mb20">
            <li>
                <a href="http://ipanel.thegioiweb.org/admin.html">Home</a>
            </li>
            <li class="active"><strong>Quản lý đường dẫn Hệ thống</strong></li>
        </ol>
    </div>
</div>
<form method="post" action="" class="form-horizontal box">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div id="system-catalogue">
            <?php 
                // pre($systemCatalogueList);
                if(isset($systemList) && is_array($systemList) && count($systemList)){
                    foreach ($systemList as $key => $value) {
                        // pre($value);
            ?>
                <div class="row" id="<?php echo $key ?>">
                    <div class="col-lg-4">
                        <div class="panel-head">
                            <h2 class="panel-title"><?php echo $value['label'] ?></h2>
                            <div class="panel-description mb20">
                                <?php echo $value['description']; ?>                    
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="ibox m0">
                            <div class="ibox-content">
                                <?php 
                                    foreach ($value['value'] as $keyVal => $val) {
                                        if(isset($val['extend'])){
                                            $extend = explode(' ', $val['extend']);
                                        }
                                        $keyword = $key.'_'.$keyVal;
                                ?>
                                    <?php 
                                        if($val['type'] == 'text'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                        <?php if(isset($val['extend'])){ ?>
                                                        <span style="color:#9fafba;" class="va-highlight" data-start="0" data-end="<?php echo $extend[2] ?>"><span class="titleCount">0</span>  trên <?php echo $val['extend'] ?> kí tự</span>
                                                        <?php } ?>
                                                    </div>
                                                    <input type="text" name="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>" value="<?php echo (isset($temp[$keyword]) ? $temp[$keyword] : '') ?>" class="form-control " autocomplete="off" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php 
                                        if($val['type'] == 'images'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                    </div>
                                                    <input type="text" name="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>" value="<?php echo (isset($temp[$keyword]) ? $temp[$keyword] : '') ?>" class="form-control va-img-click" autocomplete="off" placeholder="" onclick="BrowseServerInput(this)">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php 
                                        if($val['type'] == 'textarea'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                        <?php if(isset($val['extend'])){ ?>
                                                        <span style="color:#9fafba;" class="va-highlight" data-start="0" data-end="<?php echo $val['extend'] ?>"><span class="titleCount">0</span>  trên <?php echo $val['extend'] ?> kí tự</span>
                                                        <?php } ?>
                                                    </div>
                                                    <input type="hidden" name="<?php echo 'config['.$key.'_'.$keyVal.'][module]'; ?>" value="<?php echo (isset($key) ? $key : '') ?>" class="form-control " autocomplete="off" placeholder="">
                                                    <textarea name="<?php echo 'config['.$key.'_'.$keyVal.'][content]'; ?>" cols="40" rows="10" value="" class="form-control "  autocomplete="off" style="height:108px;" placeholder="" autocomplete="off"><?php echo (isset($temp[$keyword]) ? $temp[$keyword] : '') ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php 
                                        if($val['type'] == 'files'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                    </div>
                                                    <input type="text" name="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>" value="<?php echo (isset($temp[$keyword]) ? $temp[$keyword] : '') ?>" class="form-control" placeholder="" onclick="BrowseServerAlbum(this, 'files')">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php 
                                        if($val['type'] == 'editor'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                        <?php if(isset($val['extend'])){ ?>
                                                        <span style="color:#9fafba;" class="va-highlight" data-start="0" data-end="<?php echo $val['extend'] ?>"><span class="titleCount">0</span>  trên <?php echo $val['extend'] ?> kí tự</span>
                                                        <?php } ?>
                                                    </div>
                                                    <?php echo form_textarea('config['.$key.'_'.$keyVal.']', (isset($temp[$keyword]) ? $temp[$keyword] : ''), 'class="form-control ck-editor" id="'.'config['.$key.'_'.$keyVal.']'.'" placeholder="" autocomplete="off"');?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php 
                                        if($val['type'] == 'select'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                    </div>
                                                    <select class="form-control" style="width: 100%;" name="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>" id="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>">
                                                        <?php 
                                                        if(isset($val['select']) && is_array($val['select']) && count($val['select'])){
                                                        foreach ($val['select'] as $keySelect => $valSelect) { ?>
                                                            <option value="<?php echo $keySelect ?>" <?php echo (isset($temp[$keyword]) ? ($keySelect == $temp[$keyword] ? 'selected' :'') : '') ?>><?php echo $valSelect ?></option>
                                                        <?php }} ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php 
                                        if($val['type'] == 'select2'){
                                    ?>
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                        <label class="control-label text-left">
                                                            <span><?php echo $val['label'] ?></span>
                                                            <span style="color: red"><?php echo isset($val['attention']) ? $val['attention'] : '' ?></span>
                                                            <a href="<?php echo isset($val['link']) ? $val['link'] : '' ?>" target="_blank"><?php echo isset($val['title']) ? $val['title'] :'' ?></a>
                                                        </label>
                                                    </div>
                                                    <select name="<?php echo 'config['.$key.'_'.$keyVal.']'; ?>" class="form-control select2" style="width: 100%;">
                                                        <?php 
                                                        if(isset($val['select']) && is_array($val['select']) && count($val['select'])){
                                                        foreach ($val['select'] as $keySelect => $valSelect) { 
                                                            ?>
                                                            <option value="<?php echo $keySelect ?>" <?php echo (isset($temp[$keyword]) ? ($keySelect == $temp[$keyword] ? 'selected' :'') : '') ?>><?php echo $valSelect ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>    

            <?php }} ?>
        </div>
        <div class="clearfix">
            <button type="submit" name="save" value="save" class="btn btn-success block m-b pull-right">Lưu thay đổi</button>
        </div>
    </div>
</form>
