<?php
# Get input, strip trailing newline with regex (because we can)
$numbers = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

/**
 * Calculate preamble
 * 
 * @param  	array	$numbers	Array of numbers, the preamble
 * @return 	array	            Retun an array of sums 
 */
function calcPreamble($numbers){

    # Define sums var to return
    $sums = [];

    foreach($numbers as $key => $number){

        # Copy the array
        $plusNumbers = $numbers;

        # Unset this key
        unset($plusNumbers[$key]);

        # Create sums
        foreach($plusNumbers as $plusNumber){
            # Add sum to sums
            $sums[] = $number + $plusNumber;
        }
    }

    # Return (unique) sums
    return array_unique($sums);

}

# --------------

# Set the preamble size 
$preambleSize = 25;

# Define the weak number
$weaknumber = false;

# Start checking (and crunching) numbers AFTER the preambleSize
foreach(array_slice($numbers, $preambleSize) as $offset => $number){

    # Check this value in the preamble sums:
    if( !in_array( $number, calcPreamble(array_slice($numbers, $offset, $preambleSize) ) ) ){
        $weaknumber = $number;
        printf("First non-compliant number is: %d\n",$number);
        break;
    }
}

# Start adding numbers until we get the exact $weaknumber
foreach($numbers as $index => $number){

    # (Re)set some vars we use
    $contiguousSet = [];
    $sum           = 0;
    $pointer       = $index;

    # Start endless loop
    while(true == true){
       
        $sum += $numbers[$pointer];
        $contiguousSet[] = $numbers[$pointer];

        # Found it!
        if($sum == $weaknumber){

            #Yeey, add smallets and largets numbers so min/max this mofo!
            $smallest = min($contiguousSet);
            $largest  = max($contiguousSet);

            printf("Sum of smallest (%d) and largest (%d) number in contiguous set: %d\n", $smallest, $largest, $smallest + $largest );
            exit;
        }

        # We passed the number, so lets abort.. 
        if($sum > $weaknumber){
            break;
        }

        # Not found it... yet.. Up the pointer to get the next number in line and add it 
        $pointer++;
    } 

}