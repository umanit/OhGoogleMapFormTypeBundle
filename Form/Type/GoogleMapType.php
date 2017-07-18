<?php

namespace Oh\GoogleMapFormTypeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class GoogleMapType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Default fields: latitude, longitude
        $builder
            ->add($options['lat_name'], $options['type'], array_merge($options['options'], $options['lat_options']))
            ->add($options['lng_name'], $options['type'], array_merge($options['options'], $options['lng_options']));

        // Optional Address field
        if(isset($options['addr_name']) && $options['addr_name']) {
            $builder->add($options['addr_name'], $options['type'], array_merge($options['options'], $options['addr_options']));
        }

        // Optional Address field use button
        if(isset($options['addr_use_btn']) && $options['addr_use_btn']) {
            $builder->add(
                $options['addr_use_btn']['name'],
                'button',
                array_merge(
                    $options['options'],
                    isset($options['addr_use_btn']['options']) ? $options['addr_use_btn']['options'] : []
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'type'             => 'text',  // the types to render the lat and lng fields as
            'options'          => array(), // the options for both the fields
            'lat_options'      => array(), // the options for just the lat field
            'lng_options'      => array(), // the options for just the lng field
            'addr_options'     => array(), // the options for just the address field
            'addr_use_btn'     => array(), // the options for the address use button
            'lat_name'         => 'lat',   // the name of the lat field
            'lng_name'         => 'lng',   // the name of the lng field
            'addr_name'        => null,    // the name of the addr field
            'error_bubbling'   => false,
            'map_width'        => '100%',  // the width of the map
            'map_height'       => '400px', // the height of the map
            'default_lat'      => 51.5,    // the starting position on the map
            'default_lng'      => -0.1245, // the starting position on the map
            'include_jquery'   => false,   // jquery needs to be included above the field (ie not at the bottom of the page)
            'include_gmaps_js' =>true     // is this the best place to include the google maps javascript?
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
            $view->vars['lat_name'] = $options['lat_name'];
            $view->vars['lng_name'] = $options['lng_name'];
            $view->vars['addr_name'] = $options['addr_name'] ?: null;
            $view->vars['addr_use_btn'] = $options['addr_use_btn'] ?: [];
            $view->vars['map_width'] = $options['map_width'];
            $view->vars['map_height'] = $options['map_height'];
            $view->vars['default_lat'] = $options['default_lat'];
            $view->vars['default_lng'] = $options['default_lng'];
            $view->vars['include_jquery'] = $options['include_jquery'];
            $view->vars['include_gmaps_js'] = $options['include_gmaps_js'];
    }

    public function getParent()
    {
        return FormType::class;
    }

    public function getName()
    {
        return 'oh_google_maps';
    }

    public function getBlockPrefix()
    {
        return 'oh_google_maps';
    }
}
