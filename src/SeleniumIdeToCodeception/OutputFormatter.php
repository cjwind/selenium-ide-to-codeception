<?php
namespace cjwind\SeleniumIdeToCodeception;

class OutputFormatter
{
    const OUTPUT_TYPE_CEST = 'cest';
    const OUTPUT_TYPE_CEPT = 'cept';

    const PHP_START_TAG = '<?php';

    public function output($testSuites, $outputType, $outputDirectory)
    {
        $this->ensureDiretory($outputDirectory);

        if ($outputType == self::OUTPUT_TYPE_CEST) {
            $this->outputCest($testSuites, $outputDirectory);
        } elseif ($outputType == self::OUTPUT_TYPE_CEPT) {
            $this->outputCept($testSuites, $outputDirectory);
        }
    }

    private function ensureDiretory($directory)
    {
        if (!file_exists($directory)) {
            if (!mkdir($directory)) {
                throw new \Exception('Create dirctory ' . $directory . ' failed');
            }
        } elseif (!is_dir($directory)) {
            throw new \Exception($directory . ' already exists');
        } else {
            if (!is_writable($directory)) {
                throw new \Exception($directory . ' is not writeable');
            }
        }
    }

    private function outputCest($testSuites, $outputDirectory)
    {
        foreach ($testSuites as $testSuite) {
            $content = [];
            $content[] = self::PHP_START_TAG;
            $content = array_merge($content, $this->genCestClassHead($testSuite['name']));

            foreach ($testSuite['tests'] as $test) {
                $content = array_merge($content, $this->genCestTestCase($test));
            }

            $content = array_merge($content, $this->genCestClassEnd());

            $filename = $testSuite['name'] . 'Cest.php';
            file_put_contents($outputDirectory . '/' . $filename, implode("\n", $content));
        }
    }

    private function genCestClassHead($cestName)
    {
        return [
            "class ${cestName}Cest",
            "{",
        ];
    }

    private function genCestTestCase(&$test)
    {
        $content = [
            'public function ' . $test['name'] . '(AcceptanceTester $I)',
            "{",
        ];
        $content = array_merge($content, $test['codeLines']);
        $content[] = '}';

        return $content;
    }

    private function genCestClassEnd()
    {
        return ['}'];
    }

    public function outputCept($testSuites, $outputDirectory)
    {
        foreach ($testSuites as $testSuite) {
            foreach ($testSuite['tests'] as $test) {
                $content = [];
                $content[] = self::PHP_START_TAG;
                $content[] = '$I = new AcceptanceTester($scenario);';
                $content = array_merge($content, $test['codeLines']);

                $filename = $test['name'] . 'Cept.php';
                file_put_contents($outputDirectory . '/' . $filename, implode("\n", $content));
            }
        }
    }
}
