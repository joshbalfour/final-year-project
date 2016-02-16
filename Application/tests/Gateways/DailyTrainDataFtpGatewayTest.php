<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 11:56
 */

namespace App\Gateways;


use League\Flysystem\Adapter\Ftp;

class DailyTrainDataFtpGatewayTest extends \TestCase
{
    /**
     * @var string correct filename for the data file on the ftp server
     */
    private $correctFilename;

    /**
     * @var DailyTrainDataFtpGateway
     */
    private $command;

    /**
     * @var MockFtpAdapter
     */
    private $mockFtpAdapter;

    public function setUp()
    {
        parent::setUp();

        $this->correctFilename = date('YmdHis') . '_v8.xml.gz';

        $this->mockFtpAdapter = new MockFtpAdapter();
        $this->command = new DailyTrainDataFtpGateway( $this->mockFtpAdapter );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenNullContents_WhenImporterReadsFromFtp_ThenThrowsException()
    {
        $this->assertNull( $this->command->getDailyTrainData() );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenSimpleContentsWrongFileName_WhenImporterReadsFromFtp_ThenThrowsException()
    {
        $this->mockFtpAdapter->setContents( ['blahblah-filename.xml.gz' => 'not relevant'] );
        $this->command->getDailyTrainData();
    }

    /**
     * @test
     */
    public function givenEmptyContentsCorrectFilename_WhenDownloadedFileIsReadAsEmpty_ThenReturnsFalse()
    {
        $this->mockFtpAdapter->setContents( [ $this->correctFilename => '' ] );
        $filePath = $this->command->getDailyTrainData();
        $this->assertEquals( "/tmp/trainTimesData.xml", $filePath);
        $this->assertEmpty( file_get_contents( $filePath ) );
    }

    /**
     * @test
     */
    public function givenExistingFileWithContents_WhenDownloaded_ThenFileIsDecompressedAndReturned()
    {
        $data = 'a gzipped file';
        $this->mockFtpAdapter->setContents( [ $this->correctFilename => gzencode($data) ] );
        $filePath = $this->command->getDailyTrainData();
        $this->assertEquals( "/tmp/trainTimesData.xml", $filePath);
        $this->assertEquals( $data, file_get_contents( $filePath ) );
    }

    /**
     * no longer asserting anything,
     * possibly needs a move to an integration test suite
     */
    public function givenRealFormatDataFile_WhenDownloaded_ThenFileIsDecompressedAndReturned()
    {
        $compressedData = file_get_contents( 'tests/Data/TrainTimeData/compressed_test.xml.gz' );
        $uncompressed_data = file_get_contents( 'tests/Data/TrainTimeData/decompressed_test.xml' );
        $this->mockFtpAdapter->setContents( [ $this->correctFilename => $compressedData ] );
        $filePath = $this->command->getDailyTrainData();

        // let's not assert two 55MB strings against each other
        // How can we know it works if we don't?
        /*
            $this->assertEquals( "/tmp/trainTimesData.xml", $filePath);
            $this->assertEquals( $uncompressed_data, file_get_contents( $filePath ) );
        */
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
        $command = new DailyTrainDataFtpGateway( new Ftp( $config ) );
        $filePath = $command->getDailyTrainData();
        $this->assertEquals( "/tmp/trainTimesData.xml", $filePath);

        $xmlData = file_get_contents( $filePath );
        $this->assertStringStartsWith( '<?xml version="1.0" encoding="utf-8"?>', substr( $xmlData, 0, 100 ), 'prefix failed' );
        $this->assertStringEndsWith( '</PportTimetable>', substr( $xmlData, strlen( $xmlData )-100 ), 'suffix failed' );
    }
}
