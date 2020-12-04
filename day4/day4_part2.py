# Imports
import re

# Read file lines into lines var
with open('input.txt', 'r') as inputFile: lines = inputFile.readlines() 

# Fields
requiredFields = {
    "byr": r"^(19[2-9][0-9]|200[0-2])$",
    "iyr": r"^(201[0-9]|2020)$",
    "eyr": r"^(202[0-9]|2030)$",
    "hgt": r"^((1[5-8][0-9]|19[0-3])cm)|^((59|6[0-9]|7[0-6])in)$",
    "hcl": r"^#[0-9a-f]{6}$",
    "ecl": r"^(amb|blu|brn|gry|grn|hzl|oth)$",
    "pid": r"^[0-9]{9}$"
   # "cid": "Country ID" # Optional field so who cares
}

# Vars
singleLine     = ""
passports      = {}
index          = 0
validPassports = []

# Rework the lines, append to current line and create single line until \n
for line in lines:

    # Append line if not just emptyline
    if line.strip() != "":
        singleLine += " " + line.strip()
    else:
        # Newline, so the current line is complete, use it!
        fields = singleLine.strip().split(' ')
        
        # Create new dict for the fields in this passport line
        passports[index] = {}

        # Process the fields, create k/v pairs
        for field in fields:

            # Split into kv pair
            (key,value) = field.split(':')

            # Ingore CID
            if key == "cid": continue

            # If value does not match expression, break
            expression = re.compile( requiredFields[key] )
            if expression.match(value) == None:
                break

            # Add value to passports if field is value
            passports[index][key] = value

        # Day 4 part 1, fields present:
        if all (key in passports[index].keys() for key in requiredFields.keys() ):
            # All required fields are present
            validPassports.append( passports[index] )

        # Next!
        singleLine = ""
        index+=1
    
# Answer
print("Total of %d passports, %d are valid" % (len(passports), len(validPassports)) )
