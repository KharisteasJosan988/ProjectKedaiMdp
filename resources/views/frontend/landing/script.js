document.getElementById('buyNowButton').addEventListener('click', () => {
    // Redirect to the desired URL
    window.location.href = 'https://kedaimdp.com/menu';
});

// Make the "Beli Sekarang" button responsive
const buyNowButton = document.getElementById('buyNowButton');

window.addEventListener('resize', () => {
    if (window.innerWidth <= 600) {
        buyNowButton.style.width = '100%';
    } else {
        buyNowButton.style.width = 'auto';
    }
});

// Set the initial width of the "Beli Sekarang" button
if (window.innerWidth <= 600) {
    buyNowButton.style.width = '100%';
}
