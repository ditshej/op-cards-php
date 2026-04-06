<?php

test('all source classes have a corresponding test file', function () {
    $srcDir = realpath(__DIR__.'/../src/');
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($srcDir, FilesystemIterator::SKIP_DOTS),
    );

    $sourceFiles = [];
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $sourceFiles[] = $file->getPathname();
        }
    }

    if (empty($sourceFiles)) {
        test()->skip('No source classes to check.');
    }

    foreach ($sourceFiles as $sourceFile) {
        $relativePath = str_replace($srcDir.'/', '', $sourceFile);
        $testFile = __DIR__.'/'.str_replace('.php', 'Test.php', $relativePath);

        expect(file_exists($testFile))
            ->toBeTrue("Missing test file for: {$relativePath}");
    }
});

test('core src classes do not import Illuminate or any framework', function () {
    $srcDir = realpath(__DIR__.'/../src/');
    $laravelDir = realpath(__DIR__.'/../src/Laravel/');

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($srcDir, FilesystemIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if (! $file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }

        $path = $file->getPathname();

        if (str_starts_with($path, $laravelDir)) {
            continue;
        }

        $contents = file_get_contents($path);
        $relative = str_replace($srcDir.'/', '', $path);

        expect($contents)->not->toContain('Illuminate\\', "Core class {$relative} must not import Illuminate");
    }
});
