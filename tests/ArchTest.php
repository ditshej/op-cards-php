<?php

test('all source classes have a corresponding test file', function () {
    $sourceFiles = glob(__DIR__.'/../src/*.php') ?: [];

    if (empty($sourceFiles)) {
        $this->markTestSkipped('No source classes to check.');

        return;
    }

    foreach ($sourceFiles as $sourceFile) {
        $className = basename($sourceFile, '.php');
        $testFile = __DIR__."/{$className}Test.php";

        expect(file_exists($testFile))
            ->toBeTrue("Missing test file for: {$className}");
    }
});
