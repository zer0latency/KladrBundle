<?php

namespace zer0latency\KladrBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use zer0latency\KladrBundle\Form\DataTransformer\KladrTransformer;

/**
 * KladrType class
 */
class KladrType extends AbstractType
{
    private static $regionOptions = array(
        'attr' => array(
            'data-source' => '/kladr/region/',
            'placeholder' => 'Регион',
            'class'       => 'kladr-region',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
    );

    private static $cityOptions   = array(
        'attr' => array(
            'data-source' => '/kladr/city/',
            'placeholder' => 'Населенный пункт',
            'class'       => 'kladr-city',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
    );

    private static $streetOptions = array(
        'attr' => array(
            'data-source' => '/kladr/street/',
            'placeholder' => 'Улица',
            'class'       => 'kladr-street',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
    );

    private static $houseOptions  = array(
        'attr'         => array(
            'placeholder' => 'Дом',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
    );

    private static $corpsOptions  = array(
        'attr'         => array(
            'placeholder' => 'Корп.',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
        'required'     => false,
    );

    private static $flatOptions  = array(
        'attr'         => array(
            'placeholder' => 'Кв.',
            'autocomplete' => 'off',
        ),
        'label_render' => false,
        'required'     => false,
    );

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'region',
                'text',
                self::$regionOptions
            )
            ->add(
                'city',
                'text',
                self::$cityOptions
            )
            ->add(
                'street',
                'text',
                self::$streetOptions
            )
            ->add(
                'house',
                'text',
                self::$houseOptions
            )
            ->add(
                'corps',
                'text',
                self::$corpsOptions
            )
            ->add(
                'flat',
                'text',
                self::$flatOptions)
            ->add(
                'address',
                'hidden',
                array()
            )
            ->addViewTransformer(new KladrTransformer());
    }

    public function getName()
    {
        return 'kladr';
    }
}
