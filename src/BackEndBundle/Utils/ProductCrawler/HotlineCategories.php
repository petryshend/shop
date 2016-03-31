<?php

namespace BackEndBundle\Utils\ProductCrawler;

class HotlineCategories
{
    const DOMAIN = 'http://hotline.ua';

    const LAPTOPS = '/computer/noutbuki-netbuki/';
    const TABLETS = '/computer/planshety/';
    const DESKTOPS = '/computer/nastolnye-kompyutery/';
    const MONITORS = '/computer/monitory/';
    const SMARTPHONES = '/mobile/mobilnye-telefony-i-smartfony/';

    /**
     * @return string[]
     */
    public static function getAsArray() : array
    {
        return [
            self::LAPTOPS,
            self::TABLETS,
            self::DESKTOPS,
            self::MONITORS,
            self::SMARTPHONES,
        ];
    }
}
