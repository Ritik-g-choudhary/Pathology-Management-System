<?php
// Replace with your actual database connection information
include 'config.php';

// Replace with your patient_id
if (isset($_REQUEST['id'])) {
    $patient_id = $_REQUEST['id'];
}

// Create a PDF document using TCPDF
require_once('TCPDF-main/tcpdf.php'); 
require_once('vendor/autoload.php'); // Adjust the path to the autoload file

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

$renderer = new Png();
$renderer->setHeight(200); // Set the QR code image height
$renderer->setWidth(200);  // Set the QR code image width

$writer = new Writer($renderer);
$qrCode = $writer->writeString('https://example.com');

class PDF extends TCPDF {
    // Page header
    public function Header() {
        // Suppress header line
    }
}

$pdf = new PDF();


// Create a new PDF document with custom page width

$pdf->AddPage();
$pdf->Ln(30);

$sql = "SELECT *
        FROM patient_data
        INNER JOIN test_data
        ON patient_data.patient_id = test_data.patient_id
        WHERE patient_data.patient_id = '$patient_id'
    ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 

// Patient Information
$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Name', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(110, 6, ': '. $row['full_name'], 0, 0, 'L');
$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Reg No:', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(20, 6, ': '. $row['patient_id'], 0, 1, 'L');

$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Age & Sex', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(110, 6,  ': '. $row['gender'], 0, 0, 'L');
$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Reg. Date', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(20, 6, ': '. $row['test_date'], 0, 1, 'L');

$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Referred By', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(110, 6,  ': '. $row['primary_care_physician'], 0, 0, 'L');
$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Collected on', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(20, 6,  ': '. $row['test_date'], 0, 1, 'L');

$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Client', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(110, 6, ': Apex Pathology Center', 0, 0, 'L');
$pdf->SetFont('times', '',10);
$pdf->Cell(20, 6, 'Reported on', 0, 0, 'L');
$pdf->SetFont('times', 'B',10);
$pdf->Cell(20, 6, ': '. $row['test_date'], 0, 1, 'L');
}else {
    // Handle the case where no data is found
    $pdf->SetFont('times', '', 10);
    $pdf->Cell(0, 6, 'No records found', 0, 1, 'L');
}


$pdf->SetFont('dejavusans', '', 3);
$pdf->Ln(5);

$heading = 'COMPLETE BLOOD COUNT';

// Set the font and size for the heading
$pdf->SetFont('dejavusans', 'B', 16);

// Set the text color
$pdf->SetTextColor(0, 0, 0); // Black color

// Create a cell to display the heading with a background color
$pdf->SetFillColor(204, 204, 204); // Gray background color
$pdf->Cell(0, 10, $heading, 0, 1, 'C', true);

// Reset the font and color for the rest of the content
$pdf->SetFont('dejavusans', '', 9);
$pdf->SetTextColor(0, 0, 0); // Black color
$pdf->SetFont('dejavusans', '', 9);


$pdf->Ln(5);
$pdf->SetFillColor(204, 204, 204);

$html = '<table  style="width:100%; padding: 5px;">';
$html .= '<tr>';
$html .= '<th style="padding: 5px;">Test Type</th>';
$html .= '<th style="padding: 5px;">Result</th>';
$html .= '<th style="padding: 5px;">Test Date</th>';
$html .= '<th style="padding: 5px;">Unit</th>';
$html .= '<th style="padding: 5px;">Reference</th>';
$html .= '</tr>';

// SQL query to fetch data
$sql = "SELECT td.test_type, td.result, td.test_date, td.unit, td.reference
        FROM test_data td
        WHERE td.patient_id = '$patient_id'
        ORDER BY td.test_date";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr style="margin:10px;">';
        $html .= '<td>' . $row['test_type'] . '</td>';
        $html .= '<td>' . $row['result'] . '</td>';
        $html .= '<td>' . $row['unit'] . '</td>';
        $html .= '<td>' . $row['reference'] . '</td>';
         $html .= '<td>' . $row['test_date'] . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="5">No records found</td>';
    $html .= '</tr>';
}

$html .= '</table>
<div style="text-align:center;"><p>**End of Report**</p></div>
';

$pdf->writeHTML($html);
$x = 10; // X-coordinate
$y = 230; // Y-coordinate
$width = 30; // Width
$height = 30; // Height

// Embed the QR code image
$pdf->Image('@' . $qrCode, $x, $y, $width, $height);
// Close the database connection
$conn->close();

// Output the PDF
$pdf->Output('pathology_report.pdf', 'I');
?>
