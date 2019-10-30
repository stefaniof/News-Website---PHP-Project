<?php

//include connection file 
include_once("includes/dbcon.php");
include_once("libs/fpdf.php");

session_start();
// db variables

    if ($_SESSION['logged_in'] != 1)
    {
        $_SESSION['message'] = "<div class='info-alert'>You must log in before viewing this page!</div>";
        header("location: error.php");    
    }
    else
    {
        $email = $mysqli->escape_string($_SESSION['email']);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $active = $user['active'];
		$user_type = $user['user_type'];
		
    }
	
	if ($user_type != 'admin')
	{
		$_SESSION['message'] = "<div class='info-alert'>You must have admin privilleges before viewing this page!</div>";
        header("location: error.php");
	}	
	
	
	
	
	
	
$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );
$reportName = "Website Report";
$reportNameYPos = 200;
$logoFile = "images/logo.png";
$logoXPos = 50;
$logoYPos = 108;
$logoWidth = 80;






// some functions
class PDF_functions extends FPDF
{
    function Logo($x1, $y1, $x2, $y2, $width=1, $nb=15)
    {
        $this->SetLineWidth($width);
        $longueur=abs($x1-$x2);
        $hauteur=abs($y1-$y2);
        if($longueur>$hauteur) {
            $Pointilles=($longueur/$nb)/2; // length of dashes
        }
        else {
            $Pointilles=($hauteur/$nb)/2;
        }
        for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$y1,$j+1,$y1); // upper dashes
                    $this->Line($j,$y2,$j+1,$y2); // lower dashes
                }
            }
        }
        for($i=$y1;$i<=$y2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($y2-1)) {
                    $this->Line($x1,$j,$x1,$j+1); // left dashes
                    $this->Line($x2,$j,$x2,$j+1); // right dashes
                }
            }
        }
    }
	function Footer()
    {
		if($this->PageNo()!=1)
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$pgnumber = $this->PageNo()-1;
			$this->Cell(0,10,'Page '.$pgnumber,0,0,'C');
		}
    }
	function Header()
    {
        
        if($this->PageNo()!=1)
		{
			$this->SetY(5);
			$this->SetFont('Arial','I',10);
			$this->Cell( 0, 15, 'TechEditorial | Website report', 0, 0, 'C' );
			$this->Ln( 15 );
		}
    }	
}








/**
  Create the title page
**/

$pdf = new PDF_functions( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();
$pdf->SetDrawColor(255, 117, 77);
$pdf->Logo(40,30,165,60);
$pdf->SetFont('Arial','B',30);
$pdf->SetXY(40,30);
$pdf->Cell(125,30,'TechEditorial',0,0,'C');

// Logo
$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );

// Report Name
$pdf->SetFont( 'Arial', 'B', 24 );
$pdf->Ln( $reportNameYPos );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );


/**
  Create the rest of the report
**/

$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'Arial', '', 17 );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
$pdf->Ln( 16 );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 16 );
$pdf->Write( 6, "Here are your top 7 most viewed posts:" );
$pdf->Ln( 16 );

$result=$mysqli->query("SELECT postviews.post_id as postid, postviews.views as views, posts.author_id, posts.title as title, posts.image as image, posts.description as description, posts.time as time, users.first_name as fname, 	users.last_name as lname
																						FROM postviews
																						INNER JOIN posts ON postviews.post_id = posts.post_id
																						INNER JOIN users ON posts.author_id = users.user_id
																						ORDER BY views DESC LIMIT 7") or die($mysqli->error());


																						
$width_cell=array(70,40,40,40);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);																						
$pdf->SetFont('Arial','',12);
 // Background color of header 
$fill=true; // to give alternate background fill color to rows 
/// each record is one row  ///
$y=56;
while ($row = $result->fetch_assoc()) {
$pdf->Image( $row['image'], 6, $y, 35, 21 );
$pdf->Cell(35);
$pdf->SetFont('Arial','',13);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(0,5,$row['title'],0,1,'L',false);
$pdf->Cell(35);
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255, 117, 77);
$pdf->Cell(0,5,'ID:'.$row['postid'].' | Views: '.$row['views'].' | Posted on '.date('jS M Y H:i:s', strtotime($row['time'])).' by '.$row['fname'].' '.$row['lname'],0,1,'R',true);
$pdf->Cell(35);
$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(0,5,$row['description'].'[...]',0,1,'L',false);
$y+=31;
$pdf->Ln( 10 );
$fill = !$fill; // to give alternate background fill  color to rows
}



	



