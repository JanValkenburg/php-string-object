<?php

abstract class Tester
{

    private $success = 0;
    private $failed = [];

    abstract function run();

    public function __destruct()
    {
        echo 'success: ' . $this->success;
        if ($this->failed) {
            echo '<br>';
            echo 'failed: ' . count($this->failed) . ' - ' . implode(', ', $this->failed);
        }
    }

    final function getCalledMethod()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        return $trace[2]['function'];
    }

    final function methodList()
    {
        return array_diff(
            get_class_methods(get_called_class()),
            get_class_methods('Tester')
        );
    }

    function _isEqual($arg1, $arg2, bool $strict = false)
    {
        if ($strict && $arg1 === $arg2) {
            $this->success++;
        } elseif (false === $strict && $arg1 == $arg2) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

    function _isNotEqual($arg1, $arg2, bool $strict = false)
    {
        if ($strict && $arg1 !== $arg2) {
            $this->success++;
        } elseif (false === $strict && $arg1 != $arg2) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

    function _isTrue(bool $isTrue)
    {
        if (true === $isTrue) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

    function _isFalse(bool $isTrue)
    {
        if (false === $isTrue) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

}