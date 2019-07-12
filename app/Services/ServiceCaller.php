<?php
namespace App\Services;

use App\Services\ParseValidatorContract;
use App\Services\TaskContract;

class ServiceCaller
{
    const TASK_SERVICE = 'task';

    const PARSE_VALIDATOR_SERVICE = 'parseValidator';

    public static function call(string $serviceType, $service, ...$args)
    {
        $method = 'call' . ucfirst($serviceType) . 'Service';
        return static::$method($service, $args);
    }

    public static function callTaskService($task, array $args)
    {
        if (is_string($task)) {
            $task = new $task(...$args);
        }

        return static::runTaskService($task);
    }

    public static function callParseValidatorService($parseValidator, array $data)
    {
        if (is_string($parseValidator)) {
            $parseValidator = new $parseValidator;
        }

       return static::runParseValidatorService($parseValidator, $data);
    }

    private static function runTaskService(TaskContract $task)
    {
        return $task->run();
    }

    private static function runParseValidatorService(ParseValidatorContract $parseValidator, array $data)
    {
        return $parseValidator->validate(...$data);
    }
}