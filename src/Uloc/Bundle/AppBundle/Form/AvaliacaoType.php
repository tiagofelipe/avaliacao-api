<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\Avaliacao;
use Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Funcionario;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class AvaliacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nota', IntegerType::class)
            ->add('comentario', TextType::class)
            ->add('usuario', EntityType::class, array(
                'class' => Usuario::class
            ))
            ->add('estabelecimento', EntityType::class, array(
                'class' => Estabelecimento::class
            ))
            ->add('criterioEstabelecimento', EntityType::class, array(
                'class' => CriterioEstabelecimento::class
            ))
            ->add('funcionario', EntityType::class, array(
                'class' => Funcionario::class
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Avaliacao::class,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix()
    {
        return 'uloc_app_bundle_avaliacao_type';
    }
}
