<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="footer">
    <div class="pull-right">
    	<?php echo translate('cms_lang.footer.ft_welcome', $language) ?>
    </div>
    <div>
        <strong>Copyright</strong> <?php echo translate('cms_lang.footer.ft_company', $language) ?> <?php echo date('Y'); ?>
    </div>
</div>