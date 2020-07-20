<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class SearchByTagSpeakerType extends AbstractType
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         /* Data tag url and speaker tag url comes from
         AdminController and are given to the algolia-autocomplete.js
         in public/js */
        $builder
            ->add('name', null, ['attr' => [
                'class' => 'js-search-autocomplete',
                'data-tag-url' => $this->router->generate('utility_tags'),
                'data-speaker-url' => $this->router->generate('utility_speakers')
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}