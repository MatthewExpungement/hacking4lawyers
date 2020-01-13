# Demo of how password decryption works with Hashcat, for instructing users about why they need good passwords.


## Instructions

### Encrypting passwords

`passwords.txt` has a list of passwords that people might use. (well, hopefully not, because they're extra weak for demonstration purposes)

Use `hash.sh` to encrypt passwords with the (very insecure, so only for demo purposes) md5 algorithm. 

```./hash.sh```

The new `secrets.md5` file is the hashed version of the passwords. 

### Decrypting them

Run `./dehash.sh`. 

This compares the hashes of the words in `wordlist.txt` to the hashes in `secrets.md5`. 

If `hashcat` can find a word in `wordlist.txt` with a hash that matches one in `secrets.md5`, it knows that hash came from the word in the wordlist.

