# m=0 - use the MD5 hashing algorithm to reverse hashes.
# a=0 - use Straight or Dictionary attack. Just compare a list of words to the hashes.
# o   - output file
# force - something to do with performance
# potfile-disable - prevent hashcat from saving previously reversed hashes, so it outputs everything. 
# secrets.md5 - the file of hashes
# wordlist.txt - the words to use for guessing passwords.
hashcat \
    -m 0 \
    -a 0 \
    -o ./reversed.txt \
    --force \
    --potfile-disable \
    secrets.md5 \
    wordlist.txt