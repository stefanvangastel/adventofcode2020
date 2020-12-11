<?php

# Get input, strip trailing newline with regex (because we can)
$map = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Part 1
$result = shufflin($map);
printf("\n\nPart 1: Seating took %s rounds and resulted in %d occupied seats\n", $result['shuffles'], getOccupiedSeats($result['map']) );

# Part 2
$result = shufflin($map, 'los', 5);
printf("\n\nPart 2: Seating took %s rounds and resulted in %d occupied seats\n", $result['shuffles'], getOccupiedSeats($result['map']) );



##############################################
############################################## FUNCTIONS ##############################################
##############################################



/**
 * Every day I'm shufflin'!
 */
function shufflin($map, $method = 'direct', $tollerance = 4){
    
    # Define shuffles
    $shuffles = 0;

    # Start shuffling
    while(true == true){

        # Copy the map to check if it changed
        $origMap = $map;

        # Make a move 
        $map = takeASeat($map, $method, $tollerance);

        # Check maps identical, if so people haven't moved
        if( serialize($map) == serialize($origMap) ){
            break;
        }

        # Next...
        $shuffles++;

        # Debug
        #echo "\n\nShuffle: $shuffles\n";
        #printMap($map);

    }

    return ['shuffles' => $shuffles, 'map' => $map];
}

/**
 * Get occupied seats in map
 */
function getOccupiedSeats($map){
    # Now count the occupied seats:
    $occupiedSeats = 0;
    
    foreach($map as $row){
        $occupiedSeats += substr_count($row,"#");
    }
    
    return $occupiedSeats;
}

/**
 * Process map
 */
function takeASeat($map, $method = 'direct', $tollerance = 4){
    
    # Set a return map
    $newMap = $map;
    
    # Foreach row
    foreach($map as $rowIndex => $row){

        # Foreach col
        foreach( str_split($row) as $colIndex => $col ){

            # Check thy neighbours (based on direct or LoS method)
            if($method == 'direct'){
                $neighbours = getNeighbours($map, $rowIndex, $colIndex);
            }else if($method == 'los'){
                $neighbours = getVisibleSeats($map, $rowIndex, $colIndex);
            }else{
                die("Bad method: $method");
            }
        
            # If this seat is free and no occupied seats in neighbours, occupy this one!
            if( $map[$rowIndex][$colIndex] == 'L' AND $neighbours['#'] == 0 ){
                $newMap[$rowIndex][$colIndex] = '#';
            }

            # If this seat is occupied and 4 (or 5) or more seats occupied in neighbours, abondon ship!
            if( $map[$rowIndex][$colIndex] == '#' AND $neighbours['#'] >= $tollerance ){
                $newMap[$rowIndex][$colIndex] = 'L';
            }

        }
    }

    return $newMap;
}

/**
 * Print a map
 */
function printMap($map){
    echo "----------\n";
    echo implode("\n",$map);
}

/**
 * Get all neighours
 */
function getNeighbours($map,$row,$col){

    # Dont know about part 2 yet but lets be prepared:
    $values = [
        'L' => 0,
        '.' => 0,
        '#' => 0
    ];

    # Start checking neighbours, first go down 0 rows and right 1 col, then move around our index clockwise 
    $neighbours = [
        [ 0, 1], # East
        [ 1, 1],
        [ 1, 0], # South
        [ 1,-1],
        [ 0,-1], # West
        [-1,-1], 
        [-1, 0], # North
        [-1, 1]
    ];

    # Check all neighbours if they exist
    foreach( $neighbours as list($modRow, $modCol) ){

        # Define neighbour id
        $checkRow = $row + $modRow;
        $checkCol = $col + $modCol;

        # If we get out of bounds, move on
        if( $checkRow < 0 || $checkCol < 0 ) continue;

        # Check this neighbour on the map, also check if it exists (corners of maps dont have neighbours)
        if( !empty( $map[$checkRow][$checkCol] ) ){
            $value = $map[$checkRow][$checkCol];
            $values[$value]++;
        } 

    }

    # Return amount of neighbours
    return $values;
}

/**
 * Get seats in sight
 */
function getVisibleSeats($map, $row, $col){

    # Set var
    $values = [
        'L' => 0,
        '.' => 0,
        '#' => 0
    ];

    # Start checking directions 
    $directions = [
        [ 0, 1], # East
        [ 1, 1],
        [ 1, 0], # South
        [ 1,-1],
        [ 0,-1], # West
        [-1,-1], 
        [-1, 0], # North
        [-1, 1]
    ];

    # Check all neighbours if they exist
    foreach( $directions as list($modRow, $modCol) ){

        # Start with assumption first value floor 
        $value = '.';

        # Define first id
        $checkRow = $row + $modRow;
        $checkCol = $col + $modCol;

        while($value == '.'){

            # If we get out of bounds, move on
            if( $checkRow < 0 || $checkCol < 0 ) break;

            # Check for value, breaek if empty and search next direction
            if( empty( $map[$checkRow][$checkCol]) ){
                break;
            }

            # Get the value
            $value = $map[$checkRow][$checkCol];

            # Looking at occupied seat
            if( $map[$checkRow][$checkCol] == '#' ){
                # Add a 
                $values['#']++;
            }else if( $map[$checkRow][$checkCol] == 'L' ){
                # Looking at empty seat, move on to next direction!
                $values['L']++;
                break;
            }else{
                # Looking at floor, move to next spot in direction
                $checkRow += $modRow;
                $checkCol += $modCol;
                continue;
            }

            # Break
            break;
        }
    }

    # Return amount of neighbours
    return $values;
}