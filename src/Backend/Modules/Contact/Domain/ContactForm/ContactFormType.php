<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Form\Type\EditorType;
use Common\Form\ImageType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'required' => true,
                'label'    => 'lbl.Title',
            ]
        )->add(
            'text',
            EditorType::class,
            [
                'required' => true,
                'label'    => 'lbl.Content',
            ]
        )->add(
            'background_image',
            ImageType::class,
            [
                'required'    => false,
                'label'       => 'lbl.BackgroundImage',
                'image_class' => Image::class,
            ]
        )->add(
            'form',
            ChoiceType::class,
            [
                'required'    => false,
                'choices'     => $options['form_choices'],
                'label'       => 'lbl.ContactForm',
                'placeholder' => 'lbl.ChooseForm'
            ]
        )->add(
            'show_title',
            CheckboxType::class,
            [
                'required'    => false,
                'label'       => 'lbl.ShowTitle',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['form_choices']);
        $resolver->setDefaults(['data_class' => ContactFormDataTransferObject::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'contact_form';
    }
}
