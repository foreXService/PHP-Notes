<?php

declare(strict_types=1);
$debug = true;



if (!$debug)
{
    error_reporting(0);
    ini_set('display_errors','0');

    function dump($data)
    {
    }

    function isDebug()
    {
        return false;
    }
    
}
else
{

    error_reporting(E_ALL);
    ini_set('display_errors','1');

    function dump($data)
    {
        echo '<br><div 
            style="
                display: inline-block;
                padding: 0 10px;
                border: 1px dashed gray;
                background:lightgray;
            "
        ><pre>';
        print_r($data);
        echo '</pre></div><br>';
    }

    function isDebug()
    {
        return true;
    }

    
}
