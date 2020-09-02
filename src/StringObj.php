<?php

/**
 * Class StringObj
 */
class StringObj
{

    const MAX_LENGTH_MODE_STRICT = 'strict';
    const MAX_LENGTH_MODE_LOOSE = 'loose';

    protected $string;
    protected $locked = false;
    protected $trimmed = true;
    protected $maxLength = 0;
    protected $maxLengthMode = 'strict';

    protected function _checkMaxLength()
    {
        if ($this->maxLength && strlen($this->string) > $this->maxLength) {
            if ($this::MAX_LENGTH_MODE_STRICT === $this->maxLengthMode) {
                throw new Exception('String too long, max allowed length is ' . $this->maxLength);
            }
            $this->maxLength = substr($this->string, 0, $this->maxLength);
        }
    }

    public function __construct(string $string)
    {
        $this->string = $string;
        $this->_checkMaxLength();
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function contains($string): bool
    {
        if (version_compare(PHP_VERSION, '8') >= 0) {
            return str_contains($this->string, $string);
        }
        return false !== strpos($this->string, $string);
    }

    public function get(): string
    {
        return $this->string;
    }

    public function isEmpty(): bool
    {
        $string = $this->string;
        if ($this->trimmed) {
            $string = trim($string);
        }
        return !(bool)$string;
    }

    public function isAscii(): bool
    {
        return mb_check_encoding($this->string, 'ASCII');
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function isUnlocked(): bool
    {
        return false === $this->locked;
    }

    public function isJapanese(): bool
    {
        $pattern = '/^[-a-zA-Z0-9_\x{30A0}-\x{30FF}'
            . '\x{3040}-\x{309F}\x{4E00}-\x{9FBF}\s]*$/u';

        return (bool)preg_match($pattern, $this->string);
    }

    public function length(): int
    {
        $string = $this->string;
        if ($this->trimmed) {
            $string = trim($string);
        }
        return strlen($string);
    }

    public function lock()
    {
        $this->locked = true;
        return $this;
    }

    public function lower()
    {
        if ($this->isUnlocked()) {
            $this->string = mb_convert_case($this->string, MB_CASE_LOWER, "UTF-8");
        }
        return $this;
    }

    public function upper()
    {
        if ($this->isUnlocked()) {
            $this->string = mb_convert_case($this->string, MB_CASE_UPPER, "UTF-8");
        }
        return $this;
    }

    public function ucWords()
    {
        if ($this->isUnlocked()) {
            $this->string = ucwords(strtolower($this->string), '("|- ');
        }
        return $this;
    }

    public function firstUpper()
    {
        if ($this->isUnlocked()) {
            $this->string = mb_convert_case($this->string, MB_CASE_TITLE, "UTF-8");
        }
        return $this;
    }

    public function match(string $string)
    {
        return $string === $this->string;
    }

    public function replace(string $needle, string $replace)
    {
        if ($this->isUnlocked()) {
            $this->string = str_replace($needle, $replace, $this->string);
            $this->_checkMaxLength();
        }
        return $this;
    }

    public function trim()
    {
        if ($this->isUnlocked()) {
            $this->string = trim($this->string);
        }
        return $this;
    }

    public function set(string $string)
    {
        if ($this->isUnlocked()) {
            $this->string = $string;
            $this->_checkMaxLength();

        }
        return $this;
    }

    public function setTrimming(bool $bool)
    {
        $this->trimmed = $bool;
        return $this;
    }

    public function setMaxLength(int $length)
    {
        $this->maxLength = $length;
        return $this;
    }

    public function unlock()
    {
        $this->locked = false;
        return $this;
    }

    public function wordCount(): string
    {
        return count(explode(' ', trim($this->string)));
    }

    public function prepend(string $string)
    {
        $this->string = $string . $this->string;
        $this->_checkMaxLength();
        return $this;
    }

    public function append(string $string)
    {
        $this->string = $this->string . $string;
        $this->_checkMaxLength();
        return $this;
    }

    public function htmlDecode()
    {
        $this->string = html_entity_decode($this->string);
        return $this;
    }

    public function htmlEncode()
    {
        $this->string = htmlentities($this->string);
        return $this;
    }

    function startsWith($startString)
    {
        if (version_compare(PHP_VERSION, '8') >= 0) {
            return str_starts_with($this->string, $startString);
        }
        return (substr($this->string, 0, strlen($startString)) === $startString);
    }

    public function endsWith($endString)
    {
        if (version_compare(PHP_VERSION, '8') >= 0) {
            return str_ends_with($this->string, $endString);
        }
        return (substr($this->string, -strlen($endString)) === $endString);
    }
}