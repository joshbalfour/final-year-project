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
       $this->gateway->getRTTrainData(1);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenSimpleContentsWrongFileName_WhenGatewayReadsFromFtp_ThenThrowsException()
    {
        $this->mockFtpAdapter->setContents( ['blahblah-filename.xml.gz' => 'not relevant'] );
        $this->gateway->getRTTrainData(1);
    }

    /**
     * @test
     */
    public function givenEmptyContentsCorrectFilename_WhenDownloadedFileIsReadAsEmpty_ThenReturnsFalse()
    {
        $realFileName = "1" . $this->correctFileEnding;
        $this->mockFtpAdapter->setContents( [ $realFileName => '' ] );
        $filePaths = $this->gateway->getRTTrainData(1);
        $this->assertEquals( ["/tmp/".$realFileName], $filePaths);
        $this->assertEmpty( file_get_contents( $filePaths[0] ) );
    }

    /**
     * @test
     */
    public function givenExistingFileWithContents_WhenDownloaded_ThenFileIsDecompressedAndReturned()
    {
        $data = 'a gzipped file';
        $realFileName = "1" . $this->correctFileEnding;
        $this->mockFtpAdapter->setContents( [ $realFileName => $data ] );
        $filePaths = $this->gateway->getRTTrainData(1);
        $this->assertEquals( ["/tmp/".$realFileName], $filePaths);
        $this->assertEquals( $data, file_get_contents( $filePaths[0] ) );
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
        $filePaths = $gateway->getRTTrainData( 1 );
        $this->assertEquals( ["/tmp/pPortData.log"], $filePaths);

        $xmlData = file_get_contents( $filePaths[0] );
        $this->assertStringStartsWith( '<?xml version="1.0" encoding="UTF-8"?>', substr( $xmlData, 0, 100 ), 'prefix failed' );
        $this->assertStringEndsWith( '</Pport>', substr( $xmlData, strlen( $xmlData )-100 ), 'suffix failed' );
    }
}
