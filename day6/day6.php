<?php
# Get input, strip trailing newline with regex (because we can)
$lines = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Walk the lines #johnnycash
foreach ($lines as $k => $line){

    # Keep appending to array if not newline
    if ($line != '') $questions[] = str_split($line);

    # If newline (or end of array)
    if ($line == '' || $k == count($lines)-1){

        # Use array_unique on a string converted to array for unique chars
        $unique_answers +=  count( 
                                array_unique( 
                                    str_split( 
                                        implode( '',array_map( function ($entry) {
                                                                    return implode('', $entry);
                                                                }, $questions
                                                    ) 
                                        ) 
                                    ) 
                                ) 
                            );

        # Matching answers
        $common_answers += ( count( call_user_func_array('array_intersect', (count($questions) == 1 ? [$questions[0],$questions[0]] : $questions) ) ) );

        # Reset
        $questions = [];
    }
}

#Part 1
printf("Unique answers: %d\n",$unique_answers);

# Part 2
printf("Common answers: %d\n",$common_answers);