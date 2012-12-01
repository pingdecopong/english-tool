<?php

namespace Artesys\PracticeToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="text")
     */
    private $translation;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="speechSoundPath", type="string", length=255)
     */
    private $speechSoundPath;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="questions")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

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
     * Set sentence
     *
     * @param string $sentence
     * @return Question
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
    
        return $this;
    }

    /**
     * Get sentence
     *
     * @return string 
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set translation
     *
     * @param string $translation
     * @return Question
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;
    
        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Question
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set speechSoundPath
     *
     * @param string $speechSoundPath
     * @return Question
     */
    public function setSpeechSoundPath($speechSoundPath)
    {
        $this->speechSoundPath = $speechSoundPath;
    
        return $this;
    }

    /**
     * Get speechSoundPath
     *
     * @return string 
     */
    public function getSpeechSoundPath()
    {
        return $this->speechSoundPath;
    }

    /**
     * Set course
     *
     * @param \Artesys\PracticeToolBundle\Entity\Course $course
     * @return Question
     */
    public function setCourse(\Artesys\PracticeToolBundle\Entity\Course $course = null)
    {
        $this->course = $course;
    
        return $this;
    }

    /**
     * Get course
     *
     * @return \Artesys\PracticeToolBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }
}