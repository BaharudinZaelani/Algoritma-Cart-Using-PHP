<?php 
// remove space and break line
function removeBs( $text ) {
    $rr = str_replace('	', ",",$text);
    $rq = str_replace("\n", " ,", $text);
    $EResult = explode(",", $rq);
    $result = "";
    foreach ( $EResult as $row ) {
        $reR = explode("	", $row);
        foreach ( $reR as $rrow ){
            $result .= $rrow . ",";
        }
    }
    // var_dump($result);
    return $result;
}