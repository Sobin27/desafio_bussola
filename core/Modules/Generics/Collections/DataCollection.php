<?php
namespace App\desafio_bussola\Modules\Generics\Collections;

class DataCollection
{
    private array $collector = [];

    /**
     * @param string $key
     * @param mixed $value
     * @return DataCollection
     */
    public function add(string $key, mixed $value): self
    {
        $this->collector[$key] = $value;
        return $this;
    }

    public function all(): array
    {
        return $this->collector;
    }
}
