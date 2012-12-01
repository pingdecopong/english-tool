<?php

namespace Artesys\PracticeToolBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Artesys\PracticeToolBundle\Entity\Question;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;

class SelectQuestionType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', 'entity', array(
                'class' => 'ArtesysPracticeToolBundle:Course',
                'query_builder' => function($repository){
                    return $repository->createQueryBuilder('p')->orderBy('p.sort', 'ASC');
                },
                'property' => 'name'
            ))
//            ->add('questionNo', 'text');
            ->add('questionNo', 'integer', array(
                'invalid_message'   =>  '数値を入力して下さい。'
            ));

        //validation
        $em = $this->em;
        $builder->addEventListener(FormEvents::POST_BIND, function($event) use($em){

            /* @var $form Form */
            $form = $event->getForm();
            $questionNo = $form['questionNo']->getData();
            $course = $form['course']->getData();

            if($form['questionNo']->isValid())
            {
                //DBチェック
                $question = $em->getRepository('ArtesysPracticeToolBundle:Question')->findOneBy(array('sort'=>$questionNo, 'course'=>$course));
                if($question === null)
                {
                    $form['questionNo']->addError(new FormError('存在しないQuestionIDです。存在するIDを指定して下さい。'));
                }
            }
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Artesys\PracticeToolBundle\Form\Model\SelectQuestion'
        ));
    }

    public function getName()
    {
        return 'artesys_practicetoolbundle_selectquestiontype';
    }
}

