function formatTime(seconds) {
    const min = Math.floor(seconds / 60).toString().padStart(2, '0');
    const sec = Math.floor(seconds % 60).toString().padStart(2, '0');
    return `${min}:${sec}`;
}

document.addEventListener('DOMContentLoaded', function () {
    const containers = document.querySelectorAll('.video-container');
    const videos = document.querySelectorAll('.hover-video');


    containers.forEach(container => {
        const video = container.querySelector('video');
        const timer = container.querySelector('.video-timer');

        video.addEventListener('loadedmetadata', () => {
            const duration = formatTime(video.duration);
            timer.textContent = `00:00 / ${duration}`;
        });

        video.addEventListener('timeupdate', () => {
            const current = formatTime(video.currentTime);
            const duration = formatTime(video.duration);
            timer.textContent = `${current} / ${duration}`;
        });

        video.addEventListener('mouseenter', () => video.play());
        video.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0;
        });
    });
    videos.forEach(video => {
        video.addEventListener('mouseenter', () => {
            video.play();
        });
        video.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0; // Reset ke awal, opsional
        });
    });
});