<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="main.css" />
	<title>Home page</title>
</head>
<body>
	<div class="slider-container">
	    <img class="slider-item active" src="img/1.jpg" alt="Image 1">
	    <img class="slider-item" src="img/2.png" alt="Image 2">
	    <img class="slider-item" src="img/4.png" alt="Image 4">
	    <img class="slider-item" src="img/5.png" alt="Image 5">
	</div>

	<button class="prev" onclick="prevSlide()"><i class="bi bi-chevron-left"></i></button>
	<button class="next" onclick="nextSlide()"><i class="bi bi-chevron-right"></i></button>

	<script>
	    let currentIndex = 0;
	    const slides = document.querySelectorAll('.slider-item');

	    function showSlide(index) {
	        slides.forEach(slide => slide.style.display = 'none');
	        slides[index].style.display = 'block';
	    }

	    function nextSlide() {
	        currentIndex = (currentIndex + 1) % slides.length;
	        showSlide(currentIndex);
	    }

	    function prevSlide() {
	        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
	        showSlide(currentIndex);
	    }

	    showSlide(currentIndex);
	</script>

</body>
</html>