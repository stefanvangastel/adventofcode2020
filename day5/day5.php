<?php
# Get input, strip trailing newline with regex (because we can)
$barcodes = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Start loop
foreach ($barcodes as $barcode){

    # Get row and column
    $row    = bindec( strtr( substr( $barcode, 0, 7 ), ['F'=>'0','B'=>'1'] ) ); 
    $column = bindec( strtr( substr( $barcode, -3 )  , ['L'=>'0','R'=>'1'] ) ); 
    
    # Get seatID
    $seatId = ($row * 8) + $column;

    # Set highest var if higher (php is nice and lazy so no need to init vars :D Love it)
    if($seatId > $highestSeatId) $highestSeatId = $seatId;

    # Add to seats
    $seats[] = $seatId;
}

# Answer me part 1 you evil machine! 
printf("The highest SeatId is: %d\n", $highestSeatId);

# Create complete seat list:
$allSeats = range( min($seats) ,max($seats) );

# Answer me part 2 thy simple calculator! 
printf("The missing SeatId is: %s\n", implode("" ,array_diff($allSeats, $seats) ) );