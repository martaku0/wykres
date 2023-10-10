<!DOCTYPE html>
<html lang="pl">

<!-- TODO
EDYCJA
HOSTING video
PDF
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomiary</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>
    <map name="pomiary">
    
    </map>
    <?php 
        echo "<img usemap='#pomiary' src='wykres.php?height=", isset($_GET["height"])?$_GET["height"]:"250", "&width=", isset($_GET["width"])?$_GET["width"]:"820","' >"; 
    ?>
    <form method="post">
        <input type="submit" name="pdfDownload" class="button" value="Create a PDF file" />
    </form>

    <!-- creating pdf method -->
    <?php
        date_default_timezone_set('Europe/Warsaw    ');

        if(array_key_exists('pdfDownload', $_POST)) {
            require('tcpdf/tcpdf.php');

            class MYPDF extends TCPDF {
                public function Header() {
                    $content = "POMIARY: " . date('d-m-Y H:i:s');
                    $this->Cell(0, 15, $content, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                }
            }

            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetTitle('Pomiary');
            $pdf->AddPage('P',"A4");

            $html = '<img src="wykres.php?height=250&width=820" />';
            $pdf->WriteHTML($html, true, false, true, false, '');

            ob_end_clean();
            $pdf->Output('pomiary.pdf', 'I');

        }
    ?>
</body>

</html>