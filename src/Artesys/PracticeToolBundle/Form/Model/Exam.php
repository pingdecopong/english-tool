<?php

namespace Artesys\PracticeToolBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Exam
 *
 */
class Exam
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     *
     */
    private $inputText;


    /**
     * Set Id
     *
     * @param integer $id
     * @return Exam
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inputText
     *
     * @param string $inputText
     * @return Exam
     */
    public function setInputText($inputText)
    {
        $this->inputText = $inputText;
    
        return $this;
    }

    /**
     * Get inputText
     *
     * @return string 
     */
    public function getInputText()
    {
        return $this->inputText;
    }
}
