import itertools
import time
import hashlib

#Brute Force with Rules
#Changes e to 3, o to 0, i to 1, a to @, and s to $
#Adds a single digit to the end of a password
#Adds a single symbol to the end of a password

def guess_password(real_hash):
    symbols = '!@#$%^&*()-+~'
    leet_mapping = {'e': '3', 'o': '0', 'i': '1', 'a': '@','s':'$'}
    attempts = 0
    start = time.time()

    # Open and read the file
    with open('100k-most-used-passwords-NCSC.txt', 'r',encoding='utf-8') as f:
        dictionary = f.readlines()

    # First try just dictionary words and simple leetspeak substitutions
    for word in dictionary:
        word = word.strip()
        for replacements in itertools.product(*((c, leet_mapping.get(c, c)) for c in word)):
            attempts += 1
            guess = ''.join(replacements)
            guess_hash = hashlib.md5(guess.encode()).hexdigest()
            if guess_hash == real_hash:
                end = time.time()
                return 'password is {}. found in {:,} attempts after {:.2f} seconds.'.format(guess, attempts, end-start)

            # Try dictionary word followed by a single digit
            for number in range(10):  # 10 for digits 0 through 9
                attempts += 1
                guess_with_number = guess + str(number)
                #print(guess)
                guess_hash = hashlib.md5(guess_with_number.encode()).hexdigest()
                if guess_hash == real_hash:
                    end = time.time()
                    return 'password is {}. found in {:,} attempts after {:.2f} seconds.'.format(guess_with_number, attempts, end-start)
            
            # Try dictionary word followed by a single symbol
            for symbol in symbols:  # 10 for digits 0 through 9
                attempts += 1
                guess_with_symbol = guess + str(symbol)
                #print(guess)
                guess_hash = hashlib.md5(guess_with_symbol.encode()).hexdigest()
                if guess_hash == real_hash:
                    end = time.time()
                    return 'password is {}. found in {:,} attempts after {:.2f} seconds.'.format(guess_with_symbol, attempts, end-start)
    
    end = time.time()
    return 'password not found after {:,} attempts and {:.2f} seconds.'.format(attempts, end-start)

# example usage
print(guess_password('017065327a943b87a1700a3b1e6b6336'))  # MD5 hash 