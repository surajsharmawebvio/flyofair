<!-- generate social bar vue component -->
<template>
  <div class="social-bar">
    <a href="https://facebook.com" target="_blank" class="facebook"><i class="fab fa-meta"></i></a>
    <a href="https://youtube.com" target="_blank" class="youtube"><i class="fab fa-youtube"></i></a>
    <a href="https://instagram.com" target="_blank" class="instagram"><i class="fab fa-instagram"></i></a>
    <a href="https://linkedin.com" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://pinterest.com" target="_blank" class="pinterest"><i class="fab fa-pinterest"></i></a>
    <a href="https://x.com" target="_blank" class="twitter"><i class="fab fa-x-twitter"></i></a>
  </div>
</template>

<script>
export default {
  name: 'SocialBar'
}
</script>

<style scoped>
.social-bar {
  position: fixed;
  top: 45%;
  left: 0;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  z-index: 1000;
}

.social-bar a {
  display: block;
  text-align: center;
  padding: 10px;
  color: white;
  font-size: 18px;
  transition: all 0.3s ease;
  margin: 1px 0;
}

.social-bar a i {
  width: 20px;
  height: 20px;
}

/* Colors for each platform */
.social-bar a.facebook { background: #1877f2; }
.social-bar a.youtube { background: #ff0000; }
.social-bar a.instagram { background: #e4405f; }
.social-bar a.linkedin { background: #0077b5; }
.social-bar a.pinterest { background: #bd081c; }
.social-bar a.twitter { background: #100034; }

/* Hover effect */
.social-bar a:hover {
  padding-left: 20px;
  border-radius: 0 5px 5px 0;
  opacity: 0.9;
}
</style>
