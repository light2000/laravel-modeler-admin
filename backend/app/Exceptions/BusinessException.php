<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class BusinessException extends RuntimeException
{
    /**
     * Machine-readable business error code.
     *
     * Example: ORDER_CLOSED, CATEGORY_LOCKED
     */
    protected string $errorCode = 'BUSINESS_ERROR';

    /**
     * HTTP status code.
     */
    protected int $status = 400;

    /**
     * Extra data for client (optional).
     */
    protected array $context = [];

    public function __construct(?string $errorCode = null, array $context = [], ?Throwable $previous = null)
    {
        if ($errorCode) {
            $this->errorCode = $errorCode;
        }

        $this->context = $context;

        // message 不直接暴露，Renderer 决定如何翻译
        parent::__construct($this->errorCode, 0, $previous);
    }

    /**
     * Business error code.
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * HTTP status code.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Extra context data.
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
