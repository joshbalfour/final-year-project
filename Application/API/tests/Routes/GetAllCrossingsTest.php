<?php
/**
 * Created by PhpStorm.
 * User: woodyblah
 * Date: 19/10/15
 * Time: 11:58
 */

class GetAllCrossingsTest extends TestCase {

    /**
     * @test
     */
    public function givenNoCrossings_WhenCrossingVisited_ThenSeeEmptyArray()
    {
        $this->visit( '/crossings' )->see('{}');
    }

}