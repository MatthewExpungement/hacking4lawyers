cat passwords.txt | while read line
do
echo -n $line | md5sum | tr -d " -" >> secrets.md5
done
echo "" >> secrets.md5