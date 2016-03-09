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
            '<Pport><TS rid="1" ssd="'.date("Y-m-d").'"><ns3:Location tpl="DESTINATION" wta="16:04" ><ns3:arr et="16:10" /></ns3:Location></TS></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [[ 1, 'HOME', new Carbon( date('Y-m-d').' 16:00:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:04:00' ) ]] );
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
            '<Pport><TS rid="1" ssd="'.date("Y-m-d").'"><ns3:Location tpl="DESTINATION" wtd="16:00" ><ns3:dep et="16:06" /></ns3:Location></TS></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [[ 1, 'HOME', new Carbon( date('Y-m-d').' 16:00:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:20:00' ) ]] );
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
            '<Pport><TS rid="1" ssd="'.date("Y-m-d").'"><ns3:Location tpl="DESTINATION" wtp="16:00" ><ns3:pass et="16:06" /></ns3:Location></TS></Pport>';
        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [[ 1, 'HOME', new Carbon( date('Y-m-d').' 15:30:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:00:00' ) ],
            [ 1, 'DESTINATION', new Carbon( date('Y-m-d').' 16:00:00' ), 'ELSEWHERE', new Carbon( date('Y-m-d').' 16:20:00' ) ]] );
        $this->mockStorage->insert( [] );
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

    /**
     * @test
     */
    public function givenUpdateWithRealLifeLookingXml_WhenParsed_ThenRowUpdatedInDb()
    {
        $data = '<Pport xmlns="http://www.thalesgroup.com/rtti/PushPort/v12" xmlns:ns3="http://www.thalesgroup.com/rtti/PushPort/Forecasts/v2" ts="2016-02-19T10:58:00.8711777Z" version="12.0"><uR updateOrigin="Darwin"><TS rid="1" ssd="'.date("Y-m-d").'" uid="C60247"><ns3:Location pta="16:04" tpl="DESTINATION" wta="16:04"><ns3:arr et="16:10" src="Darwin"/><ns3:plat cisPlatsup="true" platsup="true">4</ns3:plat></ns3:Location></TS></uR></Pport>';

        $this->mockGateway->setData( $data );
        $this->mockStorage->insert( [[ 1, 'HOME', new Carbon( date('Y-m-d').' 16:00:00' ), 'DESTINATION', new Carbon( date('Y-m-d').' 16:04:00' ) ]] );
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
}
