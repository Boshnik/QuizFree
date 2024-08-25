<?php

namespace Boshnik\Quiz;

class Validator
{
    protected array $errors = [];

    public function __construct(
        public \modX $modx,
        protected array $data = []
    ) {}

    public function validate($rules): bool
    {
        foreach ($rules as $field => $fieldRules) {
            $fieldRules = explode('|', $fieldRules);
            foreach ($fieldRules as $rule) {
                if (!empty($rule)) {
                    $this->applyRule($field, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    protected function applyRule($field, $rule) {
        if (strpos($rule, ':') !== false) {
            list($ruleName, $parameter) = explode(':', $rule);
        } else {
            $ruleName = $rule;
            $parameter = null;
        }

        $methodName = 'validate' . ucfirst($ruleName);
        if (!method_exists($this, $methodName)) {
            throw new Exception("Validation rule $ruleName not supported.");
        }

        $this->$methodName($field, $parameter);
    }

    protected function validateRequired($field): void
    {
        if (empty($this->data[$field])) {
            $this->errors[$field][] = $this->modx->lexicon('quiz_validation_field_required', ['field' => $field]);
        }
    }

    protected function validateEmail($field): void
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $this->modx->lexicon('quiz_validation_field_email', ['field' => $field]);
        }
    }

    protected function validateMin($field, $parameter): void
    {
        if (strlen($this->data[$field]) < $parameter) {
            $this->errors[$field][] = $this->modx->lexicon('quiz_validation_field_email', [
                'field' => $field,
                'parameter' => $parameter,
            ]);
        }
    }

    protected function validateMax($field, $parameter): void
    {
        if (strlen($this->data[$field]) > $parameter) {
            $this->errors[$field][] = $this->modx->lexicon('quiz_validation_field_max', [
                'field' => $field,
                'parameter' => $parameter,
            ]);
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new Exception("Property {$name} does not exist.");
        }
    }
}