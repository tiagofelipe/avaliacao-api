<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Uloc\Bundle\AppBundle\Entity\Criterio;
use Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;

class CriterioEstabelecimentoType extends AbstractType
{ /**
 * {@inheritdoc}
 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('estabelecimento',
            EntityType::class, array(
            'class'=>Estabelecimento::class,
            'required'=>true
    ))->add('criterio', EntityType::class, array(
            'class'=>Criterio::class,
            'required'=>true));}


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento',
            'allow_extra_fields' => false,
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'uloc_bundle_appbundle_criterioestabelecimento';
    }


}
