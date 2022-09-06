<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2><?php echo translate('cms_lang.menu.ManageMenu', $language) ?></h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.menu.home_menu', $language) ?></a>
         </li>
         <li class="active"><strong><?php echo translate('cms_lang.menu.ManageMenu', $language) ?></strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo translate('cms_lang.menu.ManageMenu', $language) ?> </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="delete-all" data-module="<?php echo $module; ?>"><?php echo translate('cms_lang.menu.delete_all', $language) ?></a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="5">5 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                        <option value="10">10 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                        <option value="15">15 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                        <option value="20">20 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                        <option value="25">25 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.menu.Record3', $language) ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.menu.tourjet_placeholder', $language) ?>" class="form-control"> 
                                            </span>
                                        </div>
                                        <span class="input-group-btn"> 
                                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.menu.Search2', $language) ?>
                                        </button> 
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/menu/menu/createmenu/'.$language) ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> <?php echo translate('cms_lang.menu.AddaNewMenu', $language) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th ><?php echo translate('cms_lang.menu.Title4', $language) ?></th>
                            <th class="text-center" >Từ khóa</th>
                            <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                            <?php foreach($languageList as $key => $val){ ?>
                            <th class="text-center" style="width: 135px;">
                                <span class="icon-flag img-cover"><img src="<?php echo getthumb($val['image']); ?>" alt=""></span>
                            </th>
                            <?php }} ?>
                            <th style="width:150px;" class="text-center"><?php echo translate('cms_lang.menu.DateCreated', $language) ?></th>
                            <th style="width:150px;" class="text-center"><?php echo translate('cms_lang.menu.Creator1', $language) ?></th>
                            <th class="text-center" style="width:103px;"><?php echo translate('cms_lang.menu.Manipulation3', $language) ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($menuCatalogue) && is_array($menuCatalogue) && count($menuCatalogue)){ ?>
                            <?php foreach($menuCatalogue as $key => $val){ ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td> 
                                    <div class="title"><a class="maintitle" href="<?php echo site_url('backend/menu/menu/index/'.$val['id'].'/'.$language); ?>" title=""><?php echo $val['title']; ?></a></div>
                                </td>
                                <td class="text-primary text-center"><?php echo $val['value']; ?></td>
                                
                                <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                                <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
                                <td class="text-center "><a class="text-danger  " href="<?php echo base_url('backend/menu/menu/index/'.$val['id'].'/'.$valLanguage['canonical'].'') ?>">
                                   <?php echo translate('cms_lang.menu.translate', $language) ?>

                                </a></td>
                                <?php }} ?>
                                <td class="text-center text-primary"><?php echo gettime($val['created_at'],'Y-d-m') ?></td>
                                <td class="text-primary text-center"><?php echo $val['creator']; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/menu/menu/index/'.$val['id'].'/'.$language) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/menu/menu/delete/'.$val['id'].'/'.$language) ?>" class="btn btn-danger menu-delete" data-id="<?php echo $val['id'] ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.menu.empty', $language) ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>