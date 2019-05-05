<?php
class Converter
{
    public function convertSeleniumProject($filename)
    {
        $projectContent = json_decode(file_get_contents($filename), true);
        $outputs = $this->convert($projectContent);

        $this->outputPhpStartTag();
        $this->outputCode($outputs);
    }

    private function convert($projectContent)
    {
        $outputs = [];
        foreach ($projectContent['tests'] as $test) {
            foreach ($test['commands'] as $command) {
                if (!empty($command['target'])) {
                    $command['target'] = str_replace('css=', '', $command['target']);
                    $command['target'] = str_replace('linkText=', '', $command['target']);
                    $command['target'] = str_replace('xpath=', '', $command['target']);
                }

                switch ($command['command']) {
                    case 'click':
                        $outputs[] = '$I->click("' . $command['target'] . '");';
                        break;
                    default:
                        $outputs[] = '// TODO ' . $command['command'] . ' ' . $command['target'];
                        break;
                }
            }
        }
        return $outputs;
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

