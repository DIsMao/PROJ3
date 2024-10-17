<?php

namespace Adamcode\EventHandlers;

use PhpOffice\PhpWord\IOFactory;
use Shuchkin\SimpleXLSX;

class SearchContent
{
    public static function OnSearchGetFileContent($absolute_path)
    {
        $locale = 'ru_RU.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);
        $ext = pathinfo($absolute_path, PATHINFO_EXTENSION);
        $allowedtypes = ["doc", "docx", "xls", "xlsx", "pdf"];
        $filePathEscape = escapeshellarg($absolute_path);
        $catDocPath = '/usr/bin/catdoc'; // полный путь к catdoc
        $xls2csvPath = '/usr/bin/xls2csv'; // полный путь к xls2csv
        $pdftotextPath = '/usr/bin/pdftotext'; // полный путь к pdftotext
        $content = "";

        if (file_exists($absolute_path) && is_file($absolute_path) && in_array($ext, $allowedtypes))
        {
            if ($ext == "doc")
            {
                $content = shell_exec(escapeshellcmd($catDocPath . ' ' . $filePathEscape));

            }
            if ($ext == "docx")
            {

                $objReader = IOFactory::createReader('Word2007');
                $phpWord = $objReader->load($absolute_path);

                $body = '';
                $sections = $phpWord->getSections();




                foreach ($sections as $s) {
                    $els = $s->getElements();
                    foreach($els as $celem) {
                        if(get_class($celem) === 'PhpOffice\PhpWord\Element\Text') {
                            $body .= $celem->getText();
                        }

                        else if(get_class($celem) === 'PhpOffice\PhpWord\Element\TextRun') {
                            foreach($celem->getElements() as $text) {

                                if(get_class($text) === 'PhpOffice\PhpWord\Element\Text') {
                                    $body .= $text->getText();
                                }
                            }
                        }
                    }
                }
                $content = $body;


            }

            if ($ext == "xls")
            {

                $content = shell_exec(escapeshellcmd($xls2csvPath . ' ' . $filePathEscape));

            }
            if ($ext == "xlsx")
            {

                if ( $xlsx = SimpleXLSX::parse($absolute_path) ) {

                    foreach ($xlsx->rows() as $item){
                        foreach ($item as $text){
                            $content = $content . " " . $text;
                        }
                    }
                } else {
                    echo SimpleXLSX::parseError();
                }

            }

            if ($ext == "pdf")
            {

                shell_exec(escapeshellcmd($pdftotextPath . ' ' . $filePathEscape . ' ' . "/home/bitrix/www/search/PDF.txt") );
                $content = file_get_contents("/home/bitrix/www/search/PDF.txt");
            }
            return array(
                "TITLE" => basename($absolute_path),
                "CONTENT" => $content,
                "PROPERTIES" => array(),
            );
        } else
            return false;
    }
}