$pdf->AddPage();

$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 16 );
$pdf->Write( 6, "List of all posts, sorted by number of views:" );
$pdf->Ln( 16 );


$width_cell=array(40,70,40,40);
$pdf->SetFont('Arial','B',16);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(255, 117, 77); // Background color of header 
// Header starts /// 
$pdf->Cell($width_cell[0],10,'POST ID',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],10,'AUTHOR',1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],10,'VIEWS',1,0,'C',true); // Third header column 
$pdf->Cell($width_cell[3],10,'COMMENTS',1,1,'C',true); // Fourth header column

//// header ends ///////

$pdf->SetFont('Arial','',14);
$pdf->SetFillColor(235,236,236); // Background color of header 
$fill=false; // to give alternate background fill color to rows 

//sql query to display top posts sorted by views
$result=$mysqli->query("SELECT COUNT(comments.com_id) AS comnr, postviews.post_id, posts.post_id as postid, postviews.views as views, posts.author_id, posts.title as title, posts.description as description, users.first_name as fname, 	users.last_name as lname
							FROM postviews
							RIGHT JOIN posts ON postviews.post_id = posts.post_id
							JOIN users ON posts.author_id = users.user_id
							LEFT JOIN comments ON posts.post_id = comments.post_id
							GROUP BY postid
							ORDER BY views DESC") or die($mysqli->error());

/// each record is one row  ///
while ($row = $result->fetch_assoc()) {
$pdf->Cell($width_cell[0],10,$row['postid'],1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,$row['fname'].' '.$row['lname'],1,0,'C',$fill);
$pdf->Cell($width_cell[2],10,$row['views'],1,0,'C',$fill);
$pdf->Cell($width_cell[3],10,$row['comnr'],1,1,'C',$fill);
$fill = !$fill; // to give alternate background fill  color to rows
}

$pdf->Ln( 16 );

$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 16 );
$pdf->Write( 6, "List of all users, sorted by number of comments:" );
$pdf->Ln( 16 );


$width_cell=array(70,40,40,40);
$pdf->SetFont('Arial','B',16);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(255, 117, 77); // Background color of header 
// Header starts /// 
$pdf->Cell($width_cell[0],10,'USER',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],10,'RANK',1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],10,'COMMENTS',1,0,'C',true); // Third header column 
$pdf->Cell($width_cell[3],10,'POSTS',1,1,'C',true); // Fourth header column

//// header ends ///////

$pdf->SetFont('Arial','',14);
$pdf->SetFillColor(235,236,236); // Background color of header 
$fill=false; // to give alternate background fill color to rows 

//sql query to display top posts sorted by views
$result=$mysqli->query("SELECT fname, lname, rank, IFNULL(comnr, "."0".") as comments, IFNULL(postsnr, "."0".") as posts
						FROM
						(SELECT users.user_id as userid, users.first_name as fname, users.last_name as lname, users.user_type as rank FROM users) as t1  
						LEFT JOIN (SELECT comments.com_authorid AS comauth, COUNT(comments.com_id) AS comnr FROM comments GROUP BY comments.com_authorid) as t2 ON userid = comauth
						LEFT JOIN (SELECT posts.author_id AS postauth, COUNT(posts.post_id) AS postsnr FROM posts GROUP BY posts.author_id) as t3  ON comauth = postauth ORDER BY comments DESC") or die($mysqli->error());

/// each record is one row  ///
while ($row = $result->fetch_assoc()) {
$pdf->Cell($width_cell[0],10,$row['fname'].' '.$row['lname'],1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,$row['rank'],1,0,'C',$fill);
$pdf->Cell($width_cell[2],10,$row['comments'],1,0,'C',$fill);
$pdf->Cell($width_cell[3],10,$row['posts'],1,1,'C',$fill);
$fill = !$fill; // to give alternate background fill  color to rows
}











$pdf->Output( "report.pdf", "I" );

?>