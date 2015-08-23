<?php

namespace zer0latency\KladrBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class KladrTransformer implements DataTransformerInterface
{
    /**
     * @param string $string
     *
     * @return array
     */
    public function transform($string)
    {
        return ($string) ? array (
            'address' => $string,
            'region' => null,
            'city' => null,
            'street' => null,
            'house' => null,
            'corps' => null,
            'flat' => null,
        ) : null;

    }

    /**
     * @param array $array
     *
     * @return string Address
     */
    public function reverseTransform($array)
    {
        return $array['address'];
    }


}