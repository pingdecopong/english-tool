<?php

namespace Artesys\PracticeToolBundle\Form\Model;

use Artesys\PracticeToolBundle\Entity\Course;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * SelectQuestion
 *
 */
class SelectQuestion
{

    /**
     * @var Course
     *
     * @Assert\Type(type="Artesys\PracticeToolBundle\Entity\Course")
     * @Assert\NotBlank()
     */
    private $course;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     */
    private $questionNo;


    /**
     * Set course
     *
     * @param Course $course
     * @return SelectQuestion
     */
    public function setCourse($course)
    {
        $this->course = $course;
    
        return $this;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set questionNo
     *
     * @param integer $questionNo
     * @return SelectQuestion
     */
    public function setQuestionNo($questionNo)
    {
        $this->questionNo = $questionNo;
    
        return $this;
    }

    /**
     * Get questionNo
     *
     * @return integer 
     */
    public function getQuestionNo()
    {
        return $this->questionNo;
    }
}
