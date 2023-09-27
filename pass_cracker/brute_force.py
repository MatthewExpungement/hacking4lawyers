import itertools
import time
import hashlib

#Shows a brute force attack to discover the password used to create an MD5 hash. 
# Check out brute force time on a proper computer at https://www.proxynova.com/tools/brute-force-calculator/.
def guess_password(real_hash):
    charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
    attempts = 0
    start = time.time()

    for password_length in range(1, 9):  # only do lengths of 1 through 8
        for guess in itertools.product(charset, repeat=password_length):
            attempts += 1
            guess = ''.join(guess)
            # Compute the MD5 hash of the guessed password
            guess_hash = hashlib.md5(guess.encode()).hexdigest()
            if guess_hash == real_hash:
                end = time.time()
                return 'password is {}. found in {:,} attempts after {:.2f} seconds.'.format(guess, attempts, end-start)
    
    end = time.time()
    return 'password not found after {:,} attempts and {:.2f} seconds.'.format(attempts, end-start)

# example usage
print(guess_password('0da6af03bf924f21c22be75217246dea')) 