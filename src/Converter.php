<?php
class Converter
{
    public function convertSeleniumProject($filename)
    {
        $projectContent = json_decode(file_get_contents($filename), true);

        $this->outputPhpStartTag();

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

        echo implode("\n", $outputs);
        echo "\n";
    }

    private function outputPhpStartTag()
    {
        echo "<?php\n";
    }
}

