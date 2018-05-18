<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento;

class EstabelecimentoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cnpj')
            ->add('nomeFantasia')
            ->add('razaoSocial')
            ->add('tipo');
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uloc\Bundle\AppBundle\Entity\Estabelecimento',
            'allow_extra_fields' => false,
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'uloc_bundle_appbundle_estabelecimento';
    }


}
