<?php

/** code to sort language variable
 * 
 * @author   Kalyani Makwana <kalyani.makwana@gmail.com>
 */


// Read file line by line
$inputfile = fopen("en.properties", "r");
if ($handle) {
    $translations = [];
    $currentComment = '';

    while (($line = fgets($inputfile)) !== false) {
        // process the line read.
        if(substr($line, 0, 1) == '#') {
            // if comment then add in temporary string
            $currentComment .= $line;
        } else {
            // if language vriable then add in temporary array
            if($currentComment != '') {
                // if comment available for this variable then add both comment and variable
                $translations[] = array('variable' => $line, 'comment' => $currentComment);
                $currentComment = '';
            } else {
                // if only variable 
                $translations[] = array('variable' => $line);
            }
        }
        
    }

    fclose($inputfile);

    
    // sort this temporary array to sort language variables
    usort($translations, fn($a, $b) => $a['variable'] <=> $b['variable']);

    // create or open output file to save this sorted variables
    $outputfile = fopen("en-sorted.properties", "w") or die("Unable to open file!");

    // add variables using loop from array to file
    foreach($translations as $key => $value) {
        if(isset($value['comment']) &&  $value['comment'] != '') {
            // check if comment available then add comment first
            fwrite($outputfile, $value['comment']);
        }
        // write language variable
        fwrite($outputfile, $value['variable']);
    }
    
    fclose($outputfile);
}

exit;
