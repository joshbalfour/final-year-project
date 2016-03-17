<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 19/02/16
 * Time: 14:36
 */

namespace App\Console\Commands;


use Carbon\Carbon;

class ImportRTTrainsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MockRTTrainDataGateway
     */
    private $mockGateway;

    /**
     * @var ImportRTTrains
     */
    private $command;

    /**
     * @var MockTrainDataStorage
     */
    private $mockStorage;

    public function setUp()
    {
        parent::setUp();

        $this->mockGateway = new MockRTTrainDataGateway();
        $this->mockStorage = new MockTrainDataStorage();
        $this->command = new ImportRTTrains( $this->mockGateway, $this->mockStorage );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenNullData_WhenParsed_ThenThrowsParserException()
    {
        $this->command->handle();
        $this->assertTrue( $this->mockStorage->isEmpty() );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenNonXMLData_WhenParsed_ThenThrowsParserException()
    {
        $this->mockGateway->setData( 'John Cena' );
        $this->command->handle();
        $this->assertTrue( $this->mockStorage->isEmpty() );
    }

   
}
