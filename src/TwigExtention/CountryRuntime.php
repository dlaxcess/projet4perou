<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 06/03/19
 * Time: 20:20
 */

namespace App\TwigExtention;


use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Component\Intl\Intl;

class CountryRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {

    }

    public function countryName($countryCode)
    {
        return Intl::getRegionBundle()->getCountryName($countryCode);
    }
}