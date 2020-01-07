<?php 
    require('header.html');
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
      <h1> Password security </h1>
    </div>
  </header>

  <section id="plaintextpasswords">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2> Never store passwords as plain text </h2>
            </div>
        </div>
    </div>
  </section>

  <section id="hashfunctions" class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>Hash functions</h2>
          <p class="lead">MyPassword1234</p>
          <p> becomes ... 
          <p class="lead">dbeb1c353a8a988d19460a0c30b5aa08</p>
        </div>
      </div>
    </div>
  </section>

  <section id="hashattacks">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>Attacking hashes</h2>
          <ul>
            <li> 
                Brute force
            </li> 
            <li> 
                Dictionary / Wordlist 
            </li>
            <li> 
                Mask
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section id="passwordsfile" class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2>Passwords.txt</h2>
          <pre> 
              e99a18c428cb38d5f260853678922e03
              f806fc5a2a0d5ba2471600758452799c 
              8afa847f50a716e64932d995c8e7435a 
              f25a2fc72690b780b2a14e140ef6a9e0 
              b0b129991a71c1ba6e8b6a280c5fbed2 
              580e73ac0f34ac8dfd33995940b94f87 
              d41d8cd98f00b204e9800998ecf8427e 
          </pre>
        </div>
      </div>
    </div>
  </section>

  <section id="wordlist">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-8 mx-auto">
              <h2> Wordlist </h2>
              <pre> 
                  abc123 
                  rockyou 
                  princess 
                  iloveyou 
                  a6_123 
                  *7¡Vamos! 
                  mydogXXX432! 
            </div>
        </div>
    </div>
  </section>

  <section id="hashcatCommand" class="bg-light">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 mx-auto">
                  <h2> Hashcat </h2>
                  <pre> 
                    hashcat \
                        -m 0 \
                        -a 0 \
                        -o ./reversed.txt \
                        --force \
                        --potfile-disable \
                        secrets.md5 \
                    </pre>
              </div>
          </div>
      </div>
  </section>

  <section id="hashcatCommand" >
      <div class="container">
          <div class="row">
              <div class="col-lg-8 mx-auto">
                  <h2> Reversed.txt </h2>
                  <pre> 
b0b129991a71c1ba6e8b6a280c5fbed2:a6_123
8afa847f50a716e64932d995c8e7435a:princess
e99a18c428cb38d5f260853678922e03:abc123
580e73ac0f34ac8dfd33995940b94f87:*7¡Vamos!
f806fc5a2a0d5ba2471600758452799c:rockyou
f25a2fc72690b780b2a14e140ef6a9e0:iloveyou
                    </pre>
              </div>
          </div>
      </div>
  </section>

