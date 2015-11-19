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
        DB::statement('delete from train_times where id <> 0');
        parent::tearDown();
    }

    /**
     * @test
     */
    public function givenNoData_WhenInsertCalled_ThenNoDataInTable()
    {
        $this->storage->insert( [] );
        $this->assertEmpty( $this->getRowsFromDb() );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenInvalidData_WhenInsertCalled_ThenThrowsException()
    {
        $this->storage->insert( ['nothing useful', 'at all', [ 'nothing in here either' ], [ 'from_time' => 'not a valid date time' ] ] );
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
        $this->storage->insert( [ $row ] );
        $results = $this->getRowsFromDb();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowInserted($row, $results[0]);
    }

    /**
     * @test
     */
    public function givenMultpleValidRows_WhenInsertIsCalled_ThenCorrectRowsAreInserted()
    {
        $rows = [
            [
                'from_tpl' => 'HOME',
                'from_time' => '2015-01-01 10:00:00',
                'to_tpl' => 'DESTINATION',
                'to_time' => '2015-01-01 11:00:00',
                'rid' => '1'
            ],
            [
                'from_tpl' => 'HOME2',
                'from_time' => '2015-01-01 12:00:00',
                'to_tpl' => 'DESTINATION2',
                'to_time' => '2015-01-01 13:00:00',
                'rid' => '2'
            ]
        ];
        $this->storage->insert( $rows );
        $results = $this->getRowsFromDb();
        $this->assertNotEmpty( $results );
        foreach( $rows as $index => $row ) {
            $this->assertExpectedRowInserted($row, $results[ $index ]);
        }
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
