<?php

namespace Artesys\PracticeToolBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', 'hidden')
        ->add('inputText', 'textarea')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Artesys\PracticeToolBundle\Form\Model\Exam'
        ));
    }

    public function getName()
    {
        return 'artesys_practicetoolbundle_examtype';
    }
}
