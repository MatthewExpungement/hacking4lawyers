<?php 
    require('../resources/header.html');
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Hacking for Lawyers</a>
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="https://github.com/natev/itcpassworddemo">Password Demo Code</a>
        </li>
      </ul>
    </div>
</nav>

  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1> Encryption and Password Security </h1>
    </div>
  </header>

  <!-- Symmetric Key Encryption -->
  <section id="plaintextpasswords">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2> Symmetric Key Encryption</h2>
                <p>Symmetric key encryption is the use of a single key to both encrypt and decrypt data. </p>
                <p>This uses AES 256 Encryption</p> 
                <label for="symmetric_key_input">Enter AES Key:</label>
                <input type="text" id="symmetric_key_input" maxlength="32">
                <p>Binary Representation:</p>
                <textarea disabled rows="8" cols="50" id="symmetric_key_binary_Output"></textarea>
                
                <p>Current Character Count: <span id="symmetric_key_characterCount">0</span></p>

                <!-- <p>Generate a public and private key. Public key is used for encryption and the private key is used for decryption.</p>
                <br>
                <button id="generate_symmetric_key" type="submit" class="btn btn-primary">Generate 256 Bit Symmetric Key</button> -->
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
              <h2> Encrypt </h2>
              <form id='symmetric_key_form_encrypt'>
                  <label for "symmetric_key_encrypt">Key:</label><br>
                  <input id="symmetric_key_encrypt" type="text" name="symmetric_key" class="form-control">
                  <label for "encrypt_text">Text to Encrypt:</label><br>
                  <input id="encrypt_text" type="text" name="encrypt_text" class="form-control">

                  <br><br>
                  <button id="symmetric_key_button_encrypt" type="submit" class="btn btn-primary">Encrypt</button>
              </form>
                      <!-- Bootstrap Alert for Validation Errors -->
        <div class="alert alert-danger mt-3" id="validationAlert" style="display: none;">
            Please enter a 32-character key and provide text to encrypt.
        </div>
              <br><br>
              <!-- <p>Generated Key</p>
              <textarea rows="10" cols="50" id='generated_key'></textarea> -->
              <p>Encrypted Text</p>
              <textarea rows="10" cols="50" id='encrypted_text'></textarea>
              
            </div>
            <div class="col-lg-6 mx-auto">
              <h2> Decrypt </h2>
              <form id='symmetric_key_form_decrypt'>
                  <label for "symmetric_key_decrypt">Key:</label><br>
                  <input id="symmetric_key_decrypt" type="text" name="symmetric_key" class="form-control">
                  <label for "encrypt_text">Text to Decrypt:</label><br>
                  <input id="symmetric_decrypt_text" type="text" name="encrypt_text" class="form-control">

                  <br><br>
                  <button id="symmetric_key_button_decrypt" type="submit" class="btn btn-primary">Decrypt</button>
              </form>
              <br><br>
              <p>Decrypted Text</p>
              <textarea rows="10" cols="50" id='decrypted_text'></textarea>
            </div>
        </div>
    </div>
  </section>

  <!-- Public Private Key Encryption -->
  <section id="plaintextpasswords" class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Asymmetric Encryption</h2>
                <p>Generate a public and private key. Public key is used for encryption and the private key is used for decryption.</p>
                <p>The encryption algorithm used is RSA 4096.</p>
                <br>
                <button id="generate_public_private_key_button" type="submit" class="btn btn-primary">Generate Public/Private Keys</button>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-lg-6 mx-auto">

            </div>
            <div class="col-lg-6 mx-auto">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
              <h2> Encrypt </h2>
              <form id='public_private_key_form_encrypt'>
                  <label for "public_key_response">Public Key:</label><br>
                  <textarea rows="10" cols="50" id='public_key_response' name='public_key_response'></textarea>
                  <br>
                  <label for "public_key_number">Public Key:</label><br>
                  <textarea rows="3" cols="50" id='public_key_number' name='public_key_number'></textarea>
                  <br>
                  <label for "public_key_encrypt">Text to Encrypt:</label><br>
                  <input id="public_key_encrypt" type="text" name="public_key_encrypt" class="form-control">

                  <br><br>
                  <button id="public_private_key_button_encrypt" type="submit" class="btn btn-primary">Encrypt</button>
              </form>
              <br><br>
              <p>Encrypted Text</p>
              <textarea rows="10" cols="50" id='public_private_encrypted_text'></textarea>
            </div>
            <div class="col-lg-6 mx-auto">
              <h2> Decrypt </h2>
              <form id='public_private_key_form_decrypt'>
                  <label for "private_key_response">Private Key:</label><br>
                  <textarea rows="10" cols="50" id='private_key_response' name='private_key_response'></textarea>
                  <br>
                  <label for "prime_number1">Prime Number 1:</label><br>
                  <textarea rows="3" cols="50" id='prime_number1' name='prime_number1'></textarea>
                  <br>
                  <label for "prime_number2">Prime Number 2:</label><br>
                  <textarea rows="3" cols="50" id='prime_number2' name='prime_number2'></textarea>
                  <br>
                  <label for "private_decrypt_text">Text to Decrypt:</label><br>
                  <input id="private_decrypt_text" type="text" name="private_decrypt_text" class="form-control">

                  <br><br>
                  <button id="public_private_key_button_decrypt" type="submit" class="btn btn-primary">Decrypt</button>
              </form>
              <br><br>
              <p>Decrypted Text</p>
              <textarea rows="10" cols="50" id='public_private_decrypted_text'></textarea>
            </div>
        </div>
    </div>
  </section>

  <!-- Hashing -->
  <section id="plaintextpasswords">
    <div class="container">
        <div class="row">
        <div class="col-lg-3">
