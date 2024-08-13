<?php

namespace App\Constants;

class PreviewFileTypes {
    const NotAFile = -1;
    const Unsupported = 0;
    const Word = 1;
    const PowerPoint = 2;
    const Video = 3;
    const PDF = 4;
    const Image = 5;

    public static function getFileType($extension) {
        switch (strtolower($extension)) {
            case 'doc':
            case 'docx':
                return self::Word;
            case 'ppt':
            case 'pptx':
                return self::PowerPoint;
            case 'mp4':
                return self::Video;
            case 'pdf':
                return self::PDF;
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'bmp':
            case 'svg':
                return self::Image;
            case null:
            case '':
                return self::NotAFile;
            default:
                return self::Unsupported;
        }
    }
}