<?php


function validate_and_expand_key($userKey) {
    // Check if the user-provided key is empty or shorter than 256 bits (32 bytes)
    if (empty($userKey) || strlen($userKey) < 32) {
        // Generate a random 256-bit key if the user key is invalid or too short
        $generatedKey = openssl_random_pseudo_bytes(32);
        return $generatedKey;
    } else if (strlen($userKey) == 32) {
        // The user-provided key is exactly 256 bits, no need to modify it
        return $userKey;
    } else {
        // The user-provided key is longer than 256 bits, truncate it to 256 bits
        return substr($userKey, 0, 32);
    }
}
// Encrypt function
function symmetric_encrypt($plainText, $key, $cipher) {
    // Get the required initialization vector length for the chosen cipher method
    $ivlen = openssl_cipher_iv_length($cipher);

    // Generate an initialization vector (IV) from a random source
    $iv = openssl_random_pseudo_bytes($ivlen);

    // Encrypt the plain text using the given key and IV
    $ciphertext_raw = openssl_encrypt($plainText, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);

    // Compute a keyed hash of the raw ciphertext using HMAC with SHA-256
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);

    // Concatenate the IV, HMAC, and raw ciphertext and then base64 encode them
    $ciphertext = base64_encode($iv.$hmac.$ciphertext_raw);
    // Return the final ciphertext

    // Convert the AES key to bits
    $aesKeyBits = '';
    foreach (str_split($key) as $byte) {
        $aesKeyBits .= str_pad(decbin(ord($byte)), 8, '0', STR_PAD_LEFT);
    }

    // Return the final ciphertext and AES key (in bits)
    return array(
        'ciphertext' => $ciphertext,
        'aes_key_bits' => $aesKeyBits
    );
}

// Decrypt function
function symmetric_decrypt($ciphertext, $key, $cipher) {
    // Decode the base64 encoded ciphertext
    $c = base64_decode($ciphertext);
    // Get the required initialization vector length for the chosen cipher method
    $ivlen = openssl_cipher_iv_length($cipher);
    // Extract the IV from the concatenated string
    $iv = substr($c, 0, $ivlen);
    // Extract the HMAC from the concatenated string
    $hmac = substr($c, $ivlen, $sha2len=32);
    // Extract the raw ciphertext from the concatenated string
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    // Decrypt the raw ciphertext using the given key and IV
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    // Recompute the HMAC on the raw ciphertext for verification
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    // Verify that the recomputed HMAC matches the extracted HMAC
    if (hash_equals($hmac, $calcmac)) {
        // If the verification is successful, return the original plaintext
        return $original_plaintext;
    }
    // If verification fails, nothing is returned, implicitly returning NULL
}
function generateKeyPair() {
    // Configuration settings for the key
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $privateKey = openssl_pkey_new($config);
    // After generating the private key

    $details = openssl_pkey_get_details($privateKey);
    // $details will have an array of key details.
    $p_hex = bin2hex($details['rsa']['p']);  // Convert binary data to hexadecimal
    $q_hex = bin2hex($details['rsa']['q']);
    
    // echo "Prime p (hex): " . $p_hex . "\n";
    // echo "Prime q (hex): " . $q_hex . "\n";
    // Extract the private key from the pair
    openssl_pkey_export($privateKey, $privKey);

    // Extract the public key from the pair
    $a_key = openssl_pkey_get_details($privateKey);
    $pubKey = $a_key["key"];

    return array(
        "private" => $privKey,
        "public" => $pubKey,
        "prime_number1" => $p_hex,
        "prime_number2" => $q_hex
    );
}
function encryptWithPublicKey($publicKey, $textToEncrypt) {
    // Extract public key from the key pair
    $pubKeyResource = openssl_pkey_get_public($publicKey);

    // Encrypt the data with public key
    openssl_public_encrypt($textToEncrypt, $encryptedText, $pubKeyResource);

    // Return the encrypted text in base64 format
    return base64_encode($encryptedText);
}
function decryptWithPrivateKey($privateKey, $encryptedText) {
    // Extract the private key from the key pair
    $privKeyResource = openssl_pkey_get_private($privateKey);

    // Decode the encrypted data before decrypting
    $encryptedText = base64_decode($encryptedText);

    // Decrypt the data with the private key
    openssl_private_decrypt($encryptedText, $decryptedText, $privKeyResource);

    // Return the decrypted text
    return $decryptedText;
}

function generateHash($string, $salt,$hashing_algorithm) {
    // Concatenate the string and the salt
    $combinedString = $string . $salt;

    // Generate the md5 hash of the combined string
    //Change md5 to shat256 to change the hashing algorithm.
    //https://www.php.net/manual/en/function.hash-algos.php
    $hash = hash($hashing_algorithm,$combinedString);

    // Return the hash
    return $hash;
}

// $_SERVER["REQUEST_METHOD"] = "POST";
// $_POST['service'] = 'generate-public-private-key';
// $_POST['symmetricKey'] = 'blabla';
// $_POST['encryptText'] = 'bla bla';
// $_POST['decryptText'] = '4bWE4ir6bU1hVMfjWtGBse8oNfMFtChM3AeAapyRy1mkSwzL6XA2MeykHmFdaaD2FOokyJR/GcoLQY8doSd5QQ==';
// Define the cipher method to be used, in this case, AES-256-CBC
$symmetic_cipher = "AES-256-CBC";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists('service',$_POST)){
        if($_POST['service'] == 'generate_symmetric_key'){
            return random_bytes(32);
        }
        if($_POST['service'] == 'symmetric-key-encrypt'){
            $plaintText = $_POST['encryptText'];
            $symmetricKey = $_POST['symmetricKey'];
            $ciphertext_and_key = symmetric_encrypt($plaintText,$symmetricKey, $symmetic_cipher );
            #print_r($ciphertext_and_key);
            echo json_encode($ciphertext_and_key);
            //echo $ciphertext;
        }
        elseif($_POST['service'] == 'symmetric-key-decrypt'){
            $symmetricKey = $_POST['symmetricKey'];
            $encryptedText = $_POST['decryptText'];
            //$decryptedtext = Encryption::decrypt($encryptText,$symmetricKey);
            $decryptedtext = symmetric_decrypt($encryptedText,$symmetricKey, $symmetic_cipher);
            echo $decryptedtext;
        }
        elseif($_POST['service'] == 'generate-public-private-key'){
            $keys = generateKeyPair();
            $jsonKeys = json_encode($keys);
            echo $jsonKeys;
        }
        elseif($_POST['service'] == 'encrypt-public-key'){
            $publicKey = $_POST['publicKey'];
            $textToEncrypt = $_POST['textToEncrypt'];
            $encrypted_text = encryptWithPublicKey($publicKey, $textToEncrypt);
            echo $encrypted_text;
        }
        elseif($_POST['service'] == 'decrypt-public-key'){
            $privateKey = $_POST['privateKey'];
            $textToDecrypt = $_POST['textToDecrypt'];
            $decryptedText = decryptWithPrivateKey($privateKey, $textToDecrypt);
            echo $decryptedText;
        }
        elseif($_POST['service'] == 'hash'){
            $hash_salt = $_POST['hash_salt'];
            $textToEncrypt = $_POST['textToEncrypt'];
            $hashing_algorithm = $_POST['hash_algo'];
            $hashed_text = generateHash($textToEncrypt, $hash_salt,$hashing_algorithm);
            echo $hashed_text;
        }
    }

}

?>