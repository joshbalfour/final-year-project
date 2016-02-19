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

    /**
     * @test
     */
    public function givenUpdateWithOneLateArrival_WhenParsed_ThenRowUpdatedInDb()
    {
        $data =
            '<Pport><Location rid="1" ssd="'.date("Y-m-d").'" tpl="DESTINATION" ><arr et="16:10" wta="16:04" /></Location></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [ 1, 'HOME', new Carbon( date('Y-m-d').' 16:00:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:04:00' ) ] );
        $this->command->handle();
        $expected = [
            [
                1,
                'HOME',
                new Carbon( date('Y-m-d').' 16:00:00' ),
                'DESTINATION',
                new Carbon( date('Y-m-d').' 16:10:00' )
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData() );
    }

    /**
     * @test
     */
    public function givenUpdateWithOneLateDeparture_WhenParsed_ThenRowUpdatedInDb()
    {
        $data =
            '<Pport><Location rid="1" ssd="'.date("Y-m-d").'" tpl="DESTINATION" ><dep et="16:06" wtd="16:00" /></Location></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [ 1, 'HOME', new Carbon( date('Y-m-d').' 16:00:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:20:00' ) ] );
        $this->command->handle();
        $expected = [
            [
                1,
                'HOME',
                new Carbon( date('Y-m-d').' 16:06:00' ),
                'DESTINATION',
                new Carbon( date('Y-m-d').' 16:20:00' )
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData() );
    }

    /**
     * @test
     */
    public function givenUpdateWithOneAlteredPassThrough_WhenParsed_ThenTwoRowsUpdatedInDb()
    {
        $data =
            '<Pport><Location rid="1" ssd="'.date("Y-m-d").'" tpl="DESTINATION" ><pass et="16:06" wtp="16:00" /></Location></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [ 1, 'HOME', new Carbon( date('Y-m-d').' 15:30:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:00:00' ) ] );
        $this->mockStorage->insert( [ 1, 'DESTINATION', new Carbon( date('Y-m-d').' 16:00:00' ), 'ELSEWHERE', new Carbon( date('Y-m-d').' 16:20:00' ) ] );
        $this->command->handle();
        $expected = [
            [
                1,
                'HOME',
                new Carbon( date('Y-m-d').' 15:30:00' ),
                'DESTINATION',
                new Carbon( date('Y-m-d').' 16:06:00' )
            ],
            [
                1,
                'DESTINATION',
                new Carbon( date('Y-m-d').' 16:06:00' ),
                'ELSEWHERE',
                new Carbon( date('Y-m-d').' 16:20:00' )
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData() );
    }
}
