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
    const EBOOKS = '/computer/elektronnye-knigi/';
    const GRAPHIC_CARDS = '/computer/videokarty/';
    const ROUTERS = '/computer/besprovodnoe-oborudovanie/';

    public static function getAsArray() : array
    {
        return [
            self::LAPTOPS,
            self::TABLETS,
            self::DESKTOPS,
            self::MONITORS,
            self::SMARTPHONES,
            self::EBOOKS,
            self::GRAPHIC_CARDS,
            self::ROUTERS,
        ];
    }

    public static function getMappingsToActualCategories() : array
    {
        return [
            self::LAPTOPS => 'laptops',
            self::TABLETS => 'tablets',
            self::DESKTOPS => 'desktops',
            self::MONITORS => 'monitors',
            self::SMARTPHONES => 'smartphones',
            self::EBOOKS => 'ebooks',
            self::GRAPHIC_CARDS => 'graphic-cards',
            self::ROUTERS => 'routers',
        ];
    }
}
