const audioList = [
  {
    title: "Ehsan Ali",
    country: "Palestine",
    sources: [{ src: "../audio/Ihsan.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Noor Qnebi",
    country: "Palestine",
    sources: [{ src: "../audio/Noor.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Mira Abdallah",
    country: "Palestine",
    sources: [{ src: "../audio/Mera.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Muhammad Naser",
    country: "Palestine",
    sources: [{ src: "../audio/Naser.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Ahmed Othman",
    country: "Palestine",
    sources: [{ src: "../audio/Othman.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Saja Fawaz",
    country: "Palestine",
    sources: [{ src: "../audio/Saja.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Muhamed Samy",
    country: "Palestine",
    sources: [{ src: "../audio/Sami.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Ahmed Al-Hamaida",
    country: "Palestine",
    sources: [{ src: "../audio/Hamaida.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Ahmed Essam",
    country: "Palestine",
    sources: [{ src: "../audio/Essam.mp3", type: "audio/mpeg" }],
  },
  {
    title: "Heba Gamal",
    country: "Palestine",
    sources: [{ src: "../audio/Heba.mp3", type: "audio/mpeg" }],
  },
];

const playIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M8 5v14l11-7z"/>
      </svg>`;

const pauseIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
      </svg>`;

const container = document.getElementById("audio-cards-container");
const audio = document.getElementById("hidden-player");
let currentPlayingIndex = null;

function createAudioCard(track, index) {
  const card = document.createElement("div");
  card.className = "audio-card";

  const button = document.createElement("button");
  button.className = "play-button";
  button.innerHTML = playIcon;

  const info = document.createElement("div");
  info.className = "info";

  const name = document.createElement("p");
  name.className = "name";
  name.textContent = track.title;

  const players = document.createElement("p");
  players.className = "players";
  players.textContent = `${index + 1} / ${audioList.length} Players •`;

  info.appendChild(name);
  info.appendChild(players);
  card.appendChild(button);
  card.appendChild(info);
  container.appendChild(card);

  button.addEventListener("click", () => {
    if (currentPlayingIndex === index && !audio.paused) {
      audio.pause();
      button.innerHTML = playIcon;
    } else {
      loadAndPlay(index, button);
    }
  });
}

function loadAndPlay(index, button) {
  const track = audioList[index];
  audio.innerHTML = "";
  track.sources.forEach((source) => {
    const s = document.createElement("source");
    s.src = source.src;
    s.type = source.type;
    audio.appendChild(s);
  });
  audio.load();
  audio.play();

  document.querySelectorAll(".play-button").forEach((btn, idx) => {
    btn.innerHTML = idx === index ? pauseIcon : playIcon;
  });

  currentPlayingIndex = index;
}

audioList.forEach((track, index) => createAudioCard(track, index));

audio.addEventListener("ended", () => {
  const nextIndex = (currentPlayingIndex + 1) % audioList.length;
  const nextBtn = document.querySelectorAll(".play-button")[nextIndex];
  loadAndPlay(nextIndex, nextBtn);
});
