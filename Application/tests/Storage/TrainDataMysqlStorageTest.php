<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 13/11/15
 * Time: 14:59
 */

namespace App\Storage;

use Illuminate\Support\Facades\DB;

class TrainDataMysqlStorageTest extends \TestCase
{
    /**
     * @var TrainDataMysqlStorage
     */
    private $storage;

    public function setUp()
    {
        parent::setUp();
        $this->storage = new TrainDataMysqlStorage();
    }

    public function tearDown()
    {
        DB::statement('truncate table train_times');
        parent::tearDown();
    }

    /**
     * @test
     */
    public function givenNoData_WhenInsertCalled_ThenNoDataInTable()
    {
        try {
            $this->storage->insert( null, null,new \DateTime(), null, new \DateTime() );
        } catch (\Exception $e){
            
        }
        $this->assertEmpty( $this->getRowsFromDb() );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenInvalidData_WhenInsertCalled_ThenThrowsException()
    {
        $this->storage->insert( 'nothing useful', 'at all',  new \DateTime('0'), 'from_time', new \DateTime('0') );
    }

    /**
     * @test
     */
    public function givenValidRow_WhenInsertIsCalled_ThenCorrectRowIsReturned()
    {
        $row = [
            'from_tpl' => 'HOME',
            'from_time' => '2015-01-01 10:00:00',
            'to_tpl' => 'DESTINATION',
            'to_time' => '2015-01-01 11:00:00',
            'rid' => '1'
        ];
        $this->storage->insert( [[$row['rid'], $row['from_tpl'], new \DateTime($row['from_time']), $row['to_tpl'], new \DateTime($row['to_time']) ]]);
        $results = $this->getRowsFromDb();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowInserted($row, $results[0]);
    }

    /**
     * @param $row
     * @param $result
     */
    private function assertExpectedRowInserted($row, $result)
    {
        $this->assertEquals($row['from_tpl'], $result->from_tpl);
        $this->assertEquals($row['from_time'], $result->from_time);
        $this->assertEquals($row['to_tpl'], $result->to_tpl);
        $this->assertEquals($row['to_time'], $result->to_time);
    }

    /**
     * @return mixed
     */
    private function getRowsFromDb()
    {
        $results = DB::select('select * from train_times');
        return $results;
    }
}
