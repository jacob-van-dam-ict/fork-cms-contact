<?php

namespace Backend\Modules\Contact\Domain\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'street',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.Street',
            ]
        )->add(
            'number',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.Number',
            ]
        )->add(
            'zip_code',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.ZipCode',
            ]
        )->add(
            'city',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.City',
            ]
        )->add(
            'email',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.Email',
            ]
        )->add(
            'phone',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.Phone',
            ]
        )->add(
            'facebook',
            TextType::class,
            [
                'required' => false,
                'label'    => 'Facebook url',
            ]
        )->add(
            'twitter',
            TextType::class,
            [
                'required' => false,
                'label'    => 'Twitter url',
            ]
        )->add(
            'linked_in',
            TextType::class,
            [
                'required' => false,
                'label'    => 'LinkedIn url',
            ]
        )->add(
            'google_plus',
            TextType::class,
            [
                'required' => false,
                'label'    => 'Google+ url',
            ]
        )->add(
            'pinterest',
            TextType::class,
            [
                'required' => false,
                'label'    => 'Pinterest url',
            ]
        )->add(
            'instagram',
            TextType::class,
            [
                'required' => false,
                'label'    => 'Instagram url',
            ]
        )->add(
            'youtube',
            TextType::class,
            [
                'required' => false,
                'label'    => 'YouTube url',
            ]
        )->add(
            'google_maps_key',
            TextType::class,
            [
                'required' => false,
                'label'    => 'lbl.GoogleMapsKey',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ContactDataTransferObject::class,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'contact';
    }
}
