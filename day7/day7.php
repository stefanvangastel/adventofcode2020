<?php
# Get input, strip trailing newline with regex (because we can)
$lines = explode("\n", preg_replace('/\n$/', '', file_get_contents('input.txt') ) );

# Let's get behind enemy lines and create a flat array of parents and children
foreach ($lines as $k => $line){
    preg_match_all('/(\d?)\s?(\w+\s\w+(?<!\bother))\sbag[s]?/', $line, $matches);

    # Matches 2 contain the bags in order
    foreach($matches[2] as $key => $value){
        
        # Key 0 = root
        if($key == 0){
            # Set root name
            $root = $value;

            # Create root if not set
            if( !isset($bags[$root]) ) $bags[$root] = [];

            # Next
            continue;
        }

        # Add bag and number
        $bags[$root][$value] = $matches[1][$key];

        # Add 'shiny gold' root bags to special place
        if($value == 'shiny gold') $gold_containers[$root] = true;
    }
}

# Define a find in bags function to get some recursivity going
function findInBags($container, $bags, &$colors){

    foreach($bags as $bag => $children){

        # Is this the bag we are looking for?
        if( isset($children[$container]) ){

            # Add to colors
            $colors[$bag] = true;
            
            # Then find this bag in all other bags
            findInBags($bag, $bags, $colors);
        }   
    }
}

# Count bags in bag..
function countBags($bag, $bags){
 
    # Check every child bag 
    foreach($bags[$bag] as $childbag => $value){

        # Add this bag
        $total += $value;

        # Recursive add child if present
        if(isset($bags[$childbag])) $total += $value * countBags($childbag, $bags);
    }
    return $total;
}

# Search every bag that contains the bags that contain the shiny gold bags.. whut?
foreach($gold_containers as $container => $w){
    findInBags($container, $bags, $colors);
}

# Get answer part 1
printf("Number of unique bag colors is: %s\n", count( array_merge( $colors, $gold_containers) ) );

# Get answer part 2
printf("Individual bags required inside my single shiny gold bag: %s\n", countBags('shiny gold', $bags) );

# Go cry in a corner and feel dumb as f*ck..
