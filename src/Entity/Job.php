<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Log", mappedBy="job", orphanRemoval=true)
     */
    private $logs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $frequency;

    /**
     * @var Log[] Array of log for this job execution
     */
    private $arrayLogs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $command;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
        $this->arrayLogs = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Log[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setJob($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getJob() === $this) {
                $log->setJob(null);
            }
        }

        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @param $arrayLog Log[]
     */
    public function setArrayLogs($arrayLog)
    {
        $this->arrayLogs = $arrayLog;
    }

    /**
     * @return Log[]
     */
    public function getArrayLogs()
    {
        return $this->arrayLogs;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function setCommand(?string $command): self
    {
        $this->command = $command;

        return $this;
    }
}
