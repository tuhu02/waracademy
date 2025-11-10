let bgMusic = null;

// Inisialisasi musik
export function initMusic(src) {
    if (!bgMusic) {
        bgMusic = new Audio(src);
        bgMusic.loop = true;

        // Ambil volume & mute dari localStorage
        const savedVol = localStorage.getItem("bgmVolume");
        const savedMute = localStorage.getItem("bgmEnabled");

        bgMusic.volume = savedVol ? parseFloat(savedVol) : 0.5;
        bgMusic.muted = savedMute === "false" ? true : false;

        bgMusic.play().catch(() => {});
    }
    return bgMusic;
}

// Fade-in musik
export function fadeInMusic(duration = 2000) {
    if (!bgMusic) return;
    let step = 50;
    let targetVolume = bgMusic.volume;
    bgMusic.volume = 0;
    bgMusic.play().catch(() => {});
    let fadeAmount = targetVolume / (duration / step);

    let fadeInterval = setInterval(() => {
        if (bgMusic.volume + fadeAmount < targetVolume) {
            bgMusic.volume += fadeAmount;
        } else {
            bgMusic.volume = targetVolume;
            clearInterval(fadeInterval);
        }
    }, step);
}

// Fade-out musik
export function fadeOutMusic(duration = 1500, callback) {
    if (!bgMusic) return;
    let step = 50;
    let fadeAmount = bgMusic.volume / (duration / step);

    let fadeInterval = setInterval(() => {
        if (bgMusic.volume - fadeAmount > 0) {
            bgMusic.volume -= fadeAmount;
        } else {
            bgMusic.volume = 0;
            bgMusic.pause();
            clearInterval(fadeInterval);
            if (callback) callback();
        }
    }, step);
}

// Toggle musik on/off
export function toggleMusic(enabled) {
    if (!bgMusic) return;
    bgMusic.muted = !enabled;
    localStorage.setItem("bgmEnabled", enabled ? "true" : "false");
}

// Set volume
export function setVolume(vol) {
    if (!bgMusic) return;
    bgMusic.volume = vol;
    localStorage.setItem("bgmVolume", vol);
}

// Ambil status musik saat ini
export function getMusicStatus() {
    return {
        volume: bgMusic ? bgMusic.volume : 0.5,
        muted: bgMusic ? bgMusic.muted : false
    };
}
