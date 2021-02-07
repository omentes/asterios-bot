<?php

class CheckerTest extends \Codeception\Test\Unit
{
    /**
     * @var \CliTester
     */
    protected $tester;

    public function testSomeFeature()
    {
        $this->tester->runShellCommand('php worker.php x5 true');
        $this->tester->seeInShellOutput('');
    }
}
