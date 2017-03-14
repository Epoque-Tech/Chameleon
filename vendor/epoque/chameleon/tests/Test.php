<?php
namespace Epoque\ChameleonTesting;


/**
 * Test Interface
 *
 * Each implementing Test class will utilize the run method.
 *
 * The run method will execute tests (methods) printing useful HTML
 * output including the result of the test (either pass or fail).
 */

interface Test
{
    public static function run();
}
