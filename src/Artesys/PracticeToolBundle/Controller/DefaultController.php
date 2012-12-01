<?php

namespace Artesys\PracticeToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Artesys\PracticeToolBundle\Form\Model\Exam;
use Artesys\PracticeToolBundle\Form\Type\ExamType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Artesys\PracticeToolBundle\Form\Model\SelectQuestion;
use Artesys\PracticeToolBundle\Form\Type\SelectQuestionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="select")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new SelectQuestionType($em));

        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->bind($request);
            if($form->isValid())
            {
                /* @var $selectQuestion SelectQuestion */
                $selectQuestion = $form->getData();
                $course = $selectQuestion->getCourse();
                $question = $selectQuestion->getQuestionNo();

                //
//                $repository = $this->getDoctrine()->getRepository('ArtesysPracticeToolBundle:Question')
                //バリデーションして、formに表示する方法をためす必要あり
                //カスタムバリデーションも。
//                $aaa = new FormError('aaaaaa');
//                $form['questionNo']->addError($aaa);

                //
                /* @var $repository \Doctrine\ORM\EntityRepository */
                $repository = $this->getDoctrine()->getManager()->getRepository('ArtesysPracticeToolBundle:Question');
                $question = $repository->findOneBy(array('sort'=>$question, 'course'=>$course));

                $response = new RedirectResponse($this->generateUrl('question'));
                $response->headers->setCookie(new Cookie('questionid',  $question->getId(), time() + (3600 * 48)));
                return $response;
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/question", name="question")
     * @Template()
     */
    public function questionAction()
    {
        $request = $this->getRequest();
        $examform = $this->createForm(new ExamType());

        //cookie取得
        $questionId = $request->cookies->get('questionid');

        if($request->isMethod('POST'))
        {
            $questionId = $request->request->get('id');
        }

//        $courseId = 1;
//        $questionId = 1;

        /* @var $repository \Doctrine\ORM\EntityRepository */
        $repository = $this->getDoctrine()->getManager()->getRepository('ArtesysPracticeToolBundle:Question');
        $question = $repository->findOneBy(array('id' => $questionId));

        $examform->get('id')->setData($questionId);
        return array('form'=> $examform->createView(), 'question' => $question);
    }

    /**
     * @Route("/answer", name="answer")
     * @Template()
     */
    public function answerAction()
    {
        /* @var $question \Artesys\PracticeToolBundle\Entity\Question */
        /* @var $repository \Doctrine\ORM\EntityRepository */

        $request = $this->getRequest();
        $examform = $this->createForm(new ExamType());

        if($request->isMethod('POST'))
        {
            $examform->bind($request);
            if($examform->isValid())
            {
                $exam = $examform->getData();

                $repository = $this->getDoctrine()->getManager()->getRepository('ArtesysPracticeToolBundle:Question');
                $question = $repository->findOneBy(array('id' => $exam->getId()));
                $query = $repository->createQueryBuilder('p')
                    ->where('p.course = :course')
                    ->andWhere('p.sort > :sort')
                    ->orderBy('p.sort', 'ASC')
                    ->setMaxResults(1)
                    ->setParameter('course', $question->getCourse())
                    ->setParameter('sort', $question->getSort())
                    ->getQuery();
                $nextQuestions = $query->getResult();

                $nextId = null;
                if(isset($nextQuestions[0])){
                    $nextId = $nextQuestions[0]->getId();
                }

                //正解データ
                $rightAnswer = $question->getTranslation();
                //入力データ
                $inputData = $exam->getInputText();



                $examform = $this->createForm(new ExamType());
                return array(
                    'inputData'=> $inputData,
                    'question' => $question,
                    'nextid' => $nextId,
                    'previousid' => $exam->getId(),
                    'form' => $examform->createView()
                );
            }else{
                $questionId = $examform->getData()->getId();
                $repository = $this->getDoctrine()->getManager()->getRepository('ArtesysPracticeToolBundle:Question');
                $question = $repository->findOneBy(array('id' => $questionId));

                return $this->render('ArtesysPracticeToolBundle:Default:question.html.twig', array(
                    'form' => $examform->createView(),
                    'question' => $question
                ));
            }
        }

    }


}
