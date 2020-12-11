<?php
# Get input, strip trailing newline with regex (because we can)
$adapters = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Add outlet (0) and device (max + 3)
$adapters[] = 0;
$adapters[] = max($adapters) + 3;

# Sort m
sort($adapters);

# Set vars we need
$ones   = 0;
$threes = 0;

# Create a second array without the outlet and align it:
$fit = array_slice($adapters,1);

# Add final value again to make sure arrays are same length for array_map
array_push($fit, max($fit));

# Start matching
foreach( array_map(null,$adapters,$fit) as list($in, $out) ){
    
    # Start counting
    if($out - $in == 1) $ones++;
    if($out - $in == 3) $threes++;
}

# Part 1
printf("Answer part 1: %d ones * %d threes = %d\n",$ones,$threes,$ones*$threes);

# Shit... we have to go recursive again for part 2...

function fiddle($adapters, $from, $device, &$history ){

    # Id is a hash of hashes to uniquely identify this set of adapters and $from
    $id = md5(md5( count($adapters) ) . md5($from) );

    # We already got this one..
    if( isset($history[$id]) ) return $history[$id];

    # Define a combinations var
    $combos = 0;

    # If we can connect our device to the origin, we got a combo
    if($device - $from <= 3){
        $combos++;
    }

    # If no more adapters left, return the combos
    if( ! $adapters ){
        return $combos;
    }

    # If the first adapter can connect to from (the outlet in the first run), run this function for first adapter as from and the rest of the array as adapters 
    if ($adapters[0] - $from <= 3){
        $combos += fiddle( array_slice($adapters, 1), $adapters[0], $device, $history );
    }

    # Add the initial combination
    $combos += fiddle( array_slice($adapters, 1), $from, $device, $history );

    # Add this path to the history
    $history[$id] = $combos;

    return $combos;
}

# Read adapters again
$adapters = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Sort m
sort($adapters);

# Create history array, pass by reference!
$history = [];

# Part 2
printf("Answer part 2: Computer says: %s combinations...\n", fiddle( $adapters, 0, max($adapters)+3, $history  ) );