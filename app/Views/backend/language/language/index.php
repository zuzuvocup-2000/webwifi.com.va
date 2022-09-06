<?php  
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2><?php echo translate('cms_lang.ngonngu.ngonngu_title', $language) ?></h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.ngonngu.ngonngu_home', $language) ?></a>
         </li>
         <li class="active"><strong><?php echo translate('cms_lang.ngonngu.ngonngu_title', $language) ?></strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo translate('cms_lang.ngonngu.ngonngu_title', $language) ?> </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
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
                                        <option value="20">20 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="40">40 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="50">50 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="60">60 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="70">70 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="80">80 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="90">90 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                        <option value="100">100 <?php echo translate('cms_lang.ngonngu.ngonngu_record', $language) ?></option>
                                    </select>
                                    
                                   
                                    
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.ngonngu.ngonngu_placeholder', $language) ?>" class="form-control"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.ngonngu.ngonngu_search', $language) ?>
                                            </button> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/language/language/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i><?php echo translate('cms_lang.ngonngu.ngonngu_add', $language) ?></a>
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
                            <th class="text-center" style="width: 100px;"><?php echo translate('cms_lang.ngonngu.ngonngu_img', $language) ?></th>
                            <th ><?php echo translate('cms_lang.ngonngu.ngonngu_language', $language) ?></th>
                            
                            <th class="text-center" style="width: 67px;"><?php echo translate('cms_lang.ngonngu.ngonngu_location', $language) ?></th>
                            <th style="width:150px;"><?php echo translate('cms_lang.ngonngu.ngonngu_creator', $language) ?></th>
                            <th style="width:150px;" class="text-center"><?php echo translate('cms_lang.ngonngu.ngonngu_created_at', $language) ?></th>
                            <th class="text-center" style="width:88px;"><?php echo translate('cms_lang.ngonngu.ngonngu_status', $language) ?></th>
                            <th class="text-center" style="width:88px;"><?php echo translate('cms_lang.ngonngu.ngonngu_active', $language) ?></th>
                            <th class="text-center" style="width:103px;"> <?php echo translate('cms_lang.ngonngu.ngonngu_action', $language) ?></th>
                       </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
                            <?php foreach($languageList as $key => $val){ ?>
                            <?php  
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                                $default = ($val['default'] == 1) ? '<span class="text-navy">Yes</span>'  : '<span class="text-danger">No</span>';

                            ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                 <td class="text-center "><span style="height:50px;" class="image img-cover"><img src="<?php echo $val['image']; ?>" alt=""> </span></td>

                                <td><a href="<?php echo base_url('backend/language/language/index/?catalogueid='.$val['id'].'') ?>"><?php echo $val['title'] ?></a></td>
                                                               <td class="text-center text-primary">
                                    <?php echo form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$module.'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');?>

                                </td>
                                <td class="text-primary"><?php echo $val['creator']; ?></td>
                                <td class="text-center text-primary"><?php echo gettime($val['created_at'],'Y-d-m') ?></td>
                              
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                                 <td class="text-center td-default" data-lang="<?php echo $val['canonical'] ?>" data-module="<?php echo $module; ?>" data-where="id"><?php echo $default; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/language/language/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/language/language/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.ngonngu.empty', $language) ?></span></td>
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