<?php

class TestScript
{
    public function execute()
    {
        $start = microtime(true);
        // Enter your code here
        // var_dump((new Travel)->getData());
        echo json_encode((new Company)->getNestedArrayOfCompanies());
        // echo json_encode($result);
        echo '<br> Total time: '.  (microtime(true) - $start);
    }
}
