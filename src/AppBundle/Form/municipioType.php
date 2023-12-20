<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class municipioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('nombre')
            ->add('provincia',
                'entity',array('class'=>'AppBundle\Entity\provincia',
                    'query_builder'=>function (EntityRepository $er)
                    {
                        return $er->createQueryBuilder('p');

                    },
                    'choice_label' =>'getNombre'))
            ->add('unidad',
                'entity',array('class'=>'AppBundle\Entity\unidad',
                    'query_builder'=>function (EntityRepository $er)
                    {
                        return $er->createQueryBuilder('u');

                    },
                    'choice_label' =>'getNombre'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\municipio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'municipio';
    }


}
