<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class EnderecoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logradouro', EntityType::class, array(
                'class' => Logradouro::class,
                'required' => true,
                'invalid_message' => 'Logradouro inválido'
            ))
            ->add('numero', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Número inválido'
            ))
            ->add('cep', TextType::class, array(
                'required' => false,
                'invalid_message' => 'CEP inválido'
            ))
            ->add('complemento', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Complemento inválido'
            ))
            ->add('estabelecimento', EntityType::class, array(
                'class' => Estabelecimento::class,
                'required' => false,
                'invalid_message' => 'Estabelecimento não encontrado'
            ))
            ->add('usuario', EntityType::class, array(
                'class' => Usuario::class,
                'required' => false,
                'invalid_message' => 'Usuario não encontrado'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Endereco::class,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'uloc_app_bundle_endereco_fisico_type';
    }
}
