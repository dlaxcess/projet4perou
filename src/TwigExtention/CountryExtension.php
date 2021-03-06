<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 25/01/19
 * Time: 15:27
 */

namespace App\TwigExtention;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CountryExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('country', [CountryRuntime::class, 'countryName']),
        ];
    }
}