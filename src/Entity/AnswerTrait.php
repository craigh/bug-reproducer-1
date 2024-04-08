<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

trait AnswerTrait
{
    /**
     * NOTE: Override on main entity as this requires a join table
     */
    protected ?Collection $answers = null;
    public function getAnswers(): ?Collection
    {
        return $this->answers;
    }

    public function setAnswers(?Collection $answers): static
    {
        $this->answers = $answers;

        return $this;
    }


    public function getAnswer(int $questionNumber): ?Answer
    {
        return $this->answers->findFirst(fn (int $key, Answer $answer) => $answer->getQuestionNumber() === $questionNumber);
    }

    public function setAnswer(int $questionNumber, string $response): static
    {
        $answer = $this->answers->findFirst(fn (int $key, Answer $answer) => $answer->getQuestionNumber() === $questionNumber);
        if ($answer !== null) {
            $answer->setResponse($response);
        } else {
            $answer = new Answer($questionNumber, $response);
            $this->answers->add($answer);
        }

        return $this;
    }

    public function __get(string $name)
    {
        if (preg_match('/my_answer(\d+)?/', $name, $matches)) {
            return $this->getAnswer($matches[1]);
        }
    }

    public function __set(string $name, $value)
    {
        if (preg_match('/my_answer(\d+)?/', $name, $matches)) {
            $this->setAnswer($matches[1], $value);
        }
    }

    public function __isset(string $name)
    {
        if (preg_match('/my_answer(\d+)?/', $name, $matches)) {
            return $this->getAnswer($matches[1]) !== null;
        }

        return false;
    }
}