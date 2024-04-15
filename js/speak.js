var synth = window.speechSynthesis;
var aliases = document.getElementsByTagName('ul');
var text = '';
for (var i = 0; i < aliases.length; i++) {
    text += aliases[i].textContent + ', ';
}
var utterance = new SpeechSynthesisUtterance(text);
var paused = false;

document.getElementById('playButton').addEventListener('click', function() {
    if (paused) {
        synth.resume();
    } else {
        synth.speak(utterance);
    }
    paused = false;
});

document.getElementById('pauseButton').addEventListener('click', function() {
    synth.pause();
    paused = true;
});

document.getElementById('restartButton').addEventListener('click', function() {
    synth.cancel();
    synth.speak(utterance);
});