<?php

//namespace App;

class DateTim
{
    /**
     * Test Code
     */
    public function write()
    {
        echo "Test";
    }
}

function helloWorld()
{
   echo 'Hello World!';
}
function handle(callable $fn)
{
   $fn(); // We know the parameter is callable then we execute the function.
}

handle('helloWorld'); // Outputs: Hello World!

/*

try{
    $x= 5;

    if($x == 2){
        throw new Exception("Error Processing Request");
    }

    elseif ($x == 3) {
        throw new Exception("Error Processing");
    }

    elseif ($x == 5) {
        throw new InvalidArgumentException("Error");
    }

}

catch(Exception $e){
    echo $e->getMessage();
}

catch(Invalid $e){
    echo $e->getMessage();
}

finally{
    echo "<br>";
    echo "lol";
}

*/