<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 13/11/15
 * Time: 14:59
 */

namespace App\Storage;


class TrainDataMysqlStorageTest extends \TestCase
{
    private $storage;

    public function setUp()
    {
        parent::setUp();
        $this->storage = new TrainDataMysqlStorage();
    }

    /**
     * @test
     */
    public function given_When_Then()
    {
        //
    }
}
