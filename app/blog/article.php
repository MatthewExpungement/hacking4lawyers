<?php

include '../sql.php';
header("X-XSS-Protection: 0");
if(isset($_POST['logout'])){
    unset($_COOKIE['username']);
    setcookie('username', '', time() - 3600);
}
include "../resources/header.html";

?>
  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>Attorney News!</h1>
      <p class="lead">You're dedicated place for all things law and news.</p>
 
    </div>
  </header>
  <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
        <h1 class="mt-5 mb-4">University of Hawaii Law School Offers Groundbreaking Cybersecurity Law Course Taught by Tech Attorney Matthew Stubenberg</h1>
      </div>
    </div>

    <div class="row">
  <div class="col-12 text-center">
    <img src="../resources/ProfilePic.jpg" alt="Description of the image" class="img-fluid mb-4">
  </div>
</div>

    <div class="row">
      <div class="col-12">
        <h5 class="mb-4"><strong>Honolulu, HI - September 11, 2023</strong></h5>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <p>The University of Hawaii William S. Richardson School of Law has made headlines by announcing a new, cutting-edge course on Cybersecurity Law. The class, to be taught by renowned tech attorney Matthew Stubenberg, aims to provide law students with an in-depth understanding of cybersecurity from both a legal and technical standpoint.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h2 class="mt-4 mb-3">Multifaceted Approach to Cybersecurity</h2>
        <p>"Most law schools are good at teaching the law but often ignore the technological underpinnings of how that law gets applied in the real world. In this rapidly changing landscape, it's imperative for new attorneys to have a working knowledge of both," said Stubenberg.</p>
      </div>
    </div>

    <!-- Other sections -->

    <div class="row">
      <div class="col-12">
        <h2 class="mt-4 mb-3">Course Highlights</h2>
        <ul>
          <li><strong>Hacking Laws:</strong> An in-depth analysis of the Computer Fraud and Abuse Act (CFAA) and other laws regulating hacking activities.</li>
          <li><strong>Data Privacy Legislation:</strong> A comprehensive study of laws like GDPR and CCPA that govern data protection and privacy.</li>
          <li><strong>Hands-On Labs:</strong> Under controlled conditions, students will engage in activities like ethical hacking to understand the vulnerabilities and legal ramifications involved.</li>
          <li><strong>Encryption and Security Protocols:</strong> Learning the basics of cryptographic methods and their legal implications.</li>
          <li><strong>SQL and SQL Injection:</strong> Practical lessons that teach students how to identify and prevent SQL injection attacks, which are commonly used to exploit databases.</li>
          <li><strong>Password Cracking:</strong> Understanding the techniques used to crack passwords and the laws that make such actions illegal.</li>
        </ul>
      </div>
    </div>

    <!-- More sections -->

    <div class="row">
      <div class="col-12">
        <h2 class="mt-4 mb-3">The Man Behind the Course</h2>
        <p>Matthew Stubenberg, a tech-savvy attorney with years of experience in the intersection of law and technology, brings a unique skill set to the course. He has previously developed legal tech solutions to enhance access to justice and has been an advocate for incorporating technology into legal education.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h2 class="mt-4 mb-3">Reception and Future Plans</h2>
        <p>"The intersection of technology and law is only going to become more crucial. This course is just the beginning," said Dean Merissa Sakai of the University of Hawaii William S. Richardson School of Law.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <p class="mt-5">For more information about the course, contact the William S. Richardson School of Law at the University of Hawaii.</p>
      </div>
    </div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login Required</h5>
        <!-- Removed close button -->
      </div>
      <div class="modal-body">
        You need to login to read further.
      </div>
      <div class="modal-footer">
        <!-- Removed close button here as well -->
        <button type="button" class="btn btn-primary" onclick="window.location.href='index.php';">Login</button>
      </div>
    </div>
  </div>
</div>


<?php
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $blockedUserAgent = "Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/W.X.Y.Z Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)";
    
    if ($userAgent !== $blockedUserAgent && !isset($_COOKIE["username"])) {
  ?>
    <!-- Custom JS -->
    <script>
      // Display the modal after 3 seconds
      setTimeout(function() {
        $('#loginModal').modal('show');
      }, 3000);

      // Prevent scrolling when modal is open
      $('#loginModal').on('show.bs.modal', function () {
        $('body').css('overflow', 'hidden');
      });

      $('#loginModal').on('hidden.bs.modal', function () {
        $('body').css('overflow', 'auto');
      });
    </script>
  <?php
    }
  ?>
  <?php
    require "../resources/footer.html";
    ?>