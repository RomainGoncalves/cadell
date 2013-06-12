<?php

    /**************************************************************/
    /**************************************************************/

    function formatValue($value)
    {
        if(isGPC()) return(stripslashes($value));
        return($value);
    }

    /**************************************************************/
    /**************************************************************/

    function isGPC()
    {
        return((bool)ini_get('magic_quotes_gpc'));
    }

    /**************************************************************/
    /**************************************************************/

    function isEmpty($value)
    {
        return(!(bool)mb_strlen($value));
    }

    /**************************************************************/
    /**************************************************************/

    function createResponse($response)
    {
        echo json_encode($response);
        exit;
    }

    /**************************************************************/
    /**************************************************************/

    function validateEmail($email)
    {
        if(!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$',$email)) return(false);
        else return(true);
    }

    /**************************************************************/
    /**************************************************************/
    
?>