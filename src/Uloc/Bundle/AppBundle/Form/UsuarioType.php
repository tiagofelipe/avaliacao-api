<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('nome', TextType::class)
            ->add('tipoUsuario', IntegerType::class)
            ->add('enderecos', CollectionType::class, array(
                'entry_type' => EnderecoFisicoType::class,
                'invalid_message' => 'Endereços defined is invalid',
                'by_reference' => false,
                'allow_add' => true
            ))
            // ->add('pessoa', )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Usuario::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'uloc_app_bundle_usuario_type';
    }
}
