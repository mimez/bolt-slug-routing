<?php
namespace Bolt\Extension\MichaelMezger\SlugRouting\Slugify;

use Cocur\Slugify\SlugifyInterface;

class Slugify implements SlugifyInterface
{
    public function slugify($string, $separator = '-') {
        return $string;
    }
}