</div>
            <div class="col-lg-6 text-center">
                <h2> Hashing</h2>
                <p>Encrypts a value one way. This value cannot be decrypted. This is useful for password checking.</p>
                <p>Salting allows you to add a fixed word to the end of a piece of text before it's hashed. This helps prevent lookup against previously hashed values.</p>
                 <br>
                <form id='hash_form'>
                <select name="hashing_algo" id='hash_algo_select'>
                    <option value="md5">MD5 128</option>
                    <option value="sha3-256">SHA3 256</option>
                    <option value="sha3-384">SHA3 384</option>
                    <option value="sha3-512">SHA3 512</option>
                </select>
                  <label for "hash_text_to_encrypt">Text to Encrypt:</label><br>
                  <input id="hash_text_to_encrypt" type="text" name="hash_text_to_encrypt" class="form-control">
                  <br>
                  <label for "hash_salt">Salt (optional):</label><br>
                  <input id="hash_salt" type="text" name="hash_salt" class="form-control">

                  <br><br>
                  <button id="hash_button" type="submit" class="btn btn-primary">Hash</button>
              </form>
                <br><br>
                <p>Binary Value (Should be the number of bits it is encrypted.)</p>
                <textarea disabled rows="3" cols="50" id='hash_encrypted_binary'></textarea>
                <p>*Value is hexidecimal encoded. 4 bits per hexidecimal value.</p>
                <textarea disabled rows="4" cols="50" id='hash_encrypted'></textarea>
            </div>
            <div class="col-lg-3">
</div>
        </div>
        <br><br>
      </div>
  </section>



<!-- Information about how to break a hash -->
  <section id="hashattacks" class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>Attacking hashes</h2>
          <ul>
            <li> 
                Brute Force: Every Combination of letters, numbers, and symbols.
            </li> 
            <li> 
                Dictionary / Wordlist: Using a list of common words and passwords from past hacks.
            </li>
            <li> 
                Mask: List of rules that people commonly make when making passwords like changing letters to numbers and adding a number or symbol at the end.. (e->3,O->0,s->$)
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <script>
    //Symetric Key Encrypt
