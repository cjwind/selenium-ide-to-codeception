<?php
class Converter
{
    public function convertSeleniumProject($filename)
    {
        $projectContent = json_decode(file_get_contents($filename), true);
        $codeLines = $this->convert($projectContent);

        $this->outputPhpStartTag();
        $this->outputCode($codeLines);
    }

    private function convert($projectContent)
    {
        $codeLines = [];
        foreach ($projectContent['tests'] as $test) {
            foreach ($test['commands'] as $command) {
                if (!empty($command['target'])) {
                    $command['target'] = str_replace('css=', '', $command['target']);
                    $command['target'] = str_replace('linkText=', '', $command['target']);
                    $command['target'] = str_replace('xpath=', '', $command['target']);
                }

                switch ($command['command']) {
                    case 'open':
                        $codeLines[] = '$I->amOnPage(\'' . $command['target'] . '\');';
                        break;
                    case 'click':
                        $codeLines[] = '$I->click(\'' . $command['target'] . '\');';
                        break;
                    case 'waitForElementNotVisible':
                        $waitTime = $this->calcWaitTime($command['value']);
                        $codeLines[] = '$I->waitForElementNotVisible(\'' . $command['target'] . '\', ' . $waitTime . ')';
                        break;
                    case 'waitForElementVisible':
                        $waitTime = $this->calcWaitTime($command['value']);
                        $codeLines[] = '$I->waitForElementVisible(\'' . $command['target'] . '\', ' . $waitTime . ')';
                        break;
                    case 'waitForElementPresent':
                        $waitTime = $this->calcWaitTime($command['value']);
                        $codeLines[] = '$I->waitForElement(\'' . $command['target'] . '\', ' . $waitTime . ')';
                        break;
                    case 'waitForElementNotPresent':
                    case 'waitForElementNotEditable':
                    case 'waitForElementEditable':
                    default:
                        $codeLines[] = '// TODO ' . $command['command'] . ' "' . $command['target'] . '"';
                        break;
                }
            }
        }
        return $codeLines;
    }

    private function calcWaitTime($waitTime)
    {
        return ($waitTime / 1000) <= 1 ? 1 : ($waitTime / 1000);
    }

    private function outputPhpStartTag()
    {
        echo "<?php\n";
    }

    private function outputCode($codeLines)
    {
        echo '$I = new AcceptanceTester($scenario);' . "\n";
        echo implode("\n", $codeLines);
        echo "\n";
    }
}
