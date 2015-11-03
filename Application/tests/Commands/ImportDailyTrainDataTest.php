<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 03/11/15
 * Time: 14:04
 */

namespace App\Commands;


class ImportDailyTrainDataTest extends \TestCase
{
    /**
     * @test
     */
    public function canConstruct()
    {
        $command = new ImportDailyTrainData();
    }
}
