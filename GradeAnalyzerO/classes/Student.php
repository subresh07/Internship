<?php
class Student {
    private int $id;
    private string $name;
    private array $marks;

    public function __construct(int $id, string $name, array $marks) {
        $this->id = $id;
        $this->name = $name;
        $this->marks = $marks;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getMarks(): array {
        return $this->marks;
    }

    public function getTotalScore(): float {
        return array_sum($this->marks);
    }

    public function getAverageScore(): float {
        return count($this->marks) ? $this->getTotalScore() / count($this->marks) : 0;
    }
}
