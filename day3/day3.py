# Read file lines into lines var
with open('input.txt', 'r') as inputFile: lines = inputFile.readlines() 

# Check lines (height)
height = len(lines)

# Create a full map (matrix)
mapz = []

# Duplicate pattern until >= height * 3 (travel right factor is 3)
for line in lines:
    
    # Remove newlines
    line = line.strip()

    # Append until square
    while(len(line) <= height * 3):
        line = line + line

    # Append line to mapz
    mapz.append(line)

# We have the mapz, lets start our journey (0-index based)
cursor = {
    'line' : 0,
    'index': 0
}

# Counter
count = {
    'open' : 0,
    'trees': 0
}

# Since we take 1 step down every time, we can move until line <= height (-1, 0 index based)
while(cursor['line'] <= height - 1):

    # Get the char
    value = mapz[cursor['line']][cursor['index']]

    if value == '.':
        count['open']  += 1
    if value == '#':
        count['trees'] += 1

    # Travel
    cursor['line']  += 1
    cursor['index'] += 3

print(count)