<?php

namespace App\Entity;

use App\Repository\SpecialPersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialPersonRepository::class)]
class SpecialPerson extends AbstractPerson
{
    use AnswerTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status;

    /**
     * Many SpecialPersons have many Answers
     * @var Collection<int,Answer>|null
     * @note This overrides the property in the AnswerTrait
     * @todo ?Missing inversedBy in ManyToMany definition? Only if bi-directional
     */
    #[ORM\ManyToMany(targetEntity: Answer::class, cascade: ['persist', 'remove'], indexBy: 'answer.questionNumber')]
    protected ?Collection $answers = null;

    #[ORM\OneToMany(mappedBy: 'SpecialPerson', targetEntity: Application::class, fetch: 'EXTRA_LAZY')]
    private Collection $applications;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setSpecialPerson($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getSpecialPerson() === $this) {
                $application->setSpecialPerson(null);
            }
        }

        return $this;
    }
}