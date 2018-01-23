<?php

use Pascal\StringReader\StringReader;
use PHPUnit\Framework\TestCase;

class StringReaderTest extends TestCase
{

    /** @test */
    public function initialize_with_empty_string() {
        $stringReader = new StringReader('');
        $this->assertInstanceOf(StringReader::class, $stringReader);
    }

    /** @test */
    public function initialize_with_non_empty_string() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertInstanceOf(StringReader::class, $stringReader);
    }

    /** @test */
    public function get_next_character_single_character() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('T', $stringReader->next());
    }

    /** @test */
    public function get_next_character_multiple_characters() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('This', $stringReader->next(4));
    }

    /** @test */
    public function get_next_character_end_of_string() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('This is not an empty string.', $stringReader->next(28));
        $this->assertEquals('', $stringReader->next());
    }

    /** @test */
    public function get_first_character_after_reset() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('T', $stringReader->next());
        $stringReader->reset();
        $this->assertEquals('T', $stringReader->next());
    }

    /** @test */
    public function get_characters_until_given_sequence() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('T', $stringReader->next());
        $this->assertEquals('his is not an ', $stringReader->forward('empty'));
    }

    /** @test */
    public function get_characters_until_given_sequence_not_found() {
        $stringReader = new StringReader('This is not an empty string.');
        $this->assertEquals('T', $stringReader->next());
        $this->assertEquals('his is not an empty string.', $stringReader->forward('foobar'));
    }

    /** @test */
    public function forward_to_next_line() {
        $stringReader = new StringReader('This is a ' . PHP_EOL . 'multiline text.');
        $this->assertEquals('This is a ', $stringReader->forwardToNextLine());
        $this->assertEquals('multiline text.', $stringReader->forwardToNextLine());
    }

    /** @test */
    public function string_is_completely_read() {
        $stringReader = new StringReader('This is a ' . PHP_EOL . 'multiline text.');
        $this->assertEquals('This is a ', $stringReader->forwardToNextLine());
        $this->assertTrue($stringReader->hasNext());
        $this->assertEquals('multiline text.', $stringReader->forwardToNextLine());
        $this->assertFalse($stringReader->hasNext());
    }

}
