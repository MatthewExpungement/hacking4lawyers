import hashlib
import time

# Function to convert a line to an MD5 hash
def to_md5(line):
    return hashlib.md5(line.encode()).hexdigest()

# Record the start time
start_time = time.time()

# Open and read the file
with open('100k-most-used-passwords-NCSC.txt', 'r',encoding='utf-8') as f:
    dictionary = f.readlines()

with open('stolen_hashed_passwords.txt', 'r') as f:
    stolen_passwords = f.readlines()

# Convert each line to an MD5 hash and print it
for word in dictionary:
    word = word.strip()  # Remove newline characters
    md5_hashed_word = to_md5(word)
    for stolen_password in stolen_passwords:
        stolen_password = stolen_password.strip()
        #print("Checking",md5_hashed_word,"to",stolen_password)
        if(md5_hashed_word == stolen_password):
            print("Password Found!",stolen_password,"is",word)

# Record the end time
end_time = time.time()

# Calculate and print the total running time
total_calculations = len(dictionary) * len(stolen_passwords)
total_time = end_time - start_time
print(f"The program ran for {total_time} seconds and ran {total_calculations:,} comparisons.")