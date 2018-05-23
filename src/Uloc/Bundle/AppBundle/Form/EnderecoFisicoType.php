<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\Endereco\App\Municipio;
use Uloc\Bundle\AppBundle\Entity\Endereco\EnderecoFisico;
use Uloc\Bundle\AppBundle\Entity\Endereco\TipoFinalidadeEndereco;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class EnderecoFisicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('municipio', EntityType::class, array(
                'class' => Municipio::class,
                'required' => true,
                'invalid_message' => 'Município inválido'
            ))
            ->add('finalidade', EntityType::class, array(
                'class' => TipoFinalidadeEndereco::class,
                'required' => false,
                "invalid_message" => "Finalidade {{ value }} nao encontrada"
            ))

            ->add('bairro', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Bairro inválido'
            ))
            ->add('logradouro', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Logradouro inválido'
            ))
            ->add('numero', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Número inválido'
            ))
            ->add('complemento', TextType::class, array(
                'required' => false,
                'invalid_message' => 'Complemento inválido'
            ))
            ->add('estabelecimento', EntityType::class, array(
                'class' => Estabelecimento::class,
                'invalid_message' => 'Estabelecimento não encontrado'
            ))
            ->add('usuario', EntityType::class, array(
                'class' => Usuario::class,
                'invalid_message' => 'Usuario não encontrado'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => EnderecoFisico::class,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'uloc_app_bundle_endereco_fisico_type';
    }
}
