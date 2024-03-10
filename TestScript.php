<?php

class TestScript
{
    public function execute()
    {
        $start = microtime(true);
        // Enter your code here
        echo json_encode((new Company)->getNestedArrayOfCompanies());
        // echo json_encode($result);
        echo '<br> Total time: '.  (microtime(true) - $start);
    }
}
