<?php namespace CodeIgniterCart\Config;

use CodeIgniter\Config\Services as CoreServices;

require_once SYSTEMPATH . 'Config/Services.php';

class Services extends CoreServices
{
    public static function cart($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cart');
        }
        return new \CodeIgniterCart\Cart();
    }
}
