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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Generate duration from start en end time
     *
     * @return float|null The duration in minutes
     */
    public function getDuration(): ?float
    {
        if ($this->getEnd() !== null) {
            $deltaT = $this->getEnd()->format('U') - $this->getStart()->format('U');

            return round($deltaT / 60);
        }

        return null;
    }

    /**
     * Convert duration in human readable time [hh:mm]
     *
     * @return string|null The duration in human readable time
     */
    public function getPrettyDuration(): ?string
    {
        if ($this->getDuration() !== null) {
            return sprintf('%02d:%02d', floor($this->getDuration() / 60), $this->getDuration() % 60);
        }

        return null;
    }

    /**
     * Get the duration color label based on execution time
     *
     * @return string
     */
    public function getDurationColor(): string
    {
        if ($this->getStatus() == 'error') {
            return 'danger';
        }
        if ($this->getDuration() === null) {
            $color = 'secondary';
        } elseif ($this->getDuration() < 30) {
            //green
            $color = 'success';
        } elseif ($this->getDuration() < 60) {
            // ligth blue
            $color = 'info';
        } elseif ($this->getDuration() < 120) {
            //blue
            $color = 'primary';
        } elseif ($this->getDuration() < 240) {
            //orange
            $color = 'warning';
        } else {
            //red
            $color = 'danger';
        }

        return $color;
    }

    public function getDurationIcon(): string
    {
        if ($this->getStatus() == 'error') {
            return '<i class="fa fa-bomb"></i>';
        }

        if ($this->getDuration() === null) {
            $icon = '<i class="fa fa-question-circle"></i>';
        } elseif ($this->getDuration() < 30) {
            //green
            $icon = '<i class="fa fa-check-circle"></i>';
        } elseif ($this->getDuration() < 60) {
            // ligth blue
            $icon = '<i class="fa fa-check-circle"></i>';
        } elseif ($this->getDuration() < 120) {
            //blue
            $icon = '<i class="fa fa-check-circle"></i>';
        } elseif ($this->getDuration() < 240) {
            //orange
            $icon = '<i class="fa fa-check-circle"></i>';
        } else {
            //red
            $icon = '<i class="fa fa-warning"></i>';
        }

        return $icon;
    }

    public function __toString()
    {
        return "Exec. time: " . $this->getPrettyDuration() . " | " .
        "Status: " . $this->getStatus() . " | " .
        "Message: " . $this->getMessage();
    }
}
