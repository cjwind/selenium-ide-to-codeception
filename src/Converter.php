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
                    case 'click':
                        $codeLines[] = '$I->click("' . $command['target'] . '");';
                        break;
                    default:
                        $codeLines[] = '// TODO ' . $command['command'] . ' ' . $command['target'];
                        break;
                }
            }
        }
        return $codeLines;
    }

    private function outputPhpStartTag()
    {
        echo "<?php\n";
    }

    private function outputCode($codeLines)
    {
        echo implode("\n", $codeLines);
        echo "\n";
    }
}

