<?php

namespace App\Utility;
use Cake\View\ViewBuilder;
use Knp\Snappy\Pdf;

class PdfWriter
{
    private $binaryPath;

    public function __construct()
    {
        $this->binaryPath = ROOT . '/vendor/bin/wkhtmltopdf-amd64-osx';;
    }
    public function write($template, $data)
    {
        $snappy = new Pdf($this->binaryPath);

        $html = (new ViewBuilder())->layout('ajax')->build($data)->render($template);

        return $snappy->getOutputFromHtml($html);
    }
}
