<?php

namespace Uloc\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomeArquivo', TextType::class)
            ->add('nome', TextType::class, array(
                'property_path' => 'nomeOriginal'
            ))
            ->add('posicao', IntegerType::class)
            ->add('dataExibicao', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm:ss'
            ))->add('dataExpiracao', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm:ss'
            ))
            ->add('situacao')
            ->add('hasVideo')
            ->add('url');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Uloc\Bundle\AppBundle\Entity\Banner',
            'allow_extra_fields' => false,
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'uloc_bundle_appbundle_banner';
    }


}
