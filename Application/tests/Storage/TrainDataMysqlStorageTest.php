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
        DB::statement('INSERT INTO tiploc_to_crs VALUES ("", "", "HOM", "", "HOME", "", ""), ( "", "", "DST", "", "DESTINATION", "", "" ) ');
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenNoData_WhenInsertCalled_ThenExceptionThrown()
    {
        $this->storage->insert( [[null, null,new \DateTime(), null, new \DateTime()]] );
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function givenInvalidData_WhenInsertCalled_ThenThrowsException()
    {
        $this->storage->insert( [['nothing useful', 'at all',  new \DateTime('0'), 'from_time', new \DateTime('0')]] );
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
        $results = $this->getRowsFromDbTrainTimes();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowInserted($row, $results[0]);
        DB::statement('DELETE from train_times WHERE rid = 1');
    }

    /**
     * @test
     */
    public function givenValidNewArrivalData_WhenUpdateCalled_ThenCorrectRowIsModified()
    {
        $this->insertIntoCrsTable(["HOM", "DST","2015-01-01 10:00:00","2015-01-01  11:00:00",1,"2015-01-01 10:00:00","2015-01-01 11:00:00"]);

        $updateRow = [
            'ta' => '2015-01-01 11:05:00',
            'wta' => '2015-01-01 11:00:00',
            'tpl' => 'DESTINATION',
            'rid' => '1'
        ];

        $this->storage->update( [ $updateRow ] );
        $results = $this->getRowsFromDbTrainTimesWithCrs();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowUpdated( $updateRow, $results[0], true );
        DB::statement('DELETE from train_times_with_crs WHERE rid = 1');
    }

    /**
     * @test
     */
    public function givenValidNewDepartureData_WhenUpdateCalled_ThenCorrectRowIsModified()
    {
        $this->insertIntoCrsTable(["HOM", "DST","2015-01-01 10:00:00","2015-01-01  11:00:00",1,"2015-01-01 10:00:00","2015-01-01 11:00:00"]);

        $updateRow = [
            'td' => '2015-01-01 10:05:00',
            'wtd' => '2015-01-01 10:00:00',
            'tpl' => 'HOME',
            'rid' => '1'
        ];

        $this->storage->update( [ $updateRow ] );
        $results = $this->getRowsFromDbTrainTimesWithCrs();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowUpdated($updateRow, $results[0], false );
        DB::statement('DELETE from train_times_with_crs WHERE rid = 1');
    }

    /**
     * @test
     */
    public function givenValidNewPassThroughData_WhenUpdateCalled_ThenCorrectRowIsModified()
    {
        $this->insertIntoCrsTable(["HOM", "DST","2015-01-01 10:00:00","2015-01-01  11:00:00",1,"2015-01-01 10:00:00","2015-01-01 11:00:00"]);
        $this->insertIntoCrsTable(["DST", "NUL","2015-01-01 11:00:00","2015-01-01  12:00:00",1,"2015-01-01 11:00:00","2015-01-01 12:00:00"]);

        $updateRow = [
            'ta' => '2015-01-01 11:05:00',
            'wta' => '2015-01-01 11:00:00',
            'td' => '2015-01-01 11:05:00',
            'wtd' => '2015-01-01 11:00:00',
            'tpl' => 'DESTINATION',
            'rid' => '1'
        ];

        $this->storage->update( [ $updateRow ] );
        $results = $this->getRowsFromDbTrainTimesWithCrs();
        $this->assertNotEmpty( $results );
        $this->assertExpectedRowsUpdated($updateRow, $results );
        DB::statement('DELETE from train_times_with_crs WHERE rid = 1');
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
    private function getRowsFromDbTrainTimes()
    {
        $results = DB::select('select * from train_times');
        return $results;
    }

    private function getRowsFromDbTrainTimesWithCrs()
    {
        $results = DB::select('select * from train_times_with_crs');
        return $results;
    }

    private function insertIntoCrsTable( $values )
    {
        $query =  "INSERT INTO train_times_with_crs ( from_crs, to_crs, from_time, to_time, rid, orig_from_time, orig_to_time) VALUES ( ?,?,?,?,?,?,? )";
        DB::statement( $query, $values );
    }

    private function assertExpectedRowUpdated( $row, $result, $isArrival )
    {
        if ( $isArrival ) {
            $this->assertEquals( $row['ta'], $result->to_time );
            $this->assertEquals( $row['wta'], $result->orig_to_time );
        } else {
            $this->assertEquals( $row['td'], $result->from_time );
            $this->assertEquals( $row['wtd'], $result->orig_from_time );
        }

    }

    private function assertExpectedRowsUpdated($updateRow, $results)
    {
        $this->assertExpectedRowUpdated( $updateRow, $results[0], true );
        $this->assertExpectedRowUpdated( $updateRow, $results[1], false );
    }
}
