<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomiary</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        img{
            border: 1px solid black;
            padding:0;
            margin:10px;
        }
        #conteiner{
            margin: 10px;
        }
        form input{
            padding: 10px;
            margin: 10px;
        }
        #editComponent{
            position: absolute;
            top: 20%;
            left: 50%;
            margin-left: -100px;
            width: 200px;
            background-color: #93d9a6;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 3;
            display: none;
        }
        #editComponent input, #editComponent button{
            padding: 0.2vw;
        }
        #overlay{
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 2;
            display: none;
        }
        input[type="submit"], a {
            padding: 5px;
            border: 1px solid black;
            margin: 10px;
            text-decoration: none;
            color: black;
            background-color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover, a:hover{
            background-color: lightgray;
        }
        p{
            margin-top: 50px;
        }
    </style>    
</head>

<body>
    <map name="pomiary" id="map">
    </map>
    <?php 
        echo "<img id='mainImg' usemap='#pomiary' src='wykres.php?height=", isset($_GET["height"])?$_GET["height"]:"250", "&width=", isset($_GET["width"])?$_GET["width"]:"820","' >"; 
    ?>

    <br>

    <div id="conteiner">
        <form method="post">
            <input type="submit" name="pdfDownload" class="button" value="Create a PDF file" />
        </form>
        <a href="Kurowska_Marta.zip" download>Download a ZIP folder</a>
        <p>Wykonane punkty: IA, IB, II, III, IV, V</p>

        <video width="320" height="240" controls muted>
            <source src="other_data/video.mp4" type="video/mp4">
        </video>
    </div>

    <div id="editComponent">
        <input onkeydown="validateInput(event)" type="text" placeholder="Wprowadź temperaturę" id="tempInput"/>
        <button onclick="saveTemp()">Zapisz temperaturę</button>
        <button onclick="illness()">Choroba</button>
        <button onclick="nodata()">Brak pomiaru</button>
        <button onclick="cancelEdit()">Anuluj</button>
    </div>
    <div id="overlay"></div>

    <!-- creating pdf method -->
    <?php
        date_default_timezone_set('Europe/Warsaw');

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

            ob_start();
            require('pdfContent.php');
            imagepng(createImg());
            $myImg = ob_get_contents();
            ob_end_clean();

            $pdf->Image('@'.$myImg, 10,10, 200, 70, 'PNG', 'wykres.php?width=820&height=250', '', '', true, 300, '', false, false, 0, false, false, false);

            $pdf->MultiCell(0, 0, "Legenda:", 0, '', 0, 1, 18, 72);
            $circ_style = array('width' => 0, 'dash' => 0, 'color' => array(255, 0, 0));
            $pdf->Circle(20,80,1,0,360, 'DF', $circ_style, array(255, 0, 0));
            $pdf->MultiCell(0, 0, "choroba", 0, '', 0, 1, 22, 77);
            $circ_style = array('width' => 0, 'dash' => 0, 'color' => array(69, 69, 69));
            $pdf->Circle(20,85,1,0,360, 'DF', $circ_style, array(69, 69, 69));
            $pdf->MultiCell(0, 0, "brak pomiaru", 0, '', 0, 1, 22, 82);

            $pdf->MultiCell(0, 0, "Pomiary:", 0, '', 0, 1, 160, 72);
            
            $x_start = 160;
            $y_start = 80;
        
            $pdf->SetXY($x_start, $y_start);
            $pdf->Cell(20, 0, 'dzien', 1, 1, 'C', 0, '', 0);
            $pdf->SetXY($x_start+20, $y_start);
            $pdf->Cell(20, 0, 'pomiar', 1, 1, 'C', 0, '', 0);

            require('getData.php');

            $p_arr = getPomiars();

            foreach ($p_arr as $key => $value){
                $y_start += 5.2;
                $pdf->SetXY($x_start, $y_start);
                $pdf->Cell(20, 0, $key, 1, 1, 'C', 0, '', 0);
                $pdf->SetXY($x_start+20, $y_start);
                $pdf->Cell(20, 0, $value, 1, 1, 'C', 0, '', 0);
            }


            ob_end_clean();
            $pdf->Output('pomiary.pdf', 'I');

        }
    ?>

    <script>

        let daySelected = -1;

        function validateInput(event) {
            const allowedKeys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.', 'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'];
            if (event.key === '.' && event.target.value.includes('.')) {
                event.preventDefault();
            } else if (!allowedKeys.includes(event.key)) {
                event.preventDefault();
            }
        }

        function clickEdit(e){
            lastAreaClicked = e;
            document.getElementById("overlay").style.display = "block";
            document.getElementById("editComponent").style.display = "flex";
        }

        function cancelEdit(){
            document.getElementById("overlay").style.display = "none";
            document.getElementById("editComponent").style.display = "none";
        }

        function saveTemp(){
            let newVal = document.getElementById("tempInput").value;
            if(parseFloat(newVal) >= 36.2 && parseFloat(newVal) <= 37.2){
                saveEditing(newVal);
                cancelEdit();
            }
            else{
                alert("Temperatura powinna mieścić się w zakresie widocznym na wykresie.");
            }
            
        }

        function illness(){
            let newVal = "choroba";
            saveEditing(newVal);
            cancelEdit();
        }

        function nodata(){
            let newVal = "brak";
            saveEditing(newVal);
            cancelEdit();
        }

        function saveEditing(newVal){            
            let params = `new=${newVal}&day=${daySelected}`;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', `editData.php?${params}`, true);
            xhr.onload = function() {

                if (xhr.status === 200) {
                    let fSrc = document.getElementById("mainImg").src
                    if(fSrc.indexOf("&t=") >= 0)
                    {
                        document.getElementById("mainImg").src = fSrc.substring(0,fSrc.indexOf('&t=')) + `&t=${Date.now()}`
                    }
                    else
                    {
                        document.getElementById("mainImg").src = fSrc    + `&t=${Date.now()}`
                    }

                } else {
                    console.error('Failed to fetch data');
                }
            };

            xhr.send();
            
        }
        
        function onLoad() {
            var url = new URL(window.location.href);
            var searchParams = url.searchParams;
            var map = document.getElementById("map");

            var w = searchParams.get('width');
            var h = searchParams.get('height');

            if (w == null) {
                w = 820;
            } else {
                w = parseInt(w);
            }
            if (h == null) {
                h = 250;
            } else {
                h = parseInt(h);
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'getData.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    for (const [key, value] of Object.entries(data)) {
                        let btn = document.createElement('area');
                        btn.setAttribute('shape', 'circle');
                        btn.style.cursor = "pointer";
                        btn.onclick = function() { 
                            clickEdit(this) 
                            daySelected = key;
                        }; 
                        let temp_h = h - 50;
                        if (value != "brak" && value != "choroba") {
                            temp_h = h - 50 - ((h-100)/6*(parseFloat(value) - 36)*5);
                        }
                        let temp_w = 75 + (parseInt(key)-1)*((w-100)/28);
                        btn.setAttribute('coords', `${temp_w},${temp_h},10`);
                        map.appendChild(btn);
                    }

                } else {
                    console.error('Failed to fetch data');
                }
            };

            xhr.send();
        }

        document.querySelector("img").addEventListener("load", function(){
            onLoad();
            console.log("loaded");
        });
    </script>

</body>

</html>