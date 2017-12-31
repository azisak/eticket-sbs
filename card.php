<?php

    // setup the autoload function
    require_once('vendor/autoload.php');

    function CreateCard($kode_tiket,$kelompok_ujian,$no_peserta,$ruang_ujian,$asal_sekolah,$nama){
        // Page's variables
        $height = 7;
        $width = 39;
        $mockup_path = 'res/mock_sbs.png';


        $pdf = new FPDF('P','mm','A5');
        $pdf -> AddPage();
        $pdf -> Image($mockup_path,0,0,148);
    
        $pdf -> SetFillColor(255,255,255);
        /* The content */
        $pdf->SetY(58);
        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'KODE TIKET',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Cell($width,$height,$kode_tiket,0,1);
        
        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'KELOMPOK UJIAN',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Cell($width,$height,$kelompok_ujian,0,1);

        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'NOMOR PESERTA',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Cell($width,$height,$no_peserta,0,1);

        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'RUANG UJIAN',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Cell($width,$height,$ruang_ujian,0,1);

        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'ASAL SEKOLAH',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Cell($width,$height,$asal_sekolah,0,1);

        $pdf -> SetFont('Courier','B',12);
        $pdf->Cell($width,$height,'NAMA PESERTA',0,0,'L');
        $pdf -> SetFont('Courier','',12);
        $pdf->Multicell(95,$height,$nama,0,1);

        $pdf->Output();       
    }

    function ReadAndPrintCard() {
        /* Database vars */
        $host = 'localhost';
        $dbname = 'SBS';
        $dbuser = 'root';
        $dbpass = '';

        /* Card vars */
        $kode_tiket = $_POST['kode_tiket'];
        $kelompok_ujian = '';
        $no_peserta = '';
        $ruang_ujian = '';
        $asal_sekolah = '';
        $nama = '';
        

        /* Connect database & get data */
        try {
            $db = new PDO('mysql:host='.$host.';dbname='.$dbname,$dbuser,$dbpass);

            $getDataPeserta = $db->prepare("SELECT * FROM data_peserta WHERE kode_tiket = :kode_tiket");

            $getDataPeserta -> execute([
                'kode_tiket' => $kode_tiket
            ]);

            if ($getDataPeserta -> rowCount()) {
                $results = $getDataPeserta -> fetchAll();
                // Assign the pdf's vars
                foreach($results as $res) {
                    $kode_tiket = $res['kode_tiket'];
                    $nama = $res['nama'];
                    $no_peserta = $res['no_peserta'];
                    $asal_sekolah = $res['asal_sekolah'];
                    $ruang_ujian = $res['ruang_ujian'];
                    $kelompok_ujian = $res['kelompok_ujian'];
                    break;
                }
            } else { // Data tidak ditemukan
                die("Maaf data tidak ditemukan. Hubungi panitia !");
            }
            // Closing
            $db = null;
            $getDataPeserta = null;

        } catch(PDOException $e) {

            echo $e -> getMessage();
            die();
        }
        // Write PDF
        CreateCard($kode_tiket,$kelompok_ujian,$no_peserta,$ruang_ujian,$asal_sekolah,$nama);
    }



    /* VARIABLES */
    $redirect_address = "index.php";

    
    /* MAIN */
    if (isset($_POST['kode_tiket'])) {
        ReadAndPrintCard();
    } 
    else {
        header("Location: ".$redirect_address);
    }
    
?>