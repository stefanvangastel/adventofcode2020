# Read file lines into numbers var
with open('input.txt', 'r') as inputFile: numbers = inputFile.readlines() 

# Poor man's matrix som by double for looping #technicaldebt101
try:
    for number_a in numbers:
        for number_b in numbers:
            for number_c in numbers:

                # Cast to int
                number_a = int(number_a)
                number_b = int(number_b)
                number_c = int(number_c)

                # som it up
                som = number_a + number_b + number_c

                # Check correct sum
                if som == 2020:

                    # Display answer
                    print("%d + %d + %d is %d, (%d * %d * %d is %d)" % (number_a, number_b, number_c, som, number_a, number_b, number_c, (number_a * number_b * number_c) ) )

                    # Answer found, breaky breaky! Use the StopIteration solution
                    raise StopIteration

except StopIteration: pass