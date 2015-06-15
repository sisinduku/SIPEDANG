<?php
/**
 * Kelas ekstensi FPDF untuk membuat tabel
 * @author FPDF, modified by M Nur Hardyanto
 * 
 */
class PDF_MC_Table extends FPDF {
	var $widths;
	var $aligns;
	private $headerLabels;
	private $repeatHeader;
	private $headerColor;
	
	function __construct() {
		parent::__construct();
		$headerLabels = array();
	}
	function setHeaders($listHeaders, $repeatHeader = true) {
		$this->headerLabels = $listHeaders;
		$this->repeatHeader = $repeatHeader;
		$this->headerColor	= array(224,224,224);
	}
	function setHeaderFill($r, $g, $b) {
		$this->headerColor	= array($r, $g, $b);
	}
	function SetWidths($w) {
		// Set the array of column widths
		$this->widths = $w;
	}
	function SetAligns($a) {
		// Set the array of column alignments
		$this->aligns = $a;
	}
	function headerRow() {
		$originStyle = $this->FontStyle;
		$this->SetFont($this->FontFamily, 'B', $this->FontSizePt);
		$this->Row($this->headerLabels, $this->headerColor);
		$this->SetFont($this->FontFamily, $originStyle, $this->FontSizePt);
	}
	function Row($data, $fillColor = null) {
		// Calculate the height of the row
		$nb = 0;
		for($i = 0; $i < count ( $data ); $i ++)
			$nb = max ( $nb, $this->NbLines ( $this->widths [$i], $data [$i] ) );
		$h = 5 * $nb;
		// Issue a page break first if needed
		$this->CheckPageBreak ( $h+4 );
		// Draw the cells of the row
		for($i = 0; $i < count ( $data ); $i ++) {
			$w = $this->widths [$i];
			$a = isset ( $this->aligns [$i] ) ? $this->aligns [$i] : 'L';
			// Save the current position
			$x = $this->GetX ();
			$y = $this->GetY ();
			// Draw the border
			$paintCell = ($fillColor != null);
			if ($paintCell) {
				$this->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);
			}
			$this->Rect ( $x, $y, $w + 4, $h + 4, ($paintCell?'DF':'') );
			// Print the text
			$this->SetXY ( $x + 2, $y + 2 );
			
			$this->MultiCell ( $w, 5, $data [$i], 0, $a, $paintCell );
			// Put the position to the right of the cell
			$this->SetXY ( $x + $w + 4, $y );
		}
		// Go to the next line
		$this->Ln ( $h+4 );
	}
	function CheckPageBreak($h) {
		// If the height h would cause an overflow, add a new page immediately
		if ($this->GetY () + $h > $this->PageBreakTrigger) {
			$this->AddPage ( $this->CurOrientation );
			if (!empty($this->headerLabels) && $this->repeatHeader) {
				$this->headerRow();
			}
		}
			
	}
	function NbLines($w, $txt) {
		// Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont ['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace ( "\r", '', $txt );
		$nb = strlen ( $s );
		if ($nb > 0 and $s [$nb - 1] == "\n")
			$nb --;
		$sep = - 1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ( $i < $nb ) {
			$c = $s [$i];
			if ($c == "\n") {
				$i ++;
				$sep = - 1;
				$j = $i;
				$l = 0;
				$nl ++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw [$c];
			if ($l > $wmax) {
				if ($sep == - 1) {
					if ($i == $j)
						$i ++;
				} else
					$i = $sep + 1;
				$sep = - 1;
				$j = $i;
				$l = 0;
				$nl ++;
			} else
				$i ++;
		}
		return $nl;
	}
}