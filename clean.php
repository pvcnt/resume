<?php
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/app/var/cache/'));
foreach ($it as $file) {
  if ($file->isFile()) {
    unlink($file->getPathname());
  }
}