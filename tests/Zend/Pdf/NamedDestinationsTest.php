<?php
/**
 * @package    Zend_Pdf
 * @subpackage UnitTests
 */


/** Zend_Pdf */
require_once 'Zend/Pdf.php';


/** PHPUnit Test Case */
require_once 'PHPUnit/Framework/TestCase.php';


/**
 * @package    Zend_Pdf
 * @subpackage UnitTests
 */
class Zend_Pdf_NamedDestinationsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        date_default_timezone_set('GMT');
    }

	public function testProcessing()
    {
        $pdf = new Zend_Pdf();
        $page1 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $page2 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $page3 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); // not actually included into pages array

        $pdf->pages[] = $page1;
        $pdf->pages[] = $page2;


        $this->assertTrue(count($pdf->getNamedActions()) == 0);
        $this->assertTrue(count($pdf->getNamedDestinations()) == 0);

        require_once 'Zend/Pdf/Destination/Fit.php';
        $destination1 = Zend_Pdf_Destination_Fit::create($page1);
        $destination2 = Zend_Pdf_Destination_Fit::create($page2);
        $action1 = Zend_Pdf_Action_GoTo::create($destination1);

        $pdf->setNamedAction('GoToPage1', $action1);
        $this->assertTrue($pdf->getNamedAction('GoToPage1') === $action1);
        $this->assertTrue($pdf->getNamedAction('GoToPage9') === null);

        $pdf->setNamedDestination('Page2', $destination2);
        $this->assertTrue($pdf->getNamedDestination('Page2') === $destination2);
        $this->assertTrue($pdf->getNamedDestination('Page9') === null);

        $pdf->setNamedDestination('Page1',   $destination1);
        $pdf->setNamedDestination('Page1_1', Zend_Pdf_Destination_Fit::create(1));
        $pdf->setNamedDestination('Page9_1', Zend_Pdf_Destination_Fit::create(9)); // will be egnored

        $action3 = Zend_Pdf_Action_GoTo::create(Zend_Pdf_Destination_Fit::create($page3));
        $pdf->setNamedAction('GoToPage3', $action3);

        $this->assertTrue(strpos($pdf->render(), '[(GoToPage1) <</Type /Action /S /GoTo /D [3 0 R /Fit ] >> (Page1) [3 0 R /Fit ] (Page1_1) [1 /Fit ] (Page2) [4 0 R /Fit ] ]') !== false);
    }
}
