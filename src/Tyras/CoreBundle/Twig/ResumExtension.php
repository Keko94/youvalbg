<?php

namespace Tyras\CoreBundle\Twig;

class ResumExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('resum', array($this, 'getResum')),
        );
    }

    public function getResum($string, $maxLength = 200)
    {
        $parts = preg_split('/([\s\n\r]+)/', strip_tags(html_entity_decode($string)), null, PREG_SPLIT_DELIM_CAPTURE);
        $parts_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $parts_count; ++$last_part) {
            $length += strlen($parts[$last_part]);
            if ($length > $maxLength) { break; }
        }

        return implode(array_slice($parts, 0, $last_part));
    }

    public function getName()
    {
        return 'resum_extension';
    }
}