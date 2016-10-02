<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 1/10/2016
 * Time: 11:32 PM
 */

  define('FPDF_FONTPATH','FPDF/font/');
  require('../FPDF/fpdf.php');

  class XFPDF extends FPDF
  {
      function FancyTable($header,$data)
      {
          $this->SetFillColor(255,0,0);
          $this->SetTextColor(255,255,255);
          $this->SetDrawColor(128,0,0);
          $this->SetLineWidth(.3);
          $this->SetFont('','B');
          $w=array(25,35,35,55,25);

          for($i=0;$i<sizeof($header);$i++)
          {
              $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
          }
          $this->Ln();
          $this->SetFillColor(224,235,255);
          $this->SetTextColor(0,0,0);
          $this->SetFont('');
          $fill=0;

          foreach($data as $row)
          {
              $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
              $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
              $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
              $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
              $this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
              $this->Ln();
              $fill=!$fill;
          }
          $this->Cell(array_sum($w),0,'','T');
      }
  }

include ("../Config/Connection.php");
  $conn = oci_connect($UName,$Pword,$DB)
  or die("Couldn't logon.");
  $query="SELECT * FROM Client ORDER BY client_id";
  $stmt = oci_parse($conn,$query);
  oci_execute($stmt);

  $nrows = oci_fetch_all($stmt,$results);

  if ($nrows> 0)
  {
      $data = array();
      $header= array();
      while(list($column_name) = each($results))
      {
          $header[]=$column_name;
      }
      for ($i = 0; $i<$nrows; $i++)
      {
          reset($results);
          $j=0;
          while (list(,$column_value) = each($results))
          {
              $data[$i][$j] = $column_value[$i];
              $j++;
          }
      }
  }
  else
  {
      echo "No Records found";
  }
  oci_free_statement($stmt);

  $pdf=new XFPDF();
  $pdf->Open();
  $pdf->SetFont('Arial','',10);
  $pdf->AddPage();
  $pdf->FancyTable($header,$data);
  $pdf->Output("PDFFile2.pdf");
 ?>

<html>
<head><title></title></head>
<body>
<a href="PDFFile2.pdf">Click here to see
    PDF document</a>
</body>
</html>