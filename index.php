<?php 
include "split.php";

$file = removeBs(file_get_contents("tableDump/finalMybe.txt"));
$ex = explode(",", $file);
$e_res = [
    "responden" => [],
    "jk" => [],
    "pekerjaan" => [],
    "partai" => [],
    "paselon" => [],
];
$result = [];
foreach( $ex as $key => $row ) {
    if ( false ) {
        $e_res['responden'][] = $row;
    }else {
        // ambil responden
        $tmp = explode(" ", $row);
        if ( isset($tmp[1]) ) {
            if ( !empty($tmp[1]) ) {
                $e_res['responden'][] = $tmp[1];
            }else {
                // ambil paselon
                $e_res['paselon'][] = $tmp[0];
            }
        }

        // ambil jk
        if ( $row == "P" ) {
            $e_res['jk'][] = $row;
        }else if( $row == "L" ) {
            $e_res['jk'][] = $row;
        }

        // ambil pekerja
        if ( $row == "Wiraswasta" OR $row == "Petani" OR $row == "IRT" OR $row == "Karyawan" ) {
            $e_res['pekerjaan'][] = $row;
        }

        // ambil partai
        if ( $row == "GERINDRA" OR $row == "GOLKAR" OR $row == "PDIP" OR $row == "PKS" OR $row == "PPP" OR $row == "DEMOKRAT" ) {
            $e_res['partai'][] = $row;
        }
    }
}
// masukan responden
foreach ( $e_res['responden'] as $key => $row ) {
    $result[$key]['responden'] = $row;
}

// masukan jk
foreach ( $e_res['jk'] as $key => $row ) {
    $result[$key]['jk'] = $row;
}

// masukan pekerjaan
foreach ( $e_res['pekerjaan'] as $key => $row ) {
    $result[$key]['pekerjaan'] = $row;
}

// masukan partai
foreach ( $e_res['partai'] as $key => $row ) {
    $result[$key]['partai'] = $row;
}

// masukan paselon
foreach ( $e_res['paselon'] as $key => $row ) {
    $result[$key]['paselon'] = $row;
}

// var_dump(count($result));die;

function hitung($result, $rr, $value) {
        
    // pl 1
    $pl_jk = [
        "pl" => "",
        "pjtl1" => "",
        "pjtl2" => "",
        "data" => []
    ];
    // pr 1
    $pr_jk = [
        "pr" => "",
        "pjtr1" => "",
        "pjtr2" => "",
        "data" => []
    ];


    $pli = 1;
    $pri = 1;
    // split pl/pr
    foreach ( $result as $row ) {
        // var_dump($row);
        if ( $row[$rr] == $value ) {
            $pl_jk['pl'] = $pli++ . "/" . count($result);
            $pl_jk['data'][] = $row;
        }else {
            $pr_jk['pr'] = $pri++ . "/" . count($result);
            $pr_jk['data'][] = $row;
        }
    }
    // split P(j|tL) / P(j|tR)
    $pjltCount = 1; 
    $pjlrCount = 1; 
    foreach ( $pl_jk['data'] as $row ) {
        if ( $row['paselon'] == "1" ) {
            $rr = $pjltCount++;
            $pl_jk['pjtl1'] = $rr . "/" . count($pl_jk['data']);
        }else {
            $re = $pjlrCount++;
            $pl_jk['pjtl2'] = $re . "/" . count($pl_jk['data']);
        }
    }
    $pjltCount = 1; 
    $pjlrCount = 1; 
    foreach ( $pr_jk['data'] as $row ) {
        if ( $row['paselon'] == "1" ) {
            $rr = $pjltCount++;
            $pr_jk['pjtr1'] = $rr . "/" . count($pr_jk['data']);
        }else {
            $re = $pjlrCount++;
            $pr_jk['pjtr2'] = $re . "/" . count($pr_jk['data']);
        }
    }

    return [
        "pl" => $pl_jk['pl'],
        "pjtl1" => $pl_jk['pjtl1'],
        "pjtl2" => $pl_jk['pjtl2'],
        "",
        "pr" => $pr_jk['pr'],
        "pjtr1" => $pr_jk['pjtr1'],
        "pjtr2" => $pr_jk['pjtr2'],
    ];
}
// Eksekusi manggggggg :3 @BaharDevTampan

// jk
// var_dump(hitung($result, "jk", "P"));
// var_dump(hitung($result, "jk", "L"));

// pekerjaan 
// var_dump(hitung($result, "pekerjaan", "Wiraswasta"));
// var_dump(hitung($result, "pekerjaan", "Petani"));
// var_dump(hitung($result, "pekerjaan", "IRT"));
// var_dump(hitung($result, "pekerjaan", "Karyawan"));

// pekerjaan 
// var_dump(hitung($result, "partai", "DEMOKRAT"));
// var_dump(hitung($result, "partai", "GARINDRA"));
// var_dump(hitung($result, "partai", "GOLKAR"));
// var_dump(hitung($result, "partai", "PDIP"));
// var_dump(hitung($result, "partai", "PKS"));
// var_dump(hitung($result, "partai", "PPP"));