<?php
namespace App\desafio_bussola\Modules\Generics\Collections;

trait HasDataCollection
{
    protected ?DataCollection $dataCollection = null;

    public function getDataCollection(): ?DataCollection
    {
        return $this->dataCollection;
    }

    public function setDataCollection(?DataCollection $dataCollection): self
    {
        $this->dataCollection = $dataCollection;
        return $this;
    }
}
