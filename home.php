<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<?php include 'components/search.php'; ?>


<section class="quick-select">


   <div class="box-container">

      <div class="box">
         <h3 class="title">Variety Categories</h3>
         <div class="flex">
            <a href="courses.php?"><i class="fas fa-code"></i><span>Development</span></a>
            <a href="courses.php"><i class="fas fa-chart-simple"></i><span>Business</span></a>
            <a href="courses.php"><i class="fas fa-pen"></i><span>Design</span></a>
            <a href="courses.php"><i class="fas fa-chart-line"></i><span>Marketing</span></a>
            <a href="courses.php"><i class="fas fa-music"></i><span>Music</span></a>
            <a href="courses.php"><i class="fas fa-camera"></i><span>Photography</span></a>
            <a href="courses.php"><i class="fas fa-cog"></i><span>Software</span></a>
            <a href="courses.php"><i class="fas fa-vial"></i><span>Science</span></a>
         </div>
      </div>

      <div class="box">
         <h3 class="title">Popular Topics</h3>
         <div class="flex">
            <a href="courses.php"><i class="fab fa-html5"></i><span>HTML</span></a>
            <a href="courses.php"><i class="fab fa-css3"></i><span>CSS</span></a>
            <a href="courses.php"><i class="fab fa-js"></i><span>javascript</span></a>
            <a href="courses.php"><i class="fab fa-react"></i><span>react</span></a>
            <a href="courses.php"><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="courses.php"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
         </div>
      </div>
       <div class="box tutor">
         <h3 class="title">Join us as a tutor</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, laudantium.</p>
         <a href="admin/register.php" target="blank" class="inline-btn">Get Started</a>
      </div>


      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">likes and comments</h3>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">view likes</a>
         <p>total comments : <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">view comments</a>
         <p>saved playlist : <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">view bookmark</a>
      </div>
      <?php
      }
      ?>


   </div>

</section>
 <section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h1 style="color: black; font-size: 4rem;">Why choose us?</h1>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque nobis distinctio, nisi consequatur ad sequi, rem odit fugiat assumenda eligendi iure aut sunt ratione, tempore porro expedita quisquam.</p>
         <a href="courses.php" class="inline-btn">our courses</a>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>+1k</h3>
            <span>online courses</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+25k</h3>
            <span>brilliants students</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>+5k</h3>
            <span>expert teachers</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-briefcase"></i>
         <div>
            <h3>100%</h3>
            <span>job placement</span>
         </div>
      </div>

   </div>

</section>

<!-- reviews section starts  -->

<section class="reviews" id="rev">

   <h1 class="heading">student's reviews</h1>

   <div class="box-container">
      <?php
         $select_reviews = $conn->prepare("SELECT * FROM `reviews` limit 3");
         $select_reviews->execute();

         if($select_reviews->rowCount() > 0){
            while($fetch_review = $select_reviews->fetch(PDO::FETCH_ASSOC)){
               $review_id = $fetch_review['id'];

               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_review['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

      ?>

      <div class="box">
         <p><?= $fetch_review['description']; ?></p>
         <div class="user">
            <img src="uploaded_files/<?= $fetch_user['image']; ?>">
            <div>
               <h3><?= $fetch_user['name']; ?></h3>
               <div class="stars">
                  <?php if($fetch_review['rating'] == 1){ ?>
            <i class="fas fa-star"></i>
         <?php }; ?> 
         <?php if($fetch_review['rating'] == 2){ ?>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
      
         <?php }; ?>
         <?php if($fetch_review['rating'] == 3){ ?>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         <?php }; ?>   
         <?php if($fetch_review['rating'] == 4){ ?>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         <?php }; ?>
         <?php if($fetch_review['rating'] == 5){ ?>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         <?php }; ?>
               </div>
            </div>
         </div>
             
      </div>
<?php
         }
      }else{
         echo '<p class="empty">no reviews added yet!</p>';
      }
      ?>

</div>
<div class="more-btn" style="text-align: center;">
      <a href="review.php" class="inline-option-btn" >view more</a>
   </div>
</section>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">latest courses</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? LIMIT 6");
         $select_courses->execute(['active']);
         if($select_courses->rowCount() >0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no courses added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">view more</a>
   </div>

</section>

<!-- courses section ends -->





<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>