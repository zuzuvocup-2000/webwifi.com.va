<?php
    $baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $menu_footer = get_menu([
        'keyword' => 'menu_footer',
        'language' => $language,
        'output' => 'array'
    ]);
?>
<footer class="footer-pc">
    
</footer>
