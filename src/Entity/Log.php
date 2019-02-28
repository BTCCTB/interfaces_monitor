<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="logs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getStart() :  ? \DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(? \DateTimeInterface $start) : self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd() :  ? \DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(? \DateTimeInterface $end) : self
    {
        $this->end = $end;

        return $this;
    }

    public function getStatus() :  ? string
    {
        return $this->status;
    }

    public function setStatus(? string $status) : self
    {
        $this->status = $status;

        return $this;
    }

    public function getMessage() :  ? string
    {
        return $this->message;
    }

    public function setMessage(? string $message) : self
    {
        $this->message = $message;

        return $this;
    }

    public function getJob() :  ? Job
    {
        return $this->job;
    }

    public function setJob(? Job $job) : self
    {
        $this->job = $job;

        return $this;
    }
}
