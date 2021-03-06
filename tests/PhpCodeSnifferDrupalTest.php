<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests the PHP_CodeSniffer task using the Drupal conventions.
 */
class PhpCodeSnifferDrupalTest extends PhpCodeSnifferTestBase
{
    /**
     * Tests Drupal code to make sure CodeSniffer triggers the appropriate errors.
     *
     * @param string $fixture
     *   Name of the fixture.
     * @param string $configuration
     *   The name of the configuration to use in the task
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testDrupalPhpCodeSnifferDetector($fixture, $configuration, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new RunContext($collection);
        $task = $this->getTask('phpcs', $configuration);
        $result = $task->run($context);
        $this->assertFailures($expected, $this->getFailures($result));
    }

    /**
     * Provides test cases for testing the PHP_CodeSniffer task for Drupal.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider()
    {
        return [
            [
                'phpcs/DrupalClass.php',
                'drupal-conventions',
                [
                    'error' => [
                        18 => 1,
                    ],
                ],
            ],
        ];
    }
}
