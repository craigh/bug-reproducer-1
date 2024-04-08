<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application extends AbstractPerson
{
    use AnswerTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $hairColor = null;

    /**
     * Many Applications have many Answers
     * @var Collection<int,Answer>|null
     * @note This overrides the property in the AnswerTrait
     * @todo ?Missing inversedBy in ManyToMany definition? Only if bi-directional
     */
    #[ORM\ManyToMany(targetEntity: Answer::class, cascade: ['persist', 'remove'], indexBy: 'answer.questionNumber')]
    protected ?Collection $answers = null;

    #[ORM\ManyToOne(targetEntity: SpecialPerson::class, fetch: 'EAGER', inversedBy: 'applications')]
    private ?SpecialPerson $SpecialPerson = null;

    #[ORM\OneToMany(mappedBy: 'application', targetEntity: Group::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $groups;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHairColor(): ?string
    {
        return $this->hairColor;
    }

    public function setHairColor(?string $hairColor): static
    {
        $this->hairColor = $hairColor;

        return $this;
    }

    public function getSpecialPerson(): ?SpecialPerson
    {
        return $this->SpecialPerson;
    }

    public function setSpecialPerson(?SpecialPerson $SpecialPerson): static
    {
        $this->SpecialPerson = $SpecialPerson;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): static
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->setApplication($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): static
    {
        if ($this->groups->removeElement($group)) {
            $group->setApplication(null);
        }

        return $this;
    }
}
