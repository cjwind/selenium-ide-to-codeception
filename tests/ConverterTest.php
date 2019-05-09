<?php
use PHPUnit\Framework\TestCase;
use cjwind\SeleniumIdeToCodeception\Converter;

final class ConverterTest extends TestCase
{
    public function testConvertSeleniumProjectWithSuiteStructure()
    {
        $converter = new Converter;
        $suites = $converter->convertSeleniumProject(__DIR__ . '/data/ProjectForStructure.side');

        $this->assertCount(3, $suites);
        $this->assertEquals('DefaultSuite', $suites[0]['name']);
        $this->assertCount(1, $suites[0]['tests']);
        $this->assertEquals('Seleniumsite', $suites[0]['tests'][0]['name']);
        $this->assertNotEmpty($suites[0]['tests'][0]['codeLines']);
        $this->assertEquals('Hello', $suites[1]['name']);
        $this->assertCount(3, $suites[1]['tests']);
        $this->assertEquals('Seleniumsite', $suites[1]['tests'][0]['name']);
        $this->assertNotEmpty($suites[1]['tests'][0]['codeLines']);
        $this->assertEquals('Google', $suites[1]['tests'][1]['name']);
        $this->assertNotEmpty($suites[1]['tests'][1]['codeLines']);
        $this->assertEquals('Yahoo', $suites[1]['tests'][2]['name']);
        $this->assertEmpty($suites[1]['tests'][2]['codeLines']);
        $this->assertEquals('DefaultTestSuite', $suites[2]['name']);
        $this->assertCount(1, $suites[2]['tests']);
        $this->assertEquals('Facebook', $suites[2]['tests'][0]['name']);
        $this->assertEmpty($suites[2]['tests'][0]['codeLines']);
    }
}
