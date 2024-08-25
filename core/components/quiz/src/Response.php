<?php

namespace Boshnik\Quiz;

class Response
{
    private int $total = 0;
    private array $errors = [];

    public function __construct(
        private readonly Validator $validator
    ) {}

    public function response($message = '', $status = false, $output = ''): array
    {
        return [
            'success' => $status,
            'message' => $message,
            'total' => $this->total,
            'errors' => $this->errors ?: $this->validator->errors,
            'output' => $output,
        ];
    }

    public function success($message = '', $output = ''): array
    {
        return $this->response($message, true, $output);
    }

    public function failure($message = '', $output = ''): array
    {
        return $this->response($message, false, $output);
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }
}