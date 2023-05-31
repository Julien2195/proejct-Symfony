<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('localizeddate', [$this, 'localizedDateFilter']),
        ];
    }

    public function localizedDateFilter($date)
    {
        $formattedDate = $date->format('j F Y');
        $formattedDate = str_replace(
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
            $formattedDate
        );

        return $formattedDate;
    }
}
