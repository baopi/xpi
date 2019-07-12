<?php
namespace App\Services;

interface ParseValidatorContract
{
    public function validate(array $data): ParseValidatorResult;
}