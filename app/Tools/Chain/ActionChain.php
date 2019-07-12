<?php
namespace App\Tools\Chain;

class ActionChain
{
    private $chain;

    public function __construct(callable ...$actions)
    {
      $this->chain = array_reduce($actions, function ($last, $current) {
                        return function () use ($last, $current) {
                            if (!$last()) {
                                return true;
                            }

                            return $current();
                        };
                     }, function() {
                            return true;
                     });
    }

    public function do()
    {
       return call_user_func($this->chain);
    }

}