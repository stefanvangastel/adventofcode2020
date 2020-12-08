#Imports
import re

# Read file lines into lines var (kudos @JetzeBF for nice oneliner :D)
lines = list(map(lambda line: line.strip('\r\n'), open("input.txt").readlines()))

# Beep beep computer!
def beepbeep(lines: list, mustComplete: bool = True):

    # Start a repl state object
    repl = {
        'cursor':       0,
        'accumulator':  0,
        'history':      []
    }

    # 4eva
    while True:

        # WHILE no duplicate hits in history (my coding-guitar gently weeps)
        if repl['cursor'] in repl['history']:

            # Part 2 must complete and return False, part 1 does not so return repl object
            if mustComplete:
                return False
            return repl

        # The END of the line, we made it! (part 2 only)!    
        if repl['cursor'] == len(lines):
            return repl

        # Add this 'step' to history
        repl['history'].append( repl['cursor'] ) 

        # Get operator and argument (yes regex cause we can!)
        (op, ar, i) = re.match(r'([a-z]{3})\s((\+|-)\d+)', lines[repl['cursor']]).groups()

        # Accumulate
        if op == "acc":
            repl['accumulator'] += int(ar)

        # Jump
        if op == "jmp":
            # Change cursor and move on
            repl['cursor'] += int(ar)
            continue

        # Moving one 
        repl['cursor'] += 1

#-----

# Part 1 anwser
repl = beepbeep(lines, False)
print("-------\nFinished booting part 1! Accumulator value: %s\n" % repl['accumulator'])

# Part 2 answer, create a custom program per line (so run all options)
for index in range(len(lines)):
    # Copy without reference
    custom = lines.copy()

    # Change line
    if custom[index].startswith('nop'):
        custom[index] = custom[index].replace('nop', 'jmp')
    elif custom[index].startswith('jmp'):
        custom[index] = custom[index].replace('jmp', 'nop')
   
    # Compute our custom program
    repl = beepbeep(custom)
    
    # If repl is returned, print it!
    if repl:
        print("-------\nFinished booting part 2! Accumulator value: %s\n" % repl['accumulator'])
        break


