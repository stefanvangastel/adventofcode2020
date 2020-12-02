# Imports
import re

# Read file lines into lines var
with open('input.txt', 'r') as inputFile: lines = inputFile.readlines() 

# Compile regex to match components per line. Use groups, check out the design doc: https://regex101.com/r/54OkcH/1
expression = re.compile(r'(\d+)-(\d+)\s+([a-zA-Z]+):\s+([a-zA-Z]+)')

# Part 1
def part1(lines):
        
    # Init counter
    correctPwds = 0    

    # loop
    for line in lines:

        # Match regex
        matches = expression.match(line)

        # Create var's from matching groups
        (min,max,char,pwd) = matches.groups()

        #occurences of char in pwd
        occ = pwd.count(char)

        #Check pwds for rules
        if occ >= int(min) and occ <= int(max):
            correctPwds += 1

    # Return correctPwds
    return correctPwds


# Part 2
def part2(lines):

    # Init counter
    correctPwds = 0

    # Compile regex to match components per line. Use groups, check out the design doc: https://regex101.com/r/54OkcH/1
    expression = re.compile(r'(\d+)-(\d+)\s+([a-zA-Z]+):\s+([a-zA-Z]+)')

    # loop
    for line in lines:

        # Match regex
        matches = expression.match(line)

        # Create var's from matching groups
        (pos1,pos2,char,pwd) = matches.groups()

        # Normalize to 0 index
        pos1 = int(pos1) - 1
        pos2 = int(pos2) - 1

        # Check if either position has char but not both! 
        if (pwd[pos1] == char and pwd[pos2] != char) or (pwd[pos1] != char and pwd[pos2] == char):
           
           # Increment 
           correctPwds += 1

    # Return answer
    return correctPwds

##########################

# Display answer part 1
print("Part 1: %d correct passwords" % part1(lines) )

# Display answer part 2
print("Part 2: %d correct passwords" % part2(lines) )