<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 19/02/16
 * Time: 10:08
 */

namespace App\Gateways;


use League\Flysystem\Adapter\Ftp;

class RTTrainDataFtpGatewayTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var string
     */
    private $correctFileEnding = "pPortData.log";

    /**
     * @var MockFtpAdapter
     */
    private $mockFtpAdapter;

    /**
     * @var RTTrainDataFtpGateway
     */
    private $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->mockFtpAdapter = new MockFtpAdapter();
        $this->gateway = new RTTrainDataFtpGateway( $this->mockFtpAdapter );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenNullContents_WhenGatewayReadsFromFtp_ThenThrowsException()
    {
       $this->gateway->getRTTrainData();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenSimpleContentsWrongFileName_WhenGatewayReadsFromFtp_ThenThrowsException()
    {
        $this->mockFtpAdapter->setContents( ['blahblah-filename.xml.gz' => 'not relevant'] );
        $this->gateway->getRTTrainData();
    }

    /**
     * @test
     */
    public function givenEmptyContentsCorrectFilename_WhenDownloadedFileIsReadAsEmpty_ThenReturnsFalse()
    {
        $realFileName = "1" . $this->correctFileEnding;
        $this->mockFtpAdapter->setContents( [ $realFileName => '' ] );
        $data = $this->gateway->getRTTrainData();
        $this->assertEmpty( $data );
    }

    /**
     * @test
     */
    public function givenExistingFileWithContents_WhenDownloaded_ThenFileIsDecompressedAndReturned()
    {
        $expectedData = 'a gzipped file';
        $realFileName = "1" . $this->correctFileEnding;
        $this->mockFtpAdapter->setContents( [ $realFileName => $expectedData ] );
        $data = $this->gateway->getRTTrainData();
        $this->assertEquals(  $expectedData, $data );
    }

    /**
     * @test
     */
    public function givenRealFtpConnection_WhenDownloaded_ThenFileIsDecompressedAndReturned()
    {
        $config = array(
            'host' => 'datafeeds.nationalrail.co.uk',
            'username' => 'ftpuser',
            'password' => 'A!t4398htw4ho4jy'
        );
        $gateway = new RTTrainDataFtpGateway( new Ftp( $config ) );
        $data = $gateway->getRTTrainData();
        $this->assertStringStartsWith( '<?xml version="1.0" encoding="UTF-8"?>', substr( $data, 0, 100 ), 'prefix failed' );
        $this->assertStringEndsWith( '</Pport>', substr( $data, strlen( $data )-100 ), 'suffix failed' );
    }
}
