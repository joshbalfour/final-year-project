<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 12:13
 */

namespace App\Commands;


use Exception;
use Nathanmac\Utilities\Parser\Parser;

class ImportDailyTrainDataTest extends \TestCase
{
    /**
     * @var MockDailyTrainDataGateway
     */
    private $mockGateway;

    /**
     * @var ImportDailyTrainData
     */
    private $command;

    /**
     * @var MockTrainDataStorage
     */
    private $mockStorage;

    public function setUp()
    {
        parent::setUp();

        $this->mockGateway = new MockDailyTrainDataGateway();
        $this->mockStorage = new MockTrainDataStorage();
        $this->command = new ImportDailyTrainData( $this->mockGateway, new Parser(), $this->mockStorage );
    }

    /**
     * @test
     */
    public function givenNullData_WhenParsed_ThenNoRowsInserted()
    {
        $this->command->handle();
        $this->assertTrue( $this->mockStorage->isEmpty() );
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function givenNonXMLData_WhenParsed_ThenThrowsParserException()
    {
        $this->mockGateway->setData( 'John Cena' );
        $this->command->handle();
    }

    /**
     * @test
     */
    public function givenSingleJourneyNoStopsInValidXMl_WhenParsed_ThenOneRowInsertedToDb()
    {
        $data =
           '<PportTimetable>
                <Journey rid="1" >
                    <OR tpl="START" wtd="16:04" />
                    <DT tpl="END" wta="16:20" />
                </Journey>
            </PportTimetable>';
        $this->mockGateway->setData( $data );
        $this->command->handle();
        $expected = [
            [
                'rid' => 1,
                'from' => 'START',
                'from_time' => date('Y-m-d').' 16:04:00',
                'to' => 'END',
                'to_time' => date('Y-m-d').' 16:20:00'
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData());
    }

    /**
     * @test
     */
    public function givenSingleJourneyWithPassThroughStop_WhenParsed_ThenTwoRowsInsertedIntoDb()
    {
        $data =
            '<PportTimetable>
                <Journey rid="1" >
                    <OR tpl="START" wtd="16:04" />
                    <PP tpl="MIDDLE" wtp="16:10"/>
                    <DT tpl="END" wta="16:20" />
                </Journey>
            </PportTimetable>';
        $this->mockGateway->setData( $data );
        $this->command->handle();
        $expected = [
            [
                'rid' => 1,
                'from' => 'START',
                'from_time' => date('Y-m-d').' 16:04:00',
                'to' => 'MIDDLE',
                'to_time' => date('Y-m-d').' 16:10:00'
            ],
            [
                'rid' => 1,
                'from' => 'MIDDLE',
                'from_time' => date('Y-m-d').' 16:10:00',
                'to' => 'END',
                'to_time' => date('Y-m-d').' 16:20:00'
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData());
    }

    /**
     * @test
     */
    public function givenSingleJourneyWithStationStop_WhenPArsed_ThenTwoRowsWithCorrectTimesInserted()
    {
        $data =
            '<PportTimetable>
                <Journey rid="1" >
                    <OR tpl="START" wtd="16:04" />
                    <IP tpl="MIDDLE" wta="16:10" wtd="16:12" />
                    <DT tpl="END" wta="16:20" />
                </Journey>
            </PportTimetable>';
        $this->mockGateway->setData( $data );
        $this->command->handle();
        $expected = [
            [
                'rid' => 1,
                'from' => 'START',
                'from_time' => date('Y-m-d').' 16:04:00',
                'to' => 'MIDDLE',
                'to_time' => date('Y-m-d').' 16:10:00'
            ],
            [
                'rid' => 1,
                'from' => 'MIDDLE',
                'from_time' => date('Y-m-d').' 16:12:00',
                'to' => 'END',
                'to_time' => date('Y-m-d').' 16:20:00'
            ]
        ];
        $this->assertEquals( $expected, $this->mockStorage->getData());
    }
}