// public/js/music.js
export function initMusic(path) {
    let audio = document.getElementById('bgMusic');
  
    if (!audio) {
      audio = document.createElement('audio');
      audio.id = 'bgMusic';
      audio.loop = true;
      audio.src = path;
      document.body.appendChild(audio);
    }
  
    // Ambil pengaturan dari localStorage
    const volume = parseFloat(localStorage.getItem('volume')) || 0.5;
    const muted = localStorage.getItem('muted') === 'true';
  
    audio.volume = volume;
    if (!muted) audio.play();
  
    return audio;
  }
  
  // Fade Out
  export function fadeOutMusic(duration = 1000, callback) {
    const audio = document.getElementById('bgMusic');
    if (!audio) return;
    const step = 50;
    const fadeAmount = audio.volume / (duration / step);
    const fadeInterval = setInterval(() => {
      if (audio.volume - fadeAmount > 0) {
        audio.volume -= fadeAmount;
      } else {
        audio.volume = 0;
        clearInterval(fadeInterval);
        audio.pause();
        if (callback) callback();
      }
    }, step);
  }
  
  // Fade In
  export function fadeInMusic(duration = 1000) {
    const audio = document.getElementById('bgMusic');
    if (!audio) return;
    const targetVol = parseFloat(localStorage.getItem('volume')) || 0.5;
    const step = 50;
    const fadeAmount = targetVol / (duration / step);
    audio.volume = 0;
    audio.play();
    const fadeInterval = setInterval(() => {
      if (audio.volume + fadeAmount < targetVol) {
        audio.volume += fadeAmount;
      } else {
        audio.volume = targetVol;
        clearInterval(fadeInterval);
      }
    }, step);
  }
  
  // Toggle Musik
  export function toggleMusic(enabled) {
    const audio = document.getElementById('bgMusic');
    if (!audio) return;
    if (enabled) {
      localStorage.setItem('muted', 'false');
      fadeInMusic(600);
    } else {
      localStorage.setItem('muted', 'true');
      fadeOutMusic(600);
    }
  }
  
  // Ubah Volume
  export function setVolume(value) {
    const audio = document.getElementById('bgMusic');
    if (!audio) return;
    audio.volume = value;
    localStorage.setItem('volume', value);
  }
  