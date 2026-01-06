<?php



declare(strict_types=1);

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    fwrite(STDERR, "Unable to resolve project root.\n");
    exit(1);
}

$skipDirs = [
    $root . '/vendor',
    $root . '/node_modules',
    $root . '/public/build',
    $root . '/storage',
    $root . '/bootstrap/cache',
];

$allowedExts = [
    'php' => 'php',
    'js' => 'text',
    'ts' => 'text',
    'jsx' => 'text',
    'tsx' => 'text',
    'css' => 'text',
    'scss' => 'text',
    'vue' => 'text',
];

$rii = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        function (SplFileInfo $current, $key, $iterator) use ($skipDirs) {
            $path = $current->getPathname();
            foreach ($skipDirs as $skip) {
                if (strpos($path, $skip) === 0) {
                    return false; 
                }
            }
            return true;
        }
    ),
    RecursiveIteratorIterator::SELF_FIRST
);

$changed = [];
foreach ($rii as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $ext = strtolower($file->getExtension());
    if (!isset($allowedExts[$ext])) {
        continue;
    }

    $path = $file->getPathname();
    $original = file_get_contents($path);
    if ($original === false) {
        fwrite(STDERR, "Failed reading {$path}\n");
        continue;
    }

    $stripped = $ext === 'php'
        ? stripPhpComments($original)
        : stripJsCssLikeComments($original);

    if ($stripped !== $original) {
        file_put_contents($path, $stripped);
        $changed[] = $path;
    }
}

echo "Updated " . count($changed) . " files." . PHP_EOL;


function stripPhpComments(string $code): string
{
    $tokens = token_get_all($code);
    $out = '';
    foreach ($tokens as $token) {
        if (is_array($token)) {
            [$id, $text] = $token;
            if ($id === T_COMMENT || $id === T_DOC_COMMENT) {
                
                continue;
            }
            $out .= $text;
        } else {
            $out .= $token;
        }
    }
    return $out;
}

function stripJsCssLikeComments(string $code): string
{
    $out = '';
    $len = strlen($code);
    $i = 0;
    $state = 'normal';
    $quote = '';

    while ($i < $len) {
        $ch = $code[$i];
        $next = $i + 1 < $len ? $code[$i + 1] : '';

        if ($state === 'normal') {
            if ($ch === '\\' && $next !== '') { 
                $out .= $ch . $next;
                $i += 2;
                continue;
            }
            if (($ch === '"' || $ch === "'")) {
                $state = 'string';
                $quote = $ch;
                $out .= $ch;
                $i++;
                continue;
            }
            if ($ch === '`') {
                $state = 'template';
                $out .= $ch;
                $i++;
                continue;
            }
            if ($ch === '/' && $next === '/') {
                
                while ($i < $len && $code[$i] !== "\n") {
                    $i++;
                }
                continue;
            }
            if ($ch === '/' && $next === '*') {
                
                $i += 2;
                while ($i < $len - 1 && !($code[$i] === '*' && $code[$i + 1] === '/')) {
                    $i++;
                }
                $i += 2; 
                continue;
            }
            $out .= $ch;
            $i++;
            continue;
        }

        if ($state === 'string') {
            $out .= $ch;
            if ($ch === '\\' && $next !== '') {
                $out .= $next;
                $i += 2;
                continue;
            }
            if ($ch === $quote) {
                $state = 'normal';
            }
            $i++;
            continue;
        }

        if ($state === 'template') {
            $out .= $ch;
            if ($ch === '\\' && $next !== '') {
                $out .= $next;
                $i += 2;
                continue;
            }
            if ($ch === '`') {
                $state = 'normal';
            }
            $i++;
            continue;
        }
    }

    return $out;
}
