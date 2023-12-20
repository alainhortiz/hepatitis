<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class usuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text',array('required' => true,'invalid_message' =>'Por favor teclee un usuario'))
            ->add('password','password')
            ->add('nombre','text',array('required' => true,'invalid_message' =>'Por favor teclee un nombre'))
            ->add('primerApellido','text',array('required' => true,'invalid_message' =>'Por favor teclee el primer apellido'))
            ->add('segundoApellido','text')
            ->add('isActive','checkbox')
            ->add('unidad',
                'entity',array('class'=>'AppBundle\Entity\unidad',
                    'query_builder'=>function (EntityRepository $er)
                    {
                        return $er->createQueryBuilder('u');

                    },
                    'choice_label' =>'getNombre'))
            ->add('nivelacceso',
                'entity',array('class'=>'AppBundle\Entity\nivelAcceso',
                    'query_builder'=>function (EntityRepository $er)
                    {
                        return $er->createQueryBuilder('n');

                    },
                    'choice_label' =>'getNombre'))
            ->add('role',
                'entity',array('class'=>'AppBundle\Entity\role',
                    'query_builder'=>function (EntityRepository $er)
                    {
                        return $er->createQueryBuilder('r');

                    },
                    'choice_label' =>'getNombre'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'usuario';
    }


}
