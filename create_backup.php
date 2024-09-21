<?php

function create_website_backup() {
    $backup_filename = 'website_backup_' . date('Y-m-d_H-i-s') . '.zip';
    $zip = new ZipArchive();
    
    if ($zip->open($backup_filename, ZipArchive::CREATE) !== TRUE) {
        return false;
    }
    
    $rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }
    
    $db_backup_file = 'database_backup.sql';
    $command = "PGPASSWORD='your_password' pg_dump -h bdd -U your_username your_database_name > $db_backup_file";
    exec($command);
    $zip->addFile($db_backup_file, 'database_backup.sql');
    
    $zip->close();
    unlink($db_backup_file); 
    
    return $backup_filename;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $backup_file = create_website_backup();
    if ($backup_file) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($backup_file).'"');
        header('Content-Length: ' . filesize($backup_file));
        readfile($backup_file);
        unlink($backup_file);
        exit;
    } else {
        echo "Failed to create backup.";
    }
}
?>