# Read file lines into lines var
with open('input.txt', 'r') as inputFile: lines = inputFile.readlines() 

# Check lines (height)
height = len(lines)

#
# Define function for travel
#
def gimmeTrees( pattern: dict ):

    # Create a full map (matrix for this pattern)
    mapz = []

    # Duplicate initial map until line >= height * (travel right factor)
    for line in lines:
        
        # Expend until wide enough
        while( len(line) <= height * pattern['right'] ):
            line = line.strip() + line.strip()

        # Append line to mapz
        mapz.append(line)

    # We have the mapz, lets start our journey (0-index based)
    cursor = { 'line' : 0, 'index': 0 }

    # Counter
    count  = { 'open' : 0, 'trees': 0 }

    # Since we take 1 step down every time, we can move until line <= height (-1, 0 index based)
    while(cursor['line'] <= height - 1):

        # Get the char
        value = mapz[cursor['line']][cursor['index']]

        # Check space or tree
        if value == '.': count['open']  += 1
        if value == '#': count['trees'] += 1

        # Travel
        cursor['line']  += pattern['down']
        cursor['index'] += pattern['right']

    return count

### Answer
slopes = [
    {'right':3,'down':1}, # 3a
    {'right':1,'down':1},
    {'right':5,'down':1},
    {'right':7,'down':1},
    {'right':1,'down':2}
]

# Antwoord 3a
print("Antwoord 3a %s" % gimmeTrees( slopes[0] ) )

# Antwoord 3b
answer3b = 1
for slope in slopes:
    answer3b = answer3b * gimmeTrees( slope )['trees']

print("Antwoord 3b %s" %  answer3b )
