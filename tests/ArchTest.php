<?php

test('all source classes have a corresponding test file', function () {
    $sourceFiles = glob(__DIR__.'/../src/**/*.php') ?: [];
    $rootFiles = glob(__DIR__.'/../src/*.php') ?: [];
    $sourceFiles = array_merge($rootFiles, $sourceFiles);

    if (empty($sourceFiles)) {
        $this->markTestSkipped('No source classes to check.');

        return;
    }

    foreach ($sourceFiles as $sourceFile) {
        $relativePath = str_replace(realpath(__DIR__.'/../src/').'/', '', realpath($sourceFile));
        $testFile = __DIR__.'/'.str_replace('.php', 'Test.php', $relativePath);

        expect(file_exists($testFile))
            ->toBeTrue("Missing test file for: {$relativePath}");
    }
});
