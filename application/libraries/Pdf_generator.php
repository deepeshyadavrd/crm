<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Autoload Dompdf classes
require_once APPPATH . 'third_party/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_generator {

    protected $ci;
    protected $dompdf;

    public function __construct() {
        $this->ci =& get_instance();
        $this->dompdf = new Dompdf();

        // Configure Dompdf options (optional, but good for rendering)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Enable loading remote assets (like images from your site)
        $options->set('defaultFont', 'sans-serif'); // Set a default font

        $this->dompdf->setOptions($options);
    }

    /**
     * Generates a PDF from HTML content.
     *
     * @param string $html The HTML content to convert to PDF.
     * @param string $filename The name of the PDF file (e.g., 'invoice.pdf').
     * @param string $paper 'A4', 'Letter', etc.
     * @param string $orientation 'portrait' or 'landscape'.
     * @param bool $stream Whether to stream the PDF directly to the browser (true) or return it as a string (false).
     * @return string|void Returns PDF content as string if $stream is false, otherwise streams to browser.
     */
    public function generate($html, $filename = 'document.pdf', $paper = 'A4', $orientation = 'portrait', $stream = TRUE) {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        if ($stream) {
            $this->dompdf->stream($filename, array("Attachment" => 0)); // 0 = preview in browser, 1 = download
        } else {
            return $this->dompdf->output(); // Returns the PDF as a string
        }
    }
}