<?php

namespace Pascal\StringReader;

class StringReader
{

    /**
     * Buffer to operate on
     */
    protected $buffer;

    /**
     * Copy of original string.
     *
     * @var string
     */
    protected $originalString;

    /**
     * Constructs a new StringReader instance.
     *
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->originalString = $string;
        $this->buffer = $string;
    }

    /**
     * Checks if buffer contains given sequence.
     *
     * @param string $sequence
     * @return bool
     */
    public function contains(string $sequence): bool
    {
        return strpos($this->buffer, $sequence) !== false;
    }

    /**
     * Returns sequence from current pointer to given sequence.
     * Returns all if sequence not found or no sequence was given.
     *
     * @param string $sequence
     * @param bool   $skip False to stop before sequence, true to forward given sequence
     * @return bool|string
     */
    public function forward(string $sequence = null, bool $skip = false)
    {
        if($sequence === null) {
            return $this->buffer;
        }

        $forwarded = $this->contains($sequence)
            ? $this->next(strpos($this->buffer, $sequence))
            : $this->next(strlen($this->buffer));

        if ($skip) {
            $this->skip($sequence);
        }

        return $forwarded;
    }

    /**
     * Skips to next line and returns remaining character of current line.
     *
     * @return bool|string
     */
    public function forwardToNextLine()
    {
        return $this->forward(PHP_EOL, true);
    }

    /**
     * Checks if end of buffer is reached.
     */
    public function hasNext()
    {
        return strlen($this->buffer) > 0;
    }

    /**
     * Returns the next character at pointer.
     *
     * @param int $length
     * @return bool|string
     */
    public function next(int $length = 1)
    {
        $bufferCopy = $this->buffer;

        $this->buffer = substr($this->buffer, $length, strlen($this->buffer));

        return substr($bufferCopy, 0, $length);
    }

    /**
     * Resets pointer.
     */
    public function reset()
    {
        $this->buffer = $this->originalString;
    }

    /**
     * Skips a given sequences.
     *
     * @param string $sequence
     */
    protected function skip(string $sequence)
    {
        $this->next(strlen($sequence));
    }

}