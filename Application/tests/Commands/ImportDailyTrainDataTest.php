<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 03/11/15
 * Time: 14:04
 */

namespace App\Commands;


use App\Exceptions\FileNotFoundException;

class ImportDailyTrainDataTest extends \TestCase
{
    /**
     * @var ImportDailyTrainData
     */
    private $command;

    /**
     * @var MockFtpAdapter
     */
    private $mockFtpAdapter;

    public function setUp()
    {
        parent::setUp();

        $this->mockFtpAdapter = new MockFtpAdapter();
        $this->command = new ImportDailyTrainData( $this->mockFtpAdapter );
    }

    /**
     * @test
     */
    public function givenNullContents_WhenImporterReadsFromFtp_ThenReturnsNull()
    {
        $this->assertNull( $this->command->handle() );
    }

    /**
     * @test
     */
    public function givenSimpleContentsWrongFileName_WhenImporterReadsFromFtp_ThenReturnsNull()
    {
        $this->mockFtpAdapter->setContents( ['blahblah-filename.xml.gz' => 'not relevant'] );
        $this->assertNull( $this->command->handle() );
    }

    /**
     * @test
     */
    public function givenEmptyContentsCorrectFilename_WhenSavedFileIsReadAsEmptyDbInsertFails_ThenReturnsFalse()
    {
        $filename = date('YmdHis') . '_v8.xml.gz';
        $this->mockFtpAdapter->setContents( [ $filename => '' ] );
        $this->assertFalse( $this->command->handle() );
    }
}
