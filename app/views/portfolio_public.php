<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PortyPortfolio</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Poppins&family=Questrial&display=swap"
      rel="stylesheet"
    />

    <!-- boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <style>
     .profile-pic-wrapper {
  width: 30vw; /* square dimensions */
  height: 30vw;
  margin-left:20px;
  border-radius: 50%; /* makes the container circular */
  overflow: hidden; /* crops overflowing parts */
  border: 4px solid #333;
  box-shadow: 0 4px 10px rgb(0, 183, 255);
  display: flex;
  justify-content: center;
  align-items: center;
}

.profile-img {
  width: 35vw;
  height: 100%;
  object-fit: cover; /* zooms and crops the image to fill the circle */
}


      </style>
  </head>
  <body>
    <!-- header -->
    <header class="header">
      <a href="landing" class="logo">PortyPortfolio</a>

      <i class="bx bx-menu" id="menu-icon"></i>

      <nav class="navbar">
  <a href="#home" class="nav-link" data-target="home">Home</a>
  <a href="#about" class="nav-link" data-target="about">About</a>
  <a href="#portfolio" class="nav-link" data-target="portfolio">Projects</a>
  <a href="#contact" class="nav-link" data-target="contact">Contact Me</a>
</nav>

    </header>

  <script>
document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent URL hash change
    const targetId = this.getAttribute('data-target');
    const targetEl = document.getElementById(targetId);
    if (targetEl) {
      targetEl.scrollIntoView({ behavior: 'smooth' });
    }
  });
});
</script>
<style>
  html, body {
    scroll-behavior: smooth !important;
  }
</style>
    <!-- Home Section -->
<link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <section class="home" id="home">
      <div class="home-content">
        <h3>Hello, It's Me</h3>
        <h1><?= htmlspecialchars($profile['first_name'] ?? '') . ' ' . htmlspecialchars($profile['last_name'] ?? '') ?></h1>
        <h3>
  And I'm skilled in 
  <span 
    class="multiple-text"
    data-skills="<?= htmlspecialchars($profile['skills'] ?? '') ?>"
  ></span>
</h3>
          <?php if (!empty($profile['description'])): ?>
            <p> <?= nl2br(htmlspecialchars($profile['description'])) ?></p>
        <?php endif; ?>
        
        <?php if (
            !empty($profile['facebook']) || !empty($profile['twitter']) || !empty($profile['linkedin']) ||
            !empty($profile['instagram']) || !empty($profile['youtube'])
        ): ?>
            <div class="social-media">
                <?php if (!empty($profile['facebook'])): ?>
                    <a href="<?= htmlspecialchars($profile['facebook']) ?>" target="_blank"><i class="bx bxl-facebook"></i></a>
                <?php endif; ?>
                <?php if (!empty($profile['twitter'])): ?>
                    <a href="<?= htmlspecialchars($profile['twitter']) ?>" target="_blank"><i class="bx bxl-twitter"></i></a>
                <?php endif; ?>
                <?php if (!empty($profile['linkedin'])): ?>
                    <a href="<?= htmlspecialchars($profile['linkedin']) ?>" target="_blank"><i class="bx bxl-linkedin"></i></a>
                <?php endif; ?>
                <?php if (!empty($profile['instagram'])): ?>
                    <a href="<?= htmlspecialchars($profile['instagram']) ?>" target="_blank"><i class="bx bxl-instagram"></i></a>
                <?php endif; ?>
                <?php if (!empty($profile['youtube'])): ?>
                    <a href="<?= htmlspecialchars($profile['youtube']) ?>" target="_blank"><i class="bx bxl-youtube"></i></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
                  <?php if (!empty($profile['cv_filename'])): ?>
         <a href="<?= BASE_URL ?>public/uploads/cv/<?= htmlspecialchars($profile['cv_filename']) ?>" target="_blank" class="btn">Download CV</a>
        <?php endif; ?>
      </div>

      <div class="home-img">
          <?php if (!empty($profile['profile_picture'])): ?>
            <div class="profile-pic-wrapper">
  <img class="profile-img" src="<?= BASE_URL ?>public/uploads/<?= htmlspecialchars($profile['profile_picture']) ?>" alt="Profile Picture">
</div>

        <?php endif; ?>
      </div>
    </section>

    <!-- about -->
    <section class="about" id="about">
      <div class="about-content">
        <h2 class="heading">About <span>Me</span></h2>
        <?php if (!empty($profile['biography'])): ?>
            <p> <?= nl2br(htmlspecialchars($profile['biography'])) ?></p>
        <?php endif; ?>
        <a href="#" class="btn">Read More</a>
      </div>
    </section>

 

<style>.portfolio-box img {
    width: 100%;
    height: 300px; /* Adjust height as needed */
    object-fit: cover;
    display: block;
}</style>
    <!-- Portfolio Section -->
    <section class="portfolio" id="portfolio">
      <h2 class="heading">Latest <span>Project</span></h2>

      <div class="portfolio-container">
         <?php foreach ($projects as $project): ?>
        <div class="portfolio-box">
             <img src="<?= BASE_URL ?>public/uploads/<?= htmlspecialchars($project['image']) ?>" alt="">
          <div class="portfolio-layer">
             <h4><?= htmlspecialchars($project['title']) ?></h4>
            <p><?= htmlspecialchars($project['description']) ?></p>
            <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank"><i class="bx bx-link-external"></i></a>
          </div>
        </div>
  <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- contact -->

    <section class="contact" id="contact">
      <h2 class="heading">Contact <span>Me!</span></h2>

      <form action="send_email.php" method="post" enctype="text/plain">
        <div class="input-box">
          <input type="text" placeholder="Full Name" />
          <input type="email" placeholder="Email Address" />
        </div>
        <div class="input-box">
          <input type="number" placeholder="Mobile Number" />
          <input type="text" placeholder="Email Subject" />
        </div>
        <textarea
          name=""
          id=""
          cols="30"
          rows="10"
          placeholder="Your Message"
        ></textarea>
        <input type="submit" value="Send Message" class="btn" />
      </form>
    </section>

    <!-- footer -->

    <footer class="footer">
      <div class="footer-text">
  <p style="font-size: 1.4rem; color: var(--text-color);">
    <a href="admin" style="color: var(--main-color); text-decoration: none; font-weight: bold;">
      Create your own Portfolio
    </a>
  </p>
</div>


      <div class="footer-iconTap">
        <a href="#home"><i class="bx bx-up-arrow-alt"></i></a>
      </div>
    </footer>

    <!-- Scroll reveal -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- typed js -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

    <!-- custom js -->
    <script src="js/script.js"></script>
  </body>
</html>
