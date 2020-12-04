# Read file lines into lines var
with open('input.txt', 'r') as inputFile: lines = inputFile.readlines() 

# Fields
requiredFields = {
    "byr": "Birth Year",
    "iyr": "Issue Year",
    "eyr": "Expiration Year",
    "hgt": "Height",
    "hcl": "Hair Color",
    "ecl": "Eye Color",
    "pid": "Passport ID"
   # "cid": "Country ID" # Optional field so who cares
}

# Vars
singleLine = ""
passports  = {}
index      = 0

validPassports = []

# Rework the lines, append to current line and create 
for line in lines:

    # Append line if not just emptyline
    if line.strip() != "":
        singleLine += " " + line.strip()
    else:
        # Newline, so the currentline is complete, use it!
        fields = singleLine.strip().split(' ')
        
        # Create new dict for this line
        passports[index] = {}

        # Process the fields, create k/v pairs
        for field in fields:
            (key,value) = field.split(':')
            passports[index][key] = value

        # Day 4 part 1, fields present:
        if all (key in passports[index].keys() for key in requiredFields.keys() ):
            # Alle fields zitten er in!
            validPassports.append( passports[index] )

        # Next!
        singleLine = ""
        index+=1
    
# 
print( len(passports), len(validPassports) )
