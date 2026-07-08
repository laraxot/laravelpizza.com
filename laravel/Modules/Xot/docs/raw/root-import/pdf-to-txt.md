https://dev.to/snehalk/how-to-read-content-from-pdf-document-in-laravel-8-4f6d


https://github.com/smalot/pdfparser                  5 days ago
use Smalot\PdfParser\Parser;      



$pdfParser = new Parser();
$pdf = $pdfParser->parseFile($file->path());
$content = $pdf->getText();

https://www.pdfparser.org/
https://www.pdfparser.org/demo


---------------------------------------------------------------
https://www.phpclasses.org/blog/package/9732/post/1-How-to-Extract-Text-and-Images-from-PDF-File-Using-PHP.html
http://www.phpclasses.org/package/9732-PHP-Extract-text-contents-from-PDF-files.html


https://github.com/christian-vigh-phpclasses/PdfToText     on 31 May 2017


http://www.pdftotext.eu

---------------------------------------------------------------
https://mupdf.com/


---------------------------------------------------------------
https://laravelquestions.com/2021/09/03/read-pdf-with-php-and-pdf2text-or-pdf-to-text-spatie/
PDF2Text


---------------------------------------------------------------
https://github.com/jrmuizel/pdf-extract  on 26 Oct 2021

https://github.com/elacin/PDFExtract/
https://github.com/euske/pdfminer
https://github.com/CrossRef/pdfextract

---------------------------------------------------------------

https://github.com/pdfminer/pdfminer.six


---------------------------------------------------------------
https://github.com/cpierce/pdf2text

---------------------------------------------------------------
https://github.com/KaniyamFoundation/Pdf2Text
---------------------------------------------------------------
https://github.com/jalan/pdftotext
---------------------------------------------------------------
https://github.com/shahrukhx01/multilingual-pdf2text
---------------------------------------------------------------

https://github.com/BinarySwami-10/PDF2Text


---------------------------------------------------------------

https://github.com/fabriziomiano/pdf2txt-azure-ocr

---------------------------------------------------------------

https://stackoverflow.com/questions/34447245/using-tesseractocr-in-laravel

https://github.com/thiagoalessio/tesseract-ocr-for-php               !!!!!!!!!!!

$tesseract = new TesseractOCR(asset('images/myimage.jpg'));
$tesseract->setTempDir('/var/www/tesseract/public/images');
echo $tesseract->recognize();


---------------------------------------------------------------
https://aws.amazon.com/fr/rekognition/    !!!!!!!!!!!!!!!!!!!!

---------------------------------------------------------------
https://bestofphp.com/repo/alimranahmed-LaraOCR-php-image-processing
https://github.com/alimranahmed/LaraOCR


---------------------------------------------------------------
https://hergen.nl/processing-identity-documents-in-laravel          !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
---------------------------------------------------------------

https://github.com/spatie/pdf-to-text
https://www.xpdfreader.com/download.html



---------------------------------------------------------------
https://www.thetechplatform.com/post/how-to-easily-extract-any-text-from-a-pdf-in-laravel

---------------------------------------------------------------


---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
