<?php

function reverse_tgl($tgl): string
{
    $imp = explode("/", $tgl);
    return $imp[2] . '-' . $imp[1]. '-' . $imp[0];
}
