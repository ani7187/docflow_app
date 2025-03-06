<?php

if (!function_exists('getFileIcon')) {
    function getFileIcon($extension): string
    {
        switch ($extension) {
            case 'pdf':
                return 'mdi-file-pdf';
            case 'doc':
            case 'docx':
                return 'mdi-file-document';
            case 'xls':
            case 'xlsx':
                return 'mdi-file-excel';
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
                return 'mdi-file-image';
            default:
                return 'mdi-file-outline';
        }
    }
}
