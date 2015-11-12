<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 12:13
 */

namespace App\Commands;


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

    public function setUp()
    {
        parent::setUp();

        $this->mockGateway = new MockDailyTrainDataGateway();
        $this->command = new ImportDailyTrainData( $this->mockGateway, new Parser() );
    }

    /**
     * @test
     */
    public function givenNullData_WhenParsed_ThenReturnsEmptyArray()
    {
        $this->assertEquals( [], $this->command->handle() );
    }
}