$(document).ready(function(){
  $("#symmetric_key_button_encrypt").click(function(){
    $("#symmetric_key_form_encrypt").submit(function(e){
                e.preventDefault();
            });
    var symmetricKey = $("#symmetric_key_encrypt").val();
    var encryptText = $("#encrypt_text").val();

      // Perform validation
      if (symmetricKey.length !== 32 || encryptText.trim() === '') {
          // Display a Bootstrap alert for validation errors
          $('#validationAlert').show();
          return; // Exit the function without making the AJAX request
      }

      // If validation passes, hide the alert
      $('#validationAlert').hide();

    $.ajax({
      url: 'password_backend.php',
      type: 'post',
      data: { 'symmetricKey': symmetricKey, 'encryptText': encryptText,'service':'symmetric-key-encrypt' },
      dataType: 'json', // Specify that the expected response is JSON
      success: function(response) {
        // you can do something with the response here
        console.log(response);
        console.log(response.ciphertext);
        console.log(response.aes_key_bits);
        $("#symmetric_decrypt_text").val(response.ciphertext);

        $("#encrypted_text").text(response.ciphertext);
       // $("#generated_key").text(response.aes_key_bits);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
  $('#symmetric_key_input').on('input', function() {
                // Get the input value
                var inputValue = $(this).val();

                // Convert each character to binary
                var binaryResult = '';
                for (var i = 0; i < inputValue.length; i++) {
                    var charCode = inputValue.charCodeAt(i);
                    var binaryChar = charCode.toString(2).padStart(8, '0'); // Pad to 8 bits
                    binaryResult += binaryChar;
                }

                // Update the <span> with the binary representation
                $('#symmetric_key_binary_Output').text(binaryResult);
                $("#symmetric_key_encrypt").val(inputValue);
                $("#symmetric_key_decrypt").val(inputValue);
                $('#symmetric_key_characterCount').text(binaryResult.length);
            });
});
</script>

<script>
  //Symmetric Key Decrypt
$(document).ready(function(){
  $("#symmetric_key_button_decrypt").click(function(){
    $("#symmetric_key_form_decrypt").submit(function(e){
          e.preventDefault();
      });
    var symmetricKey = $("#symmetric_key_decrypt").val();
    var decryptText = $("#symmetric_decrypt_text").val();
    console.log(symmetricKey + decryptText);
    $.ajax({
      url: 'password_backend.php',
      type: 'post',
      data: { 'symmetricKey': symmetricKey, 'decryptText': decryptText, 'service':'symmetric-key-decrypt'},
      success: function(response) {
        // you can do something with the response here
        console.log(response);
        $("#decrypted_text").text(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
});
</script>

<script>
  //Generate Public Private Key
    $(document).ready(function(){
        $("#generate_public_private_key_button").click(function(){
            $.ajax({
                type: 'POST',
                url: 'password_backend.php',
                data: { service: 'generate-public-private-key' },
                dataType: 'json',
                success: function(response){
                  console.log(response);
                  $('#private_key_response').val(response.private);
                  $('#public_key_response').val(response.public);
                  var converted_prime_number1 = BigInt(`0x${response.prime_number1}`);
                  var converted_prime_number2 = BigInt(`0x${response.prime_number2}`);

                  console.log(response.prime_number1);
                  console.log(response.prime_number2);
                  $("#prime_number1").val(converted_prime_number1.toString());
                  $("#prime_number2").val(converted_prime_number2.toString());
                  var public_key_number = converted_prime_number1 * converted_prime_number1;
                  console.log("Public Key Number: " + public_key_number);
                  $("#public_key_number").val(public_key_number.toString());

                },
                error: function(request, status, error){
                    console.error("AJAX request failed: " + status + ", Error: " + error);
                }
            });
        });
        // $("#generate_symmetric_key").click(function(){
        //     $.ajax({
        //         type: 'POST',
        //         url: 'password_backend.php',
        //         data: { service: 'generate_symmetric_key' },
        //         success: function(response){
        //             $('#private_key_response').val(response.private);
        //             $('#public_key_response').val(response.public);
        //         },
        //         error: function(request, status, error){
        //             console.error("AJAX request failed: " + status + ", Error: " + error);
        //         }
        //     });
        // });
    });
</script>
<script>
  //Public Key Encryption
$(document).ready(function(){
  $("#public_private_key_button_encrypt").click(function(){
    $("#public_private_key_form_encrypt").submit(function(e){
          e.preventDefault();
      });
        $.ajax({
            type: 'POST',
            url: 'password_backend.php',
            data: { 
                service: 'encrypt-public-key',
                publicKey: $('#public_key_response').val(),
                textToEncrypt: $('#public_key_encrypt').val()
            },
            success: function(response){
                // Populate the 'public_private_encrypted_text' textarea with the response
                $('#public_private_encrypted_text').val(response);
            },
            error: function(request, status, error){
                console.error("AJAX request failed: " + status + ", Error: " + error);
            }
        });
    });
  });

</script>
<script>
  //Private Key Decryption
$(document).ready(function(){
  $("#public_private_key_button_decrypt").click(function(){
    $("#public_private_key_form_decrypt").submit(function(e){
          e.preventDefault();
      });
        $.ajax({
            type: 'POST',
            url: 'password_backend.php',
            data: { 
                service: 'decrypt-public-key',
                privateKey: $('#private_key_response').val(),
                textToDecrypt: $('#private_decrypt_text').val()
            },
            success: function(response){
                // Populate the 'public_private_encrypted_text' textarea with the response
                $('#public_private_decrypted_text').val(response);
            },
            error: function(request, status, error){
                console.error("AJAX request failed: " + status + ", Error: " + error);
            }
        });
    });
  });

</script>
<script>
  //Hashing

$(document).ready(function(){
  $("#hash_button").click(function(){
    $("#hash_form").submit(function(e){
          e.preventDefault();
      });
        $.ajax({
            type: 'POST',
            url: 'password_backend.php',
            data: { 
                service: 'hash',
                textToEncrypt: $('#hash_text_to_encrypt').val(),
                hash_salt: $('#hash_salt').val(),
                hash_algo: $("#hash_algo_select").val()
            },
            success: function(response){
                // Populate the 'public_private_encrypted_text' textarea with the response
                console.log("Success " + response);
                $('#hash_encrypted').text(response);
                var binaryResult = hexToBinary(response);
                $('#hash_encrypted_binary').text(binaryResult);
                
                console.log(parseInt(response, 16).toString(2).padStart(response.length * 4, '0'));
            },
            error: function(request, status, error){
                console.error("AJAX request failed: " + status + ", Error: " + error);
            }
        });
    });
  });
  function hexToBinary(hex) {
    // Remove leading "0x" if present
    hex = hex.replace(/^0x/, '');

    // Convert each hex digit to a 4-bit binary representation
    return hex.split('').map(char => {
        // Parse the hex character to a number and convert to binary
        const binary = parseInt(char, 16).toString(2);
        // Pad with leading zeros to ensure each digit is 4 bits
        return binary.padStart(4, '0');
    }).join('');
  }
</script>