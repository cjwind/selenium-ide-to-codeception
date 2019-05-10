<?php
namespace cjwind\SeleniumIdeToCodeception;

class Converter
{
    /**
     * Convert Selenium IDE project file *.side to codeception code.
     *
     * @param string $filename *.side
     * @return array [[
     *      'name' => string,
     *      'tests' => [[
     *          'id' => string,
     *          'name' => string,
     *          'codeLines' => array,
     *      ]]
     * ]]
     */
    public function convertSeleniumProject($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception($filename . ' does not exist');
        } else {
            if (!is_file($filename)) {
                throw new \Exception($filename.' is not a file');
            }
        }

        $projectContent = json_decode(file_get_contents($filename), true);

        if ($projectContent === null) {
            throw new \Exception($filename.' can not be parsed. Is it a valid json file?');
        }

        return $this->convert($projectContent);
    }

    private function convert($projectContent)
    {
        $tests = [];
        foreach ($projectContent['tests'] as $test) {
            $tests[$test['id']] = [
                'id' => $test['id'],
                'name' => str_replace(' ', '', $test['name']),
                'codeLines' => $this->convertTest($test),
            ];
        }

        $inSuiteTestIds = [];
        $testSuites = [];
        foreach ($projectContent['suites'] as $suite) {
            $testSuite = [
                'name' => str_replace(' ', '', $suite['name']),
                'tests' => [],
            ];

            foreach ($suite['tests'] as $testId) {
                $testSuite['tests'][] = $tests[$testId];
                $inSuiteTestIds[] = $testId;
            }

            $testSuites[] = $testSuite;
        }

        $defaultTestSuite = [
            'name' => 'DefaultTestSuite',
            'tests' => [],
        ];
        foreach ($tests as $id => $test) {
            if (!in_array($id, $inSuiteTestIds)) {
                $defaultTestSuite['tests'][] = $test;
            }
        }
        $testSuites[] = $defaultTestSuite;

        return $testSuites;
    }

    private function convertTest(&$test)
    {
        $codeLines = [];

        foreach ($test['commands'] as $command) {
            if (!empty($command['target'])) {
                $command['target'] = str_replace('css=', '', $command['target']);
                $command['target'] = str_replace('linkText=', '', $command['target']);
                $command['target'] = str_replace('xpath=', '', $command['target']);
            }

            switch ($command['command']) {
                case 'addSelection':
                    // TODO
                    break;
                case 'answerOnNextPrompt':
                    // TODO
                    break;
                case 'assert':
                    // TODO
                    break;
                case 'assertAlert':
                    // TODO
                    break;
                case 'assertChecked':
                    // TODO
                    break;
                case 'assertConfirmation':
                    // TODO
                    break;
                case 'assertEditable':
                    // TODO
                    break;
                case 'assertElementPresent':
                    // TODO
                    break;
                case 'assertElementNotPresent':
                    // TODO
                    break;
                case 'assertNotChecked':
                    // TODO
                    break;
                case 'assertNotEditable':
                    // TODO
                    break;
                case 'assertNotSelectedValue':
                    // TODO
                    break;
                case 'assertNotText':
                    // TODO
                    break;
                case 'assertPrompt':
                    // TODO
                    break;
                case 'assertSelectedValue':
                    // TODO
                    break;
                case 'assertSelectedLabel':
                    // TODO
                    break;
                case 'assertText':
                    // TODO
                    break;
                case 'assertTitle':
                    // TODO
                    break;
                case 'assertValue':
                    // TODO
                    break;
                case 'check':
                    // TODO
                    break;
                case 'chooseCancelOnNextConfirmation':
                    // TODO
                    break;
                case 'chooseCancelOnNextPrompt':
                    // TODO
                    break;
                case 'chooseOkOnNextConfirmation':
                    // TODO
                    break;
                case 'click':
                    $codeLines[] = '$I->click(\'' . $command['target'] . '\');';
                    break;
                case 'clickAt':
                    // TODO
                    break;
                case 'close':
                    // TODO
                    break;
                case 'doubleClick':
                    // TODO
                    break;
                case 'doubleClickAt':
                    // TODO
                    break;
                case 'dragAndDropToObject':
                    // TODO
                    break;
                case 'editContent':
                    // TODO
                    break;
                case 'executeScript':
                    // TODO
                    break;
                case 'executeAsyncScript':
                    // TODO
                    break;
                case 'mouseDown':
                    // TODO
                    break;
                case 'mouseDownAt':
                    // TODO
                    break;
                case 'mouseMoveAt':
                    // TODO
                    break;
                case 'mouseOut':
                    // TODO
                    break;
                case 'mouseOver':
                    // TODO
                    break;
                case 'mouseUp':
                    // TODO
                    break;
                case 'mouseUpAt':
                    // TODO
                    break;
                case 'open':
                    $codeLines[] = '$I->amOnPage(\'' . $command['target'] . '\');';
                    break;
                case 'pause':
                    // TODO
                    break;
                case 'removeSelection':
                    // TODO
                    break;
                case 'runScript':
                    // TODO
                    break;
                case 'select':
                    // TODO
                    break;
                case 'selectFrame':
                    // TODO
                    break;
                case 'selectWindow':
                    // TODO
                    break;
                case 'sendKeys':
                    // TODO
                    break;
                case 'setSpeed':
                    // TODO
                    break;
                case 'setWindowSize':
                    $resolution = explode('x', $command['target']);
                    $codeLines[] = '$I->resizeWindow(' . $resolution[0] . ', ' . $resolution[1] . ');';
                    break;
                case 'store':
                    // TODO
                    break;
                case 'storeAttribute':
                    // TODO
                    break;
                case 'storeText':
                    // TODO
                    break;
                case 'storeTitle':
                    // TODO
                    break;
                case 'storeValue':
                    // TODO
                    break;
                case 'storeWindowHandle':
                    // TODO
                    break;
                case 'storeXpathCount':
                    // TODO
                    break;
                case 'submit':
                    // TODO
                    break;
                case 'type':
                    // TODO
                    break;
                case 'uncheck':
                    // TODO
                    break;
                case 'verify':
                    // TODO
                    break;
                case 'verifyChecked':
                    // TODO
                    break;
                case 'verifyEditable':
                    // TODO
                    break;
                case 'verifyElementPresent':
                    // TODO
                    break;
                case 'verifyElementNotPresent':
                    // TODO
                    break;
                case 'verifyNotChecked':
                    // TODO
                    break;
                case 'verifyNotEditable':
                    // TODO
                    break;
                case 'verifyNotSelectedValue':
                    // TODO
                    break;
                case 'verifyNotText':
                    // TODO
                    break;
                case 'verifySelectedLabel':
                    // TODO
                    break;
                case 'verifySelectedValue':
                    // TODO
                    break;
                case 'verifyText':
                    // TODO
                    break;
                case 'verifyTitle':
                    // TODO
                    break;
                case 'verifyValue':
                    // TODO
                    break;
                case 'waitForElementEditable':
                    // TODO
                    break;
                case 'waitForElementNotEditable':
                    // TODO
                    break;
                case 'waitForElementNotPresent':
                    // TODO
                    break;
                case 'waitForElementNotVisible':
                    $waitTime = (int)$this->calcWaitTime($command['value']);
                    $codeLines[] = '$I->waitForElementNotVisible(\'' . $command['target'] . '\', ' . $waitTime . ');';
                    break;
                case 'waitForElementPresent':
                    $waitTime = (int)$this->calcWaitTime($command['value']);
                    $codeLines[] = '$I->waitForElement(\'' . $command['target'] . '\', ' . $waitTime . ');';
                    break;
                case 'waitForElementVisible':
                    $waitTime = (int)$this->calcWaitTime($command['value']);
                    $codeLines[] = '$I->waitForElementVisible(\'' . $command['target'] . '\', ' . $waitTime . ');';
                    break;
                case 'webdriverAnswerOnVisiblePrompt':
                    // TODO
                    break;
                case 'webdriverChooseCancelOnVisibleConfirmation':
                    // TODO
                    break;
                case 'webdriverChooseCancelOnVisiblePrompt':
                    // TODO
                    break;
                case 'webdriverChooseOkOnVisibleConfirmation':
                    // TODO
                    break;
                default:
                    $codeLines[] = '// TODO ' . $command['command'] . ' "' . $command['target'] . '"';
                    break;
            }
        }

        return $codeLines;
    }

    private function calcWaitTime($waitTime)
    {
        return ($waitTime / 1000) <= 1 ? 1 : ($waitTime / 1000);
    }
}
