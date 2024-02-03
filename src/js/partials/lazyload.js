// Usage example
// <img data-src="path/to/your/image.jpg" alt="Lazy-loaded Image" class="lazy">

// Function to load images asynchronously
async function loadImageAsync(img) {
  return new Promise((resolve, reject) => {
    const src = img.getAttribute('data-src');
    const imageElement = new Image();

    imageElement.onload = () => {
      img.setAttribute('src', src);
      img.classList.add('fade-in');
      resolve();
    };

    imageElement.onerror = () => {
      reject(new Error('Failed to load image'));
    };

    imageElement.src = src;
  });
}

// Function to lazy load images
async function lazyLoad(target) {
  const io = new IntersectionObserver(async (entries, observer) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        const img = entry.target;
        await loadImageAsync(img);
        observer.unobserve(img);
      }
    }
  });

  io.observe(target);
}

// Get all lazy load images
const lazyImages = document.querySelectorAll('.lazy');

lazyImages.forEach(lazyLoad);
