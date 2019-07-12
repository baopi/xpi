<?php
namespace App\Services;

class ParseValidatorResult
{
    public $errors;

    public $parser;

    public static function make(array $errors = [], array $parses = [])
    {
        return new static($errors, $parses);
    }

    public function __construct(array $errors = [], array $parses = [])
    {
        if (!empty($errors)) $this->errors = $errors;
        if (!empty($parses)) $this->parser = new ParserFromValidate($parses);

        return $this;
    }
}