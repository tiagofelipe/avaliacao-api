<?php

namespace Uloc\Bundle\AppBundle\Form;

use Doctrine\DBAL\Types\SmallIntType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('tipo', IntegerType::class)
            ->add('Enderecos', CollectionType::class, array(
                'entry_type' => EnderecoFisicoType::class,
                'invalid_message' => 'Endereços defined is invalid',
                'by_reference' => false,
                'allow_add' => true
            ));
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
