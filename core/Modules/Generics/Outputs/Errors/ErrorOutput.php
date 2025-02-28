<?php
namespace App\desafio_bussola\Modules\Generics\Outputs\Errors;

use App\desafio_bussola\Modules\Generics\Outputs\Interfaces\OutPutInterface;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\Generics\Presenters\Errors\ErrorOutPutPresenter;


class ErrorOutput implements OutputInterface
{
    private StatusOutput $status;
    private string $message;
    private string $errorCode;
    private array $errors;

    public function __construct(StatusOutput $status, string $message, string $errorCode, array $errors = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->errorCode = $errorCode;
        $this->errors = $errors;
    }

    public function getStatus(): StatusOutput
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getPresenter(): ErrorOutputPresenter
    {
        return (new ErrorOutputPresenter($this))->present();
    }
